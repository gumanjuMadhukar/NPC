<?php
namespace App\Services\Api;

use App\Models\AdmitCard;
use App\Models\Certificate;
use App\Models\CertificateRenewRequest;
use App\Models\ExamApply;
use App\Models\Level;
use App\Models\Program;
use App\Traits\StoreImageTrait;
use Illuminate\Http\Request;

class OnlinePaymentService
{
    use StoreImageTrait;

    public function findUser($request)
    {
        // dd($request['cert_registration_number']);
        $cert_check = Certificate::where('cert_registration_number', $request['cert_registration_number'])->first();

        if (! $cert_check) {
            return response()->json([
                'message' => 'Certificate not found for this registration number.',
                'error'   => null,
                'status'  => 404,
            ], 404);
        }
        $program    = Program::find($cert_check->program_id);
        $level      = Level::find($cert_check->level_id);
        $exam_apply = ExamApply::find($cert_check->level_id);

        if ($cert_check) {
            $user_data = [
                'user_id'                         => $cert_check->user_id,
                'name'                            => $cert_check->name,
                'date_of_birth'                   => $cert_check->date_of_birth,
                'program_name'                    => $program ? $program->name : null,
                'program_id'                      => $program ? $program->id : null,
                'level_name'                      => $level ? $level->name : null,
                'level_id'                        => $level ? $level->id : null,
                'certificate_id'                  => $cert_check->id,
                'certificate_registration_number' => $cert_check->cert_registration_number,
            ];

            // Check if user_id is null and update the message
            if ($user_data['user_id'] === null) {
                return response()->json([
                    'data'    => [
                        'user_data' => $user_data,
                    ],
                    'message' => 'User Id is missing. Please update your KYC',
                    'error'   => null,
                    'status'  => 400,
                ], 400);
            }

            return response()->json([
                'data'    => [
                    'user_data' => $user_data,
                ],
                'message' => '',
                'error'   => null,
                'status'  => 200, // Successful response
            ], 200);
        } else {
            return response()->json('Data Not Found', 404); // If no data is found
        }
    }
    public function findNewCertUser($request)
    {
        // $cert_check = ExamApply::with(['admit_card'])
        //     ->whereHas('admit_card', function ($qry) use ($request) {
        //         $qry->where('symbol_number', $request['symbol_number']);
        //     })
        //     ->get();
        $cert_check = ExamApply::with([
            'admit_card:id,exam_apply_id,symbol_number',
            'program:id,name',
            'level:id,name'
        ])
        ->select('id as exam_apply_id', 'user_id', 'program_id', 'level_id')
        ->where('is_certificate_generate', 1)
        ->whereHas('admit_card', function ($query) use ($request) {
            $query->where('symbol_number', $request['symbol_number']);
        })
        ->first();

        if (! $cert_check) {
            return response()->json([
                'message' => 'Certificate not found for this registration number.',
                'error'   => null,
                'status'  => 404,
            ], 404);
        }
        // dd($cert_check->user_id,"dhs", $request);

        $user_data = [
            'user_id'                         => $cert_check->user_id,
            'symbol_number' => $cert_check->symbol_number,
            'name'                            => $cert_check->name,
            'date_of_birth'                   => $cert_check->date_of_birth,
            'program_name'                    => optional($cert_check->program)->name,
            'program_id'                      => optional($cert_check->program)->id,
            'level_name'                      => optional($cert_check->level)->name,
            'level_id'                        => optional($cert_check->level)->id,
            'certificate_registration_number' => $cert_check->cert_registration_number,
        ];
        // dd( $user_data, $cert_check,"dhs", $request);

        if (is_null($user_data['user_id'])) {
            return response()->json([
                'data'    => ['user_data' => $user_data],
                'message' => 'User Id is missing. Please update your KYC',
                'error'   => null,
                'status'  => 400,
            ], 400);
        }

        return response()->json([
            'data'    => ['user_data' => $user_data],
            'message' => '',
            'error'   => null,
            'status'  => 200,
        ], 200);
    }

    public function certificateRenew($request)
    {
        try {
            $query = Certificate::with(['user.info']) // Eager load user and their info
                ->whereHas('user.info', function ($qry) {
                    $qry->whereNotNull('first_name')
                        ->whereNotNull('last_name');
                });

            if (! empty($request['q'])) {
                $q = $request['q'];
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->where(function ($subQry) use ($q) {
                        $subQry->where('name', 'LIKE', '%' . $q . '%')
                            ->orWhere('email', 'LIKE', '%' . $q . '%')
                            ->orWhere('phone', 'LIKE', '%' . $q . '%');
                    });
                });
            }

