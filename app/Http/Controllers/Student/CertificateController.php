<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Certificate\ApplyRequest;
use App\Models\ExamApply;

use App\Models\UserInfo;
use App\Services\Student\CertificateService;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller{

    public function __construct(protected CertificateService $services)
    {

    }

    public function certificate()
    {
        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Certificate';

        $data['user'] = UserInfo::where('user_id', Auth::guard('student')->id())->first();

        $data['exam_apply'] = ExamApply::where('user_id', Auth::guard('student')->id())->orderby('id','desc')->first();
        $is_passed = $data['exam_apply']->is_passed;
        if($is_passed == 1){
            $data['symbol_number'] = $data['exam_apply']->admit_card ?->symbol_number;
        }


        return view('student.certificate.apply', $data);
    }

    public function saveCertificateApply(ApplyRequest $request)
    {
        return $this->services->saveCertificateApply($request->validated());
    }
}
