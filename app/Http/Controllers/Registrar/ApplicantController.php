<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\Level;
use App\Models\Program;
use App\Models\User;
use App\Services\Registrar\ApplicantService;
use Illuminate\Http\Request;
use App\Http\Requests\Registrar\Applicant\StatusRequest;
use App\Http\Requests\Registrar\Applicant\StatusSaveRequest;
use App\Http\Requests\Registrar\Applicant\ApplyRequest;
use App\Models\College;
use App\Models\ExamLog;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function __construct(protected ApplicantService $service)
    {
    }
    public function list(Request $request)
    {
        $data['nav'] = 'applicant_search';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicant Search';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? "";
        $data['college_name'] = $request->college_name ?? "";
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['role_name'] = $request->role_name ?? '';
        $data['status'] = $request->status ?? '';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->whereBetween('id', [2, 7])->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['college_name'], $data['role_name']);
        
        return view('registrar.applicant.list', $data);
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
        $data['college_name'] = $request->college_name ?? "";
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['role_name'] = $request->role_name ?? 'registrar';
        $data['status'] = $request->status ?? 'progress';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->where('id', '>', 1)->orderBy('id', 'desc')->get();

        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['college_name'], $data['role_name']);

        return view('registrar.applicant.my_list', $data);
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
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['role_name'] = $request->role_name ?? 'registrar';
        $data['status'] = $request->status ?? 'accepted';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->whereBetween('id', [2, 7])->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->approvedList($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['role_name']);

        return view('registrar.applicant.approved_list', $data);
    }
    public function rejectedList(Request $request)
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
        $data['role_name'] = $request->role_name ?? 'registrar';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->whereBetween('id', [2, 7])->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->rejectedList($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['program_id'], $data['role_name']);

        return view('registrar.applicant.my_list', $data);
    }
    public function pendingList(Request $request)
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
        $data['role_name'] = $request->role_name ?? 'registrar';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->whereBetween('id', [2, 7])->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->pendingList($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['program_id'], $data['role_name']);

        return view('registrar.applicant.my_list', $data);
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
        $exam_id = $lastest_apply->id ?? "";
        $data['exam_logs'] = ExamLog::select('*')
            ->where('user_id', $id)
            ->whereHas('exam_applies', function($qry) use ($exam_id){
            $qry->where('id', $exam_id);
        })->get();
       
        if ($data['user']) {
            return view('registrar.applicant.user', $data);
        } else {
            abort(404);
        }
    }

    public function status(Request $request)
    {
        $data['exam_apply'] = ExamApply::where(['id' => $request->id])->first();
        return view('registrar.applicant.status', $data);
    }

    public function statusSave(StatusSaveRequest $request)
    {
        return $this->service->status($request->validated());
    }

    public function moveApplicantsToSubjectCommittee(Request $request)
    {
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();

        return $this->service->moveToSubjectCommittee($data['exam_id']);
    }

}