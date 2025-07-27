<?php

namespace App\Http\Controllers\ExamCommittee;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\Program;
use App\Services\ExamCommittee\DashboardService;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service)
    {
    }
    public function index()
    { 
        $per_page = 100;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);

        $data['nav'] = 'dashboard';
        $data['sub_nav'] = '';
        $data['page_title'] = "Dashboard";
        return view('examcommittee.dashboard.index', $data);
    }

    public function examDetail($id)
    {
        $data['nav'] = 'exam_detail';
        $data['sub_nav'] = '';
        $data['page_title'] = "Exam Detail";
        $data['exam'] = Exam::where('id', $id)->first();
        $data['applicant_count'] = ExamApply::where('exam_id', $id)->count();
        $data['admit_card_count'] = ExamApply::where('exam_id', $id)->where('is_admit_card_generate', '1')->where('state','exam_committee')->count();
        $data['pass_count'] = ExamApply::where('exam_id', $id)->where('is_passed', '1')->where('state','exam_committee')->count();
        $data['failed_count'] = ExamApply::where('exam_id', $id)->where('is_admit_card_generate', '1')->where('is_passed', '0')->where('state','exam_committee')->count();
        // $data['programs'] = Program::with(['exam_applies' => function ($q) use ($id) {
        //     $q->where('exam_id', $id);
        // }])->get();

        $data['programs'] = Program::where('has_exam', 1)->with(['exam_applies' => function ($q) use ($id) {
            $q->where('exam_id', $id);
        }])
        ->withCount([
            'exam_applies as exam_apply_count' => function ($q) use ($id) {
                $q->where('exam_id', $id)->where('state','exam_committee');
            },
            'admit_cards as admit_card_count' => function ($q) use ($id) {
                $q->where('exam_id', $id)->where('state','exam_committee');
            },
            'pass_applicant as pass_applicant_count' => function ($q) use ($id) {
                $q->where('exam_id', $id)->where('state','exam_committee');
            },
            'fail_applicant as fail_applicant_count' => function ($q) use ($id) {
                $q->where('exam_id', $id)->where('state','exam_committee');
            },
        ])
        ->orderBy('level_id')
        ->get();

        return view('examcommittee.dashboard.exam_detail', $data);
    }
}