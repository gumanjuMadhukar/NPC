<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\Program;
use App\Models\SubjectCommittee;

class SubjectCommitteeController extends Controller
{
    public function list()
    {
        $data['nav'] = 'subjectcommittee';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Subject Committee';

        // Fetch the most recent exam ID
        $exam_id = Exam::orderby('id', 'desc')->pluck('id')->first();

        // Fetch subject committees and their associated programs
        $subjectCommittees = SubjectCommittee::orderby('id', 'asc')->get();
        $programsBySubjectCommittee = [];
        $examApplications = [];
        $progressApplications = [];
        $rejectedApplications = [];
        $subjectCommitteeNames = [];

        foreach ($subjectCommittees as $subjectCommittee) {
            $programs = Program::where('subject_committee_id', $subjectCommittee->id)
                ->orderby('id', 'asc')
                ->pluck('id')
                ->toArray();

            $programsBySubjectCommittee[$subjectCommittee->id] = $programs;
            $subjectCommitteeNames[$subjectCommittee->id] = $subjectCommittee->name; // Assuming `name` is the column

            if (!empty($programs)) {
                $examApplications[$subjectCommittee->id] = ExamApply::where('exam_id', $exam_id)
                    ->whereIn('program_id', $programs)
                    ->get();

                // Fetch progress applications count
                $progressApplications[$subjectCommittee->id] = ExamApply::whereIn('program_id', $programs)
                    ->where(['exam_id' => $exam_id ,'status'=> 'progress', 'state' => 'subject_committee']) // Assuming 'status' is the column
                    ->count();
                $rejectedApplications[$subjectCommittee->id] = ExamApply::whereIn('program_id', $programs)
                    ->where(['exam_id' => $exam_id ,'status'=> 'rejected', 'state' => 'subject_committee']) // Assuming 'status' is the column
                    ->count();
            } else {
                $examApplications[$subjectCommittee->id] = collect(); // Return an empty collection
                $progressApplications[$subjectCommittee->id] = 0; // No progress applications
                $rejectedApplications[$subjectCommittee->id] = 0; // No progress applications
            }
        }

        // Assign the data to the view
        $data['subject_committees'] = $subjectCommittees;
        $data['programs_by_subject_committee'] = $programsBySubjectCommittee;
        $data['exam_applies_by_program'] = $examApplications;
        $data['subject_committee_names'] = $subjectCommitteeNames;
        $data['progress_applications_by_sub_committee'] = $progressApplications;
        $data['rejected_applications_by_sub_committee'] = $rejectedApplications;

        // dd($rejectedApplications);

        return view('operator.subjectcommittee.index', $data);
    }

}
