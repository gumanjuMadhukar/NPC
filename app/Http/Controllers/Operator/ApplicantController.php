<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\Applicant\ApplyRequest;
use App\Http\Requests\Operator\Applicant\BachelorRequest;
use App\Http\Requests\Operator\Applicant\exportProgramWise;
use App\Http\Requests\Operator\Applicant\ExportRequest;
use App\Http\Requests\Operator\Applicant\MasterRequest;
use App\Http\Requests\Operator\Applicant\PclRequest;
use App\Http\Requests\Operator\Applicant\PersonalRequest;
use App\Http\Requests\Operator\Applicant\SlcRequest;
use App\Http\Requests\Operator\Applicant\StateSaveRequest;
use App\Http\Requests\Operator\Applicant\StatusSaveRequest;
use App\Http\Requests\Operator\Applicant\TslcRequest;
use App\Models\College;
use App\Models\District;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Level;
use App\Models\Municipality;
use App\Models\Program;
use App\Models\Province;
use App\Models\Role;
use App\Models\University;
use App\Models\User;
use App\Models\UserQualification;
use App\Services\Operator\ApplicantService;
use Illuminate\Http\Request;
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
        $data['state_name'] = $request->state_name ?? '';
        $data['status'] = $request->status ?? '';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->where('id', '>', 1)->orderBy('id', 'desc')->get();

        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['college_name'], $data['state_name']);

        return view('operator.applicant.list', $data);
    }

    public function statusWiseList($exam_id)
    {
        $data['nav'] = 'applicant_search';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicant Search';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $request->exam_id ?? "";

        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['college_name'], $data['state_name']);
        
        return view ('operator.dashboard.program_detail');
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
        $data['state_name'] = $request->rstate_name ?? 'operator';
        $data['status'] = $request->status ?? 'progress';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->where('id', '>', 1)->orderBy('id', 'desc')->get();

        $data['result'] = $this->service->myList($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['college_name'], $data['state_name']);

        return view('operator.applicant.progress_list', $data);
    }

    public function export(ExportRequest $request)
    {
        return $this->service->export($request->validated());
    }

    public function export_program_wise(ExportRequest $request)
    {
        return $this->service->exportProgramWise($request->validated());
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
        $data['status'] = $request->status ?? '';
        $data['state_name'] = $request->state_name ?? 'operator';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();

        $data['result'] = $this->service->approved_list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['college_name'], $data['state_name']);

        return view('operator.applicant.my_list', $data);
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
        $data['college_name'] = $request->college_name ?? "";
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? '';
        $data['state_name'] = $request->state_name ?? 'operator';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();

        $data['result'] = $this->service->rejected_list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['college_name'], $data['state_name']);

        return view('operator.applicant.my_list', $data);
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
        $data['college_name'] = $request->college_name ?? "";
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? '';
        $data['state_name'] = $request->state_name ?? 'operator';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['colleges'] = College::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['roles'] = Role::select('*')->whereBetween('id', [2, 7])->orderBy('id', 'desc')->get();

        $data['result'] = $this->service->pending_list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id'], $data['college_name'], $data['state_name']);

        return view('operator.applicant.my_list', $data);
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
            ->whereHas('exam_applies', function ($qry) use ($exam_id) {
                $qry->where('id', $exam_id);
            })->get();

        if ($data['user']) {
            return view('operator.applicant.user', $data);
        } else {
            abort(404);
        }
    }

    public function personalInfo(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Edit Profile';
        $data['levels'] = Level::where('status', 1)->where('id', '<>', 5)->get();
        $data['programs'] = Program::where('status', 1)->get();
        $data['provinces'] = Province::where('status', 1)->get();
        $data['districts'] = District::where('status', 1)->get();
        $data['municipalities'] = Municipality::where('status', 1)->get();
        $data['user'] = User::findOrFail($request->id);

        return view('operator.applicant.personal', $data);
    }
    public function savePersonalInfo(PersonalRequest $request)
    {
        return $this->service->savePersonal($request->validated());
    }
    public function tslc($id)
    {
        $data['nav'] = 'profile';
        $data['sub_nav'] = 'college';
        $data['user'] = $id;
        $data['colleges'] = College::all();
        $data['page_title'] = 'TSLC Information';
        $data['level_id'] = 4;
        $data['user_qualification'] = UserQualification::where(['user_id' => $id, 'level_id' => $data['level_id']])->first();
        $data['return_url'] = route('operator-applicant-profile', $id);

        return view('operator.applicant.tslc', $data);
    }
    public function saveTslc(TslcRequest $request)
    {
        return $this->service->saveTslc($request->validated());
    }

    public function slc($id)
    {
        $data['nav'] = 'profile';
        $data['sub_nav'] = 'college';
        $data['user'] = $id;
        $data['colleges'] = College::all();
        $data['page_title'] = 'SLC Information';
        $data['level_id'] = 5;
        $data['user_qualification'] = UserQualification::where(['user_id' => $id, 'level_id' => $data['level_id']])->first();
        $data['return_url'] = route('operator-applicant-profile', $id);

        return view('operator.applicant.slc', $data);
    }
    public function saveSlc(SlcRequest $request)
    {
        return $this->service->saveSlc($request->validated());
    }
    public function pcl($id)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = 'pcl';
        $data['user'] = $id;
        $data['colleges'] = College::all();
        $data['page_title'] = 'PCL/+2 Information';
        $data['level_id'] = 3;
        $data['user_qualification'] = UserQualification::where(['user_id' => $id, 'level_id' => $data['level_id']])->first();
        $data['return_url'] = route('operator-applicant-profile', $id);
        return view('operator.applicant.pcl', $data);
    }
    public function savePcl(PclRequest $request)
    {
        return $this->service->savePcl($request->validated());
    }

    public function bachelor($id)
    {
        $data['nav'] = 'profile';
        $data['sub_nav'] = 'college';
        $data['user'] = Auth::guard('student')->user();
        $data['colleges'] = College::all();
        $data['universities'] = University::all();
        $data['page_title'] = 'Bachelor Information';
        $data['level_id'] = 2;
        $data['user_qualification'] = UserQualification::where(['user_id' => $id, 'level_id' => $data['level_id']])->first();
        $data['return_url'] = route('operator-applicant-profile', $id);

        return view('operator.applicant.bachelor', $data);
    }
    public function saveBachelor(BachelorRequest $request)
    {
        return $this->service->saveBachelor($request->validated());
    }

    public function master($id)
    {
        $data['nav'] = 'profile';
        $data['sub_nav'] = 'college';
        $data['user'] = $id;
        $data['colleges'] = College::all();
        $data['page_title'] = 'Master Information';
        $data['universities'] = University::all();
        $data['level_id'] = 1;
        $data['user_qualification'] = UserQualification::where(['user_id' => $id, 'level_id' => $data['level_id']])->first();
        $data['return_url'] = route('operator-applicant-profile', $id);

        return view('operator.applicant.master', $data);
    }
    public function saveMaster(MasterRequest $request)
    {
        return $this->service->saveMaster($request->validated());
    }
    public function status(Request $request)
    {
        $data['exam_apply'] = ExamApply::where(['id' => $request->id])->first();
        return view('operator.applicant.status', $data);
    }

    public function statusSave(StatusSaveRequest $request)
    {
        return $this->service->status($request->validated());
    }

    public function stateSave(StateSaveRequest $request)
    {
        return $this->service->state($request->validated());
    }

    public function fowrardReExam(Request $request)
    {
        return $this->service->forwardReExam($request);
    }

    public function selectedFowrardReExam(Request $request)
    {
        return $this->service->selectedForwardReExam($request);
    }

    public function applyForm(Request $request)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Edit Apply';
        $data['exam_apply'] = ExamApply::where(['id' => $request->id])->first();
        $data['exams'] = Exam::all();
        $data['levels'] = Level::where('id', '<>', 5)->get();
        $data['programs'] = Program::all();
        // dd($data['levels']);
        return view('operator.applicant.apply', $data);
    }

    public function editApply(ApplyRequest $request)
    {
        return $this->service->edit_apply($request->validated());
    }

    public function delete(Request $request)
    {
        return $this->service->delete($request->id);
    }

    public function collegeImageDelete(Request $request)
    {
        return $this->service->collegeImageDelete($request);
    }
    public function admitCard($exam_apply_id)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Profile';
        $data['exam_apply'] = ExamApply::where('id', $exam_apply_id)->orderBy('id', 'desc')->first();
        // dd($data);
        if ($data['exam_apply']) {
            return view('operator.applicant.admit_card', $data);
        } else {
            abort(404);
        }
    }

}
