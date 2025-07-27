<?php

namespace App\Http\Controllers\ExamCommittee;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Level;
use App\Models\Program;
use App\Models\User;
use App\Services\ExamCommittee\ApplicantService;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function __construct(protected ApplicantService $service)
    {
    }

    // public function generateAdmitCard($request)
    // {
    //     $data['nav'] = 'move-council';
    //     $data['sub_nav'] = '';
    //     $data['page_title'] = 'Move To Council';
    //     $data['result'] = $this->service->generateAdmitCard($request);
    //     return view('exam_committee.applicant.genrateAdmitCard', $data);
    // }

    public function list(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id','desc')->pluck('id')->first();
        $data['level_id'] = $request->level_id ?? '' ;
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? '';
        $data['role_name'] = $request->role ?? 'exam_committee';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['role_name']);
        return view('examcommittee.result.list', $data);
    }

    public function approvedList(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();
        $data['college_name'] = $request->college_name ?? "";
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? 'accepted';
        $data['state_name'] = $request->state_name ?? 'exam_committee';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();

        $data['result'] = $this->service->approved_list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['college_name'], $data['state_name']);

        return view('examcommittee.applicant.my_list', $data);
    }

    public function profile($id)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Profile';
        $data['user'] = User::where('id', $id)->first();
        $data['exam_apply'] = ExamApply::where('user_id', $id)->orderby('id', 'desc')->first();
        $lastest_apply = ExamApply::where('user_id', $id)->whereHas('exam', function ($qry) {
            $qry->where('status', 1);
        })->orderBy('id', 'desc')->first();
        $exam_id = $lastest_apply->id ?? '';
        $data['exam_logs'] = ExamLog::select('*')
            ->where('user_id', $id)
            ->whereHas('exam_applies', function($qry) use ($exam_id){
            $qry->where('id', $exam_id);
        })->get();

        if ($data['user']) {
            return view('examcommittee.applicant.user', $data);
        } else {
            abort(404);
        }
    }

}