            if (! empty($request['cert_number'])) {
                $query->where('cert_registration_number', $request['cert_number']);
            }

            $certificates = $query->orderBy('id', 'desc')->paginate(10)
                ->appends([
                    'q'           => $request['q'] ?? null,
                    'cert_number' => $request['cert_number'] ?? null,
                ]);

            return response()->json([
                'data'    => $certificates,
                'message' => null,
                'error'   => null,
                'status'  => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error retrieving certificates: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function certificateRenewStore($request)
    {

        try {
            $exists = CertificateRenewRequest::where('user_id', $request['user_id'])
                ->where('cert_registration_number', $request['cert_registration_number'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'You have already requested a certificate renewal.',
                    'error'   => null,
                    'status'  => 400,
                ], 400);
            }

            // Handle voucher image if present
            $imagePath = null;
            if (request()->hasFile('voucher_image')) {
                $image     = request()->file('voucher_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('voucher_images', $imageName, 'public');
            }

            // Create record
            $certRenewRequest = CertificateRenewRequest::create([
                'user_id'                  => $request['user_id'],
                'level_id'                 => $request['level_id'],
                'program_id'               => $request['program_id'],
                'cert_registration_number' => $request['cert_registration_number'],
                'transaction_id'           => $request['transaction_id'],
                'txnId'                    => $request['txnId'] ?? null,
                'tidx'                     => $request['tidx'] ?? null,
                'voucher_image'            => $imagePath,
                'amount'                   => $request['amount'],
                'total_amount'             => $request['total_amount'] ?? null,
                'status'                   => $request['status'] ?? 'pending',
                'cert_status'              => $request['cert_status'] ?? 'active',
                'purchase_order_name'      => $request['purchase_order_name'] ?? null,
                'purchase_order_id'        => $request['purchase_order_id'] ?? null,
                'mobile'                   => $request['mobile'] ?? null,
            ]);

            return response()->json([
                'data'    => $certRenewRequest,
                'message' => 'Successfully applied for certificate renewal.',
                'error'   => null,
                'status'  => 200,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error'  => 'Error processing renewal request: ' . $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    public function certificateIssuanceStore($validated)
    {
        try {
            // Optional: Validate wallet transaction here if needed

            // Optional: Process voucher image
            $voucherImageName = null;
            if (! empty($validated['voucher_image'])) {
                $voucherImageName = $this->processVoucherImage($validated['voucher_image']);
            }

            // Save certificate record
            $certificate = Certificate::create([
                'user_id'                  => $validated['user_id'],
                'name'                     => $validated['name'],
                'date_of_birth'            => $validated['date_of_birth'],
                'cert_registration_number' => $validated['cert_registration_number'],
                'program_id'               => $validated['program_id'],
                'level_id'                 => $validated['level_id'],
                'voucher_image'            => $voucherImageName,
                'status'                   => 'issued', // or 'pending' if review is needed
            ]);

            return response()->json([
                'data'    => $certificate,
                'message' => 'Certificate issued successfully.',
                'error'   => null,
                'status'  => 200,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error'  => 'Error issuing certificate: ' . $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    // public function processVoucherImage($image)
    // {
    //                                          // Define the folder where images should be stored
    //     $folderPath = 'certificateRenewReq'; // This is the folder in the public directory

    //     // Get the file extension of the image
    //     $extension = $image->getClientOriginalExtension();

    //     // Validate file types (for example: images and PDFs)
    //     $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

    //     if (!in_array(strtolower($extension), $validExtensions)) {
    //         return response()->json([
    //             'message' => 'Invalid file type. Only image and PDF files are allowed.',
    //             'status'  => 400,
    //         ], 400);
    //     }

    //     // Generate a unique filename for the image
    //     $imageName = uniqid() . '.' . $extension;

    //     // Store the image in the specified folder and return the image name
    //     $image->move(public_path($folderPath), $imageName);

    //     return $imageName;
    // }
    public function processVoucherImage($image)
    {
        $folderPath = 'certificateRenewReq'; // Will go under storage/app/public

        $extension       = $image->getClientOriginalExtension();
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

        if (! in_array(strtolower($extension), $validExtensions)) {
            throw new \Exception('Invalid file type. Only image and PDF files are allowed.');
        }

        // Store in storage/app/public/certificateRenewReq
        $path = $image->store($folderPath, 'public');

        return basename($path); // Return just the filename
    }
}
