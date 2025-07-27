<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmitCard;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Level;
use App\Models\Program;
use App\Models\User;
use App\Services\Admin\ApplicantService;
use Illuminate\Http\Request;

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
        $data['exam_id'] = $request->exam_id ?? Exam::orderBy('id', 'desc')->pluck('id')->first();
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['status'] = $request->status ?? '';
        $data['exams'] = Exam::select('*')->orderBy('id', 'desc')->get();
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('id', 'desc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['exam_id'], $data['level_id'], $data['status'], $data['program_id']);
        // dd($data);
        return view('admin.applicant.list', $data);
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
            return view('admin.applicant.user', $data);
        } else {
            abort(404);
        }
    }
    public function admitCard($id, $exam_id)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Profile';
        $data['user'] = User::where('id', $id)->first();
        $data['exam_id'] = $exam_id;
        $data['exam_apply'] = ExamApply::where('user_id',$id)->where('exam_id',$data['exam_id'])->orderBy('id', 'desc')->first();
        $data['exam_apply_id'] = $data['exam_apply']->id;
        $data['admit_card'] = AdmitCard::where('exam_apply_id', $data['exam_apply_id'])->orderBy('id', 'desc')->first();
        // dd($data);
        if ($data['user']) {
            return view('admin.applicant.admit_card', $data);
        } else {
            abort(404);
        }
    }
}
