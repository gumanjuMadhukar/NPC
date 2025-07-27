<?php

namespace App\Http\Controllers\ExamCommittee;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\Program;
use App\Services\ExamCommittee\AdmitCardService;
use Illuminate\Http\Request;

class AdmitCardController extends Controller
{
    public function __construct(protected AdmitCardService $service)
    {
    }
    // public function index()
    // {
    //     $per_page = 10;
    //     $page = $request->page ?? 1;
    //     $data['q'] = $request->q ?? '';
    //     $data['result'] = $this->service->list($per_page, $page, $data['q']);

    //     $data['nav'] = 'dashboard';
    //     $data['sub_nav'] = '';
    //     $data['page_title'] = "Dashboard";
    //     return view('examcommittee.dashboard.index', $data);
    // }

    public function generate(Request $request)
    {
        $this->service->generateAdmitCard($request);
        $response['message'] = 'Status updated successfully.';
        $response['error'] = null;
        $response['status'] = 201;
        return response()->json($response, $response['status']);
    }

    public function generateRoutine(Request $request)
    {
        $data['nav'] = 'Routine';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Routine';
        $data['result'] = $this->service->generateRoutine($request['exam_id'], $request['start_date'], $request['shift_count'], $request['student_count']);
        return view('examcommittee.applicant.routine', $data);
    }

    public function export(Request $request)
    {
        // dd($request->exam_id);
        return $this->service->export($request);
    }
}