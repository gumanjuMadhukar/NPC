<?php

namespace App\Http\Controllers\SubjectCommittee;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Program;
use App\Models\SubjectCommitteeUser;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data['nav'] = 'dashboard';
        $data['sub_nav'] = '';
        $data['page_title'] = "Dashboard";

        // Get the latest exam ID
        $exam_id = Exam::orderby('id', 'desc')->pluck('id')->first();

        // Get the current user's subject committee and related program IDs
        $data['subject_committee_ids'] = SubjectCommitteeUser::where('user_id', Auth::guard('subject_committee')->id())
            ->pluck('subject_committee_id');
        $data['program_ids'] = Program::whereIn('subject_committee_id', $data['subject_committee_ids'])
            ->pluck('id');

        // Get exam applications and counts
        $data['exam_apply_ids'] = ExamApply::where('exam_id', $exam_id)->pluck('id');
        $student_count = ExamApply::whereIn('program_id', $data['program_ids'])
            ->where('state', 'subject_committee')
            ->get();

        // Join exam_logs with exam_applies to fetch accepted student counts grouped by level_id
        $system_user_id = Auth::guard('subject_committee')->id();
        $accepted_student_count = ExamLog::join('exam_applies', 'exam_logs.exam_apply_id', '=', 'exam_applies.id')
            ->where('exam_logs.system_user_id', $system_user_id)
            ->where('exam_applies.exam_id', $exam_id)
            ->where('exam_logs.status', 'accepted')
            ->selectRaw('exam_applies.level_id, count(*) as count')
            ->groupBy('exam_applies.level_id')
            ->get()
            ->keyBy('level_id'); // Group results by level_id for easier access

        // Build level-wise student counts
        $data['level_wise_students_count'] = [
            [
                'name' => 'Specialization / Masters',
                'level_id' => 1,
                'count' => $student_count->where('level_id', 1)->count(),
                'progress_count' => $student_count->where(['level_id' => 1, 'status' => 'progress'])->count(),
                'accepted_count' => $accepted_student_count[1]->count ?? 0, // Default to 0 if not found
            ],
            [
                'name' => 'Bachelor',
                'level_id' => 2,
                'count' => $student_count->where('level_id', 2)->count(),
                'progress_count' => $student_count->where(['level_id' => 2, 'status' => 'progress'])->count(),
                'accepted_count' => $accepted_student_count[2]->count ?? 0,
            ],
            [
                'name' => 'PCL +2',
                'level_id' => 3,
                'count' => $student_count->where('level_id', 3)->count(),
                'progress_count' => $student_count->where(['level_id' => 3, 'status' => 'progress'])->count(),
                'accepted_count' => $accepted_student_count[3]->count ?? 0,
            ],
        ];

        return view('subjectcommittee.dashboard.index', $data);
    }
}
