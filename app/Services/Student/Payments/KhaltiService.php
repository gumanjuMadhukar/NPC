<?php
namespace App\Services\Student\Payments;

use App\Models\CertificateRequest;
use App\Models\ExamApply;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class KhaltiService implements PaymentGatewayInterface
{
    protected string $baseUrl;
    protected string $secretKey;

    public function __construct()
    {
        $mode = env('MODE'); // Ensure this environment variable is set correctly (e.g., 'production' or 'development')
        if ($mode == 'production') {
            $this->baseUrl   = config('services.khalti.base_url');
            $this->secretKey = config('services.khalti.secret_key');
        } else {
            $this->baseUrl   = config('services.khalti.test_base_url');
            $this->secretKey = config('services.khalti.test_secret_key');
        }

        // Basic validation to ensure keys are loaded
        if (empty($this->baseUrl) || empty($this->secretKey)) {
            Log::error('Khalti service configuration missing. Check .env and config/services.php');
            // Depending on your application's error handling, you might throw an exception here
            // or ensure fallback behavior. For now, it will likely cause a later error.
        }
    }

    public function initiate(Request $request, string $purpose)
    {
        $collegeLocation = $request->input('college_location');

        // Calculate amount based on purpose and college_location
        $amount = match ($purpose) {
            'certificateIssuance' => match ($request['level_id']) {
                '1' => $collegeLocation === 'international' ? 4050 : 2050, // Amount for level 1
                '2' => $collegeLocation === 'international' ? 3050 : 1550, // Amount for level 2
                '3' => $collegeLocation === 'international' ? 2050 : 1050, // Amount for level 3
                default => $collegeLocation === 'international' ? 2050 : 1050, // Default amount
            },
            'examApply' => $collegeLocation === 'international' ? 3000 : 3000, // Example amount
            // 'certificateRenew' => $collegeLocation === 'international' ? 3000 : 2000, // Example amount for renewal
            default => abort(400, 'Unknown payment purpose'),
        } * 100; // Convert to paisa

        // dd('here',$amount);

        // Store request data in session for retrieval in callback
        // This is crucial for examApply purpose to get exam_id, level_id, program_id
        session([
            'payment_data' => [
                'exam_id'    => $request->exam_id ?? null,
                'level_id'   => $request->level ?? $request->level_id ?? null,
                'program_id' => $request->program ?? $request->program_id ?? null,
                'symbol_number' => $request->symbol_number ?? null, // For certificate issuance/renewal
                'purpose' => $purpose, // Store purpose to use in callback
            ]
        ]);


        Log::info('Khalti payment initiation request.', [
            'user_id' => Auth::guard('student')->id(),
            'purpose' => $purpose,
            'amount' => $amount,
            'session_data' => session('payment_data'),
        ]);

        $returnUrl = route('student-payment-callback', ['gateway' => 'khalti', 'purpose' => $purpose]);

        $response = Http::withHeaders([
            'Authorization' => "Key {$this->secretKey}",
            'Content-Type'  => 'application/json',
        ])->post("{$this->baseUrl}epayment/initiate/", [
            'return_url'          => $returnUrl,
            'website_url'         => config('app.url'),
            'amount'              => $amount,
            'purchase_order_id'   => $request->user('student')->email, // Unique ID for this transaction
            'purchase_order_name' => ucfirst($purpose) . ' Payment',
            'customer_info'       => [
                'name' => $request->user('student')->name ?? 'NHPC - Nepal Health Professional Council', // Use student guard
                'email' => $request->user('student')->email ?? 'info@example.com', // Add email if available
                'phone' => $request->user('student')->phone ?? 'N/A', // Add phone if available
            ],
            // Add any other required parameters by Khalti API
        ]);

        $body = $response->json();
        // dd($response->json());
        if ($response->successful() && isset($body['payment_url'])) {
            Log::info('Khalti initiation successful.', ['payment_url' => $body['payment_url']]);
            return redirect($body['payment_url']);
        }

        Log::error('Khalti initiation failed.', ['response_body' => $body, 'status' => $response->status()]);
        return redirect()
            ->back()
            ->with('error', 'Failed to initiate payment. Please try again later. Khalti Error: ' . ($body['detail'] ?? 'Unknown error'));
    }

    public function callback(Request $request, string $purpose)
    {

        $pidx = $request->query('pidx');
        $status = $request->query('status'); // Khalti also sends a 'status' query parameter for initial check

        Log::info('Khalti payment callback hit.', [
            'query_params' => $request->query(),
            'user_id' => Auth::guard('student')->id(),
            'purpose' => $purpose,
        ]);

        if (! $pidx) {
            Log::warning('Khalti callback: Missing pidx.', ['query_params' => $request->query()]);
            return redirect()->route('student-dashboard')->with('error', 'Payment failed or was cancelled. Missing payment reference.');
        }

        // Retrieve session data
        $paymentData = session('payment_data');
        if (! $paymentData) {
            Log::error('Khalti callback: Payment data not found in session. This is the error you are seeing.', ['pidx' => $pidx, 'user_id' => Auth::guard('student')->id()]);
            return redirect()->route('student-dashboard')->with('error', 'Payment data not found. Please try again or contact support.');
        }

        // Merge session data into request for easier use in this method
        $request->merge([
            'exam_id'    => $paymentData['exam_id'] ?? null,
            'level_id'   => $paymentData['level_id'] ?? null,
            'program_id' => $paymentData['program_id'] ?? null,
            'symbol_number' => $paymentData['symbol_number'] ?? null,
            'payment_type' => $paymentData['payment_type'] ?? 'online',
            'payment_method' => $paymentData['payment_method'] ?? 'Khalti_Web',
            'purpose' => $paymentData['purpose'] ?? $purpose, // Use purpose from session if available
        ]);
        // Verify the payment status with Khalti
        $response = Http::withHeaders([
            'Authorization' => "Key {$this->secretKey}",
            'Content-Type'  => 'application/json',
        ])->post("{$this->baseUrl}epayment/lookup/", [
            'pidx' => $pidx,
        ]);

        $verificationData = $response->json();
        $paymentStatus = $verificationData['status'] ?? 'Failed'; // Default to Failed if status is missing

        if ($paymentStatus === 'Completed') {
            DB::beginTransaction();

            try {
                // Ensure user_id is correctly fetched
                $userId = Auth::guard('student')->id();
                if (!$userId) {
                    throw new \Exception('Authenticated student user ID not found.');
                }

                 $createdPayment = Payment::create([
                    'user_id'             => $userId,
                    'exam_id'             => $request->exam_id,
                    'level_id'            => $request->level_id,
                    'program_id'          => $request->program_id,
                    'purpose'             => $request->purpose, // Use purpose from merged request
                    'pidx'                => $pidx,
                    'transaction_id'      => $verificationData['transaction_id'] ?? null,
                    'tidx'                => $verificationData['tidx'] ?? null,
                    'txtId'               => $verificationData['txtId'] ?? null, // Khalti might use txtId or transaction_id
                    'amount'              => ($verificationData['amount'] ?? 0) / 100, // Convert back from paisa to rupees
                    'total_amount'        => ($verificationData['total_amount'] ?? 0) / 100, // Convert back
                    'status'              => $paymentStatus,
                    'payment_method'              => $request->payment_method ?? 'Khalti',
                    'payment_type'              => $request->payment_type ??'online',
                    'mobile'              => $request->query('mobile'), // From initial Khalti redirect
                    'purchase_order_id'   => $request->query('purchase_order_id'), // From initial Khalti redirect
                    'purchase_order_name' => $request->query('purchase_order_name'), // From initial Khalti redirect
                    'paid_at'             => now(),
                ]);
                Log::info('Payment table', [
                    'payment_id' => $createdPayment->id,
                    'pidx' => $pidx,
                    'verification_data' => $verificationData,
                    'payment_status' => $paymentStatus,
                ]);
                // dd('here');
                if ($request->purpose === 'examApply') {
                    // Check if an existing ExamApply record is pending payment for this user and exam
                    $examApplyRecord = ExamApply::where([
                        'user_id' => $userId,
                        'exam_id' => $request->exam_id,
                        'level_id' => $request->level_id,
                        'program_id' => $request->program_id,
                        'status' => 'pending_payment', // Or whatever status indicates payment is awaited
                    ])->first();

                    if ($examApplyRecord) {
                        // Update existing record
                        $examApplyRecord->status = 'progress'; // Or 'applied', 'submitted'
                        $examApplyRecord->state = 'operator';
                        $examApplyRecord->save();
                        Log::info('Updated existing ExamApply record after Khalti payment.', ['exam_apply_id' => $examApplyRecord->id]);
                    } else {
                        // Create new record if none exists or if it's a re-exam
                        $previousExamStatus = ExamApply::where([
                            'user_id' => $userId,
                            'is_passed' => '0', // Assuming 0 means not passed
                            'is_admit_card_generate' => 1, // Assuming this indicates a previous attempt
                        ])->orderBy('created_at', 'desc')->first();

                        $exam_apply = new ExamApply();
                        $exam_apply->user_id    = $userId;
                        $exam_apply->exam_id    = $request->exam_id ?? null;
                        $exam_apply->level_id   = $request->level_id ?? $createdPayment->level_id ;
                        $exam_apply->program_id = $request->program_id ?? $createdPayment->program_id;
                        $exam_apply->status     = $previousExamStatus ? 're-exam' : 'progress';
                        $exam_apply->state      = 'operator';
                        $exam_apply->attempt    = $previousExamStatus ? $previousExamStatus->attempt + 1 : 1;
                        $exam_apply->save();
                        Log::info('Created new ExamApply record after Khalti payment.', ['exam_apply_id' => $exam_apply->id]);
                    }
                } elseif ($request->purpose === 'certificateIssuance') {
                    $certificateApply = new CertificateRequest();
                    $certificateApply->user_id= $userId;
                    $certificateApply->exam_id= $request->exam_id ?? null;
                    $certificateApply->level_id   = $request->level_id ?? null ;
                    $certificateApply->program_id = $request->program_id ?? null ;
                    $certificateApply->symbol_number = $request->symbol_number ?? null ;
                    $certificateApply->amount = ($verificationData['total_amount'] ?? 0) / 100; // Convert back from paisa to rupees;
                    $certificateApply->payment_id = $createdPayment->id;
                    // dd($certificateApply);
                    $certificateApply->save();

                    $callbackResponseData = [
                        'data' => $certificateApply,
                        'message' => 'Certificate Issuance Applied Successfully',
                        'error' => null,
                        'status' => 200,
                    ];
                    // You can log this data if needed, but don't try to assign it to $khaltiResponse
                    Log::info('Certificate Issuance payment completed.', ['symbol_number' => $request->symbol_number, 'callback_response' => $callbackResponseData]);
                } elseif ($request->purpose === 'certificateRenew') {
                    // Logic for certificate renewal after payment
                    // Update the certificate status or renewal request status
                    Log::info('Certificate Renewal payment completed.', ['symbol_number' => $request->symbol_number]);
                }

                DB::commit();

                // Clear session data after successful processing
                session()->forget('payment_data');

                return redirect()->route('student-dashboard')->with('success', ucfirst($request->purpose) . ' payment successful.');
            } catch (\Exception $e) {
                DB::rollBack();

                Log::error('Error saving Khalti payment or updating related records.', [
                    'message' => $e->getMessage(),
                    'user_id' => Auth::guard('student')->id(),
                    'pidx' => $pidx,
                    'verification_data' => $verificationData,
                    'exception' => $e,
                ]);

                return redirect()->route('student-dashboard')->with('error', 'Payment was successful, but we failed to record it. Please contact support.');
            }
        } else {
            Log::warning('Khalti payment verification failed or not completed.', [
                'pidx' => $pidx,
                'verification_data' => $verificationData,
                'payment_status' => $paymentStatus,
            ]);
        }

        // Clear session data even if payment failed or was not completed, to prevent stale data
        session()->forget('payment_data');

        return redirect()->route('student-dashboard')->with('error', ucfirst($request->purpose) . ' payment failed or not completed. Status: ' . $paymentStatus);
    }
}
