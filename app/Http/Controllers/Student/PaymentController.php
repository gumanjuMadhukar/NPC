<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AdmitCard;
use App\Models\CertificateRequest;
use App\Models\ExamApply;
use App\Services\Student\Payments\EsewaService;
use App\Services\Student\Payments\IMEPayService;
use App\Services\Student\Payments\KhaltiService;
use App\Services\Student\Payments\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function initiate(Request $request, string $gateway, string $purpose)
    {
        $request->validate([
            'symbol_number' => 'required|string',
        ]);

        $symbol_number = $request->input('symbol_number');

        $applicant = AdmitCard::with(['exam_apply.certificate', 'exam_apply.certificate_apply'])
            ->where('symbol_number', $symbol_number)
            ->first();

        if (! $applicant) {
            return back()->with('error', 'Invalid symbol number or applicant not found.');
        }

        $examApply = $applicant->exam_apply;

        if (! $examApply) {
            return back()->with('error', 'No exam application found for this symbol number.');
        }

        $certificate = $examApply->certificate instanceof \Illuminate\Support\Collection
        ? $examApply->certificate->first()
        : $examApply->certificate;

        if ($examApply->is_passed == 1 && $certificate && $certificate->is_printed == 1) {
            return back()->with('error', 'Your certificate has already been printed.');
        }

        $search_apply = $examApply->certificate_apply;
        if ($search_apply !== null) {
            return back()->with('error', 'You have already applied for certificate print.');
        }

        $request->merge(['applicant_detail' => $applicant]);

        try {
            $service = $this->resolveGateway($gateway);
            return $service->initiate($request, $purpose);
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while initiating: ' . $e->getMessage());
        }
    }

    public function initiate1(Request $request, string $gateway, string $purpose)
    {
        $symbol_number = $request->input('symbol_number');

        if (in_array($purpose, ['certificateIssuance', 'certificateRenew'])) {
            $request->validate([
                'symbol_number' => 'required|string',
            ]);
        } elseif ($purpose === 'examApply') {
        } else {
            return back()->with('error', 'Invalid purpose specified.');
        }

        if (in_array($purpose, ['certificateIssuance', 'certificateRenew'])) {

            $symbol_number = $request->input('symbol_number');

            $relations = match ($purpose) {
                'certificateIssuance' => ['exam_apply.certificate', 'exam_apply.certificate_apply'],
                'certificateRenew' => ['exam_apply.certificate'],
            };

            $applicant = AdmitCard::with($relations)
                ->where('symbol_number', $symbol_number)
                ->first();

            if (! $applicant) {
                return back()->with('error', 'Invalid symbol number or applicant not found.');
            }

            $examApply = $applicant->exam_apply;

            if (! $examApply) {
                return back()->with('error', 'No exam application found for this symbol number.');
            }

            $isValid = match ($purpose) {
                'certificateIssuance' => $this->handleCertificateIssuance($examApply, $symbol_number),
                'certificateRenew' => $this->handleCertificateRenew($examApply),
            };

            if (! $isValid) {
                return back();
            }
            $request->merge(['applicant_detail' => $applicant]);
        }

        if ($purpose === 'examApply') {
            $applicant  = ExamApply::where('user_id', Auth::Guard('student')->id())->first();
            $exam_apply = ExamApply::where(['user_id' => Auth::guard('student')->id(), 'exam_id' => $request['exam_id']])->first();
            if ($exam_apply) {
                $response['data']    = $exam_apply;
                $response['message'] = null;
                $response['error']   = 'You have already applied for this program.';
                $response['status']  = 406;
                return response()->json($response, $response['status']);
            }
            if (! $applicant) {
            }
        }

        try {
            $service = $this->resolveGateway($gateway);
            return $service->initiate($request, $purpose);
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function callback(Request $request, string $gateway, string $purpose)
    {
        $service = $this->resolveGateway($gateway);
        return $service->callback($request, $purpose);
    }

    private function resolveGateway(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'khalti' => new KhaltiService(),
            'esewa' => new EsewaService(),
            'imepay' => new IMEPayService(),
            default => abort(404, 'Unsupported payment gateway.'),
        };
    }

    private function handleCertificateIssuance($examApply, $symbol_number):bool
    {

        $existingApplication = CertificateRequest::where('symbol_number', $symbol_number)
        ->first();
        if ($existingApplication) {

            session()->flash('error', 'You have already requested for a certificate.');
            return false;
        }

        $certificate = $examApply->certificate instanceof \Illuminate\Support\Collection
        ? $examApply->certificate->first()
        : $examApply->certificate;

        if ($examApply->is_passed != 1) {

            session()->flash('error', 'You must pass the exam to request a certificate.');
            return false;
        }

        if ($certificate && $certificate->is_printed == 1) {
            session()->flash('error', 'Your certificate has already been printed.');
            return false;
        }

        if ($examApply->certificate_apply !== null) {
            session()->flash('error', 'You have already applied for certificate print.');
            return false;
        }

        return true;
    }

    private function handleCertificateRenew($examApply): bool
    {
        $certificate = $examApply->certificate instanceof \Illuminate\Support\Collection
        ? $examApply->certificate->first()
        : $examApply->certificate;

        if (! $certificate) {
            session()->flash('error', 'No certificate found to renew.');
            return false;
        }

        if (! $certificate->is_expired) {
            session()->flash('error', 'Your certificate is not expired yet.');
            return false;
        }

        if ($certificate->renewal_requested) {
            session()->flash('error', 'Renewal already requested.');
            return false;
        }

        return true;
    }

    private function handleExamApply($examApply): bool
    {
        if ($examApply->status === 'approved') {
            session()->flash('error', 'You have already applied and been approved.');
            return false;
        }

        return true;
    }
}
