<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Program;
use App\Models\SubjectCommittee;
use App\Services\Officer\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service)
    {
    }
    public function index(Request $request)
    {
        $data['nav'] = 'dashboard';
        $data['sub_nav'] = '';
        $data['page_title'] = "Dashboard";
        $per_page = "";
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['user'] = 'officer';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('officer.dashboard.index', $data);
    }

    public function examDetail($id)
    {
        $data['nav'] = 'exam_detail';
        $data['sub_nav'] = '';
        $data['page_title'] = "Exam ";
        $data['exam_id'] = $id;
        $data['exam_name'] = Exam::where('id', $id)->pluck('name')->first();
        $exam_detail = ExamApply::where('exam_id', $id);
        $data['applicant_count'] = $exam_detail->count();
        $data['rejected_count'] = ExamApply::where('exam_id', $id)->where('status', 'rejected')->count();
        $data['failed_count'] = ExamApply::where(['exam_id' => $id, 'is_passed' => 0, 'state' => 'exam_committee', 'is_admit_card_generate' => 1])->count();

        $data['re_exam_count'] = ExamApply::where('exam_id', $id)->where('status', 're-exam')->count();

        
        $data['officer_student_count'] = ExamLog::where('state', 'officer')
            ->whereHas('exam_applies', function ($query) use ($id) {
                $query->where('exam_id', $id);
            })->count();
        $data['officer_accepted_count'] = $this->countExamLogs($id, 'accepted');
        $data['officer_rejected_count'] = $this->countExamLogs($id, 'rejected');
        
        $data['master_count'] = ExamApply::where('exam_id', $id)->where('level_id', 1)->count();
        $data['bachelor_count'] = ExamApply::where('exam_id', $id)->where('level_id', 2)->count();
        $data['second_level_count'] = ExamApply::where('exam_id', $id)->where('level_id', 3)->count();
        $data['tslc_count'] = ExamApply::where('exam_id', $id)->where('level_id', 4)->count();
        $data['slc_count'] = ExamApply::where('exam_id', $id)->where('level_id', 5)->count();

        $subjectCommitteeCounts = [];
        for ($subjectCommitteeId = 1; $subjectCommitteeId <= 8; $subjectCommitteeId++) {
            // Retrieve the name of the subject committee
            $subjectCommittee = SubjectCommittee::find($subjectCommitteeId);

            // Count the number of students who applied for this subject committee
            $count = ExamApply::whereHas('program', function ($query) use ($subjectCommitteeId) {
                $query->where('subject_committee_id', $subjectCommitteeId);
            })->where('exam_id', $id)->count();

            // Store the name and count in the array
            if ($subjectCommittee) {
                $subjectCommitteeCounts[] = [
                    'code' => $subjectCommittee->code,
                    'count' => $count,
                ];
            }
        }
        $data['subject_committee_counts'] = $subjectCommitteeCounts;

        $programCounts = [];
        $programs = Program::all();

        foreach ($programs as $program) {
            $count = ExamApply::where('exam_id', $id)
                ->where('program_id', $program->id)
                ->count();

            $programCounts[] = [
                'program_id' => $program->id,
                'program_name' => $program->name,
                'count' => $count,
            ];
        }
        $data['program_wise_counts'] = $programCounts;
        
        // $data['level_wise_count'] = $exam_detail->select('level_id', \DB::raw('count(*) as count'))
        //             ->where('exam_id', $id)
        //             ->groupBy('level_id')
        //             ->get()
        //             ->keyBy('level_id')
        //             ->mapWithKeys(function ($item) {
        //             return [$item->level_id => $item->count];
        //             })
        //             ->toArray();
        // dd($data['level_wise_count']);

        return view('officer.dashboard.exam_detail', $data);
    }
    public function programWiseStudents(Request $request, $program_id, $exam_id)
    {
        $data['nav'] = 'program_detail';
        $data['sub_nav'] = '';
        $data['page_title'] = "Program Details";
        $data['q'] = $request->q ?? '';
        $per_page = 10;
        $data['role'] = 'officer';
        $page = $request->page ?? 1;
        $data['exam_name'] = Exam::where('id', $exam_id)->pluck('name')->first();
        $data['result'] = $this->service->programWiseStudents($per_page, $page, $data['q'], $program_id, $exam_id);
        return view('officer.dashboard.program_detail', $data);
    }

     public function statusWiseList(Request $request, $program_id, $exam_id)
    {
        $data['nav'] = 'status_detail';
        $data['sub_nav'] = '';
        $data['page_title'] = "Status Details";
        $data['q'] = $request->q ?? '';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['exam_name'] = Exam::where('id', $exam_id)->pluck('name')->first();
        $data['result'] = $this->service->statusWiseStudents($per_page, $page, $data['q'], $program_id, $exam_id);
        return view('officer.dashboard.status_wise_detail', $data);
    }
    private function countExamLogs($examId, $status)
    {
        return ExamLog::where('state', 'officer')
            ->where('status', $status)
            ->whereHas('exam_applies', function ($query) use ($examId) {
                $query->where('exam_id', $examId);
            })->count();
    }

    
}
