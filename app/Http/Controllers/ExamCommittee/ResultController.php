<?php

namespace App\Http\Controllers\ExamCommittee;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\Level;
use App\Models\Program;
use App\Services\ExamCommittee\ResultService;
use Illuminate\Http\Request;
use Excel;
use App\Imports\ResultImport;

class ResultController extends Controller
{
    public function __construct(protected ResultService $service)
    {
    }

    public function form(Request $requet)
    {
        $data['exams'] = Exam::all();
        $data['nav'] = 'result';
        $data['sub_nav'] = '';
        $data['page_title'] = "Result";
        return view('examcommittee.result.form', $data);
    }

    public function result_upload(Request $request)
    {
        $import = new ResultImport();
        Excel::import($import, request()->file('result'));

        $results = $import->getResult();

        foreach($results as $key => $result){
            if($key != 0){
                $this->service->result($result);
            }
        }
        $this->service->update_absent($request['exam_id']);
        return redirect()->route('exam_committee-result-list', $request['exam_id']);
    }

    public function list(Request $request, $exam_id)
    {
        $data['nav'] = 'applicant';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Applicants';
        $per_page = 20;
        $page = $request['page'] ?? 1;
        $data['q'] = $request->q ?? '';
        $data['exam_id'] = $exam_id;
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
}