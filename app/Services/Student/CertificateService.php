<?php
namespace App\Services\Student;

use App\Models\CertificateRequest;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ForeignCertificateRequest;
use App\Traits\StoreImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CertificateService
{
    use StoreImageTrait;
    public function list()
    {
        try {
            $current_date = Carbon::now('UTC')->format("Y-m-d");
            $data['exams'] = Exam::select('*')->where('status', 1)->where('opening_date', '<=', $current_date)->where('closing_date', '>=', $current_date)->get();
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function saveCertificateApply($request)
    {
        try {
            $user_id = Auth::Guard('student')->id();
            // dd('here');
            // Check if the user has already applied
            $existingApplication = CertificateRequest::where('symbol_number', $request['symbol_number'])
                ->first();
            if ($existingApplication) {

                return response()->json([
                    'message' => 'You have already applied for certificate request.',
                    'error' => null,
                    'status' => 406,
                ], 406);
            }

            $certificateApply = new CertificateRequest();
            if (preg_match('#^data:image.*?base64,#', $request['voucher_image'])) {
                $voucher_image = $this->StoreBase64Image($request['voucher_image'], '/student/voucher/');
            } else {
                $voucher_image = ($request['voucher_image']) ? $request['voucher_image'] : null;
            }
            // dd('here',$request['exam_id']);
            $certificateApply->user_id = $request['user_id'];
            $certificateApply->exam_id = $request['exam_id'];
            $certificateApply->level_id = $request['level_id'];
            $certificateApply->program_id = $request['program_id'];
            $certificateApply->symbol_number= $request['symbol_number'];
            $certificateApply->amount = $request['amount'];

            $certificateApply->voucher_image = $voucher_image;
            // dd($certificateApply);
            $certificateApply->save();

            $response['data'] = $certificateApply;
            $response['message'] = 'Certificate Print Applied Successfully';
            $response['error'] = null;
            $response['success'] = true;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
