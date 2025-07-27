<?php

namespace App\Http\Controllers\Council;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\College;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Level;
use App\Models\Program;
use App\Models\User;
use App\Services\Council\ApplicantService;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function __construct(protected ApplicantService $service)
    {
    }

    public function passedList( Request $request) 
    {
        $data['nav'] = 'applicant/pass';
        $data['sub_nav'] = '';
        $data['page_title'] = "Passed Applicants";
        $per_page = 10;
        $page = $request->page ?? 1 ;
        $data['q'] = $request->q ?? "";

        $data['result'] = $this->service->passedList($per_page, $page, $data['q']);

        return view('council.applicant.passed_list', $data);
    }

    public function councilTslcApplicantList(Request $request)
    {

        $data['nav'] = 'applicant/tslc';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = 'tslc'; // $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();
        $data['college_name'] = $request->college_name ?? "";
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? 'progress';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['program_id'], $data['status'], $data['college_name']);

        return view('council.applicant.tslc_list', $data);
    }

    public function profile($id)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Profile';
        $data['user'] = User::where('id', $id)->first();
        $data['exam_apply'] = ExamApply::where('user_id', $id)->orderby('id', 'desc')->first();
        $data['certificates'] = Certificate::where('user_id', $id)->get();
        $lastest_apply = ExamApply::where('user_id', $id)->whereHas('exam', function ($qry) {$qry->where('status', 1);})->orderBy('id', 'desc')->first();

        $data['exam_logs'] = ExamLog::select('*')->where(['user_id' => $id, 'exam_apply_id' => $lastest_apply?->id])->get();
        if ($data['user']) {
            return view('council.applicant.user', $data);
        } else {
            abort(404);
        }
    }
}
