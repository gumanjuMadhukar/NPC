<?php

namespace App\Http\Controllers\SubjectCommittee;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectCommittee\Applicant\StatusRequest;
use App\Models\College;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Level;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use App\Services\SubjectCommittee\ApplicantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function __construct(protected ApplicantService $service)
    {
    }
    public function list(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? "";
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? '';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id']);
        return view('subjectcommittee.applicant.list', $data);
    }
    public function myList(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? '';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id']);
        return view('subjectcommittee.applicant.list', $data);
    }
    public function myListLevel(Request $request , $level_id)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();
        $data['level_id'] = $request->level_id ?? $level_id;
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? 'progress';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id']);
        return view('subjectcommittee.applicant.list', $data);
    }
    public function approvedList(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 10;
        $data['system_user_id'] = Auth::guard('subject_committee')->id();
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['role_name'] = $request->role_name ?? 'subject_committee';
        $data['college_name'] = $request->college_name ?? "";
        $data['status'] = $request->status ?? 'accepted';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->whereBetween('id', [2, 7])->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->my_list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'] ,$data['system_user_id']);
        return view('subjectcommittee.applicant.approved_list', $data);
    }
    public function myRejectedList(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 10;
        $data['system_user_id'] = Auth::guard('subject_committee')->id();
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['role_name'] = $request->role_name ?? 'subject_committee';
        $data['college_name'] = $request->college_name ?? "";
        $data['status'] = $request->status ?? 'rejected';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->whereBetween('id', [2, 7])->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->my_list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['system_user_id']);

        return view('subjectcommittee.applicant.approved_list', $data);
    }
    public function committeeRejectedList(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 10;
        $data['system_user_id'] = ''; // Auth::guard('subject_committee')->id();
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['role_name'] = $request->role_name ?? 'subject_committee';
        $data['college_name'] = $request->college_name ?? "";
        $data['status'] = $request->status ?? 'rejected';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->whereBetween('id', [2, 7])->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->my_list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['system_user_id']);

        return view('subjectcommittee.applicant.approved_list', $data);
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
            return view('subjectcommittee.applicant.user', $data);
        } else {
            abort(404);
        }
    }

    public function status(StatusRequest $request)
    {
        return $this->service->status($request->validated());
    }

    public function moveCouncil()
    {
        $data['nav'] = 'move-council';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Move To Council';
        $data['result'] = $this->service->moveCouncil();
        return view('subjectcommittee.applicant.move_council', $data);
    }

    public function moveExamcommitteeList(Request $request)
    {
        $data['nav'] = 'move-examcommittee';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Move To Exam Committee List';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? '';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->moveExamcommitteeList($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id']);
        return view('subjectcommittee.applicant.move_examcommittee_list', $data);

        
    }
    
    public function moveExamcommittee()
    {
        $data['nav'] = 'move-examcommittee';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Move To Exam Committee';
        $data['result'] = $this->service->moveExamcommittee();
        return view('subjectcommittee.applicant.move_examcommittee', $data);
    }
}
