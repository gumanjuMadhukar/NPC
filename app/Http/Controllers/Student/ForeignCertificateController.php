<?php 
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Exam\ApplyRequest;
use App\Models\ExamApply;
use App\Models\Level;
use App\Models\Program;
use App\Models\UserInfo;
use App\Services\Student\ExamService;
use Illuminate\Support\Facades\Auth;

class ForeignCertificateController extends Controller{

    public function __construct(protected ExamService $examServices)
    {

    }

    public function foreignCertificate() 
    {
        $data['nav'] = 'foreignCertificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Foreign Certificate';
        $data['levels'] = Level::all();
        $data['programs'] = Program::all();
        $data['level_id'] = Auth::guard('student')->user()->info->level_id ;
        $data['user'] = UserInfo::where('user_id', Auth::guard('student')->id())->first();
        if(!$data['user'] ) {
            return redirect()->route('student-profile-personal')->with('message', 'Please fill you profile first then only you can aply exam.');
        }
        $data['exam_id'] = $request->id ?? null;
        $data['exam_apply'] = ExamApply::where('user_id', Auth::guard('student')->id())->orderby('id','desc')->first();
        return view('student.foreign.apply', $data);
    }
    
    public function saveForeignApply(ApplyRequest $request)
    {
        return $this->examServices->saveForeignApply($request->validated());
    }
}