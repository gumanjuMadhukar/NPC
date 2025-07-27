<?php

namespace App\Jobs\SubjectCommittee;

use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Program;
use App\Models\SubjectCommitteeUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class MoveCouncilJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user_id = $this->data['user_id'];
        $subject_committee_ids = SubjectCommitteeUser::where('user_id', $user_id)->pluck('subject_committee_id');
        $program_ids = Program::whereIn('subject_committee_id', $subject_committee_ids)->pluck('id');
        $exam_applies = ExamApply::where(['state' => 'subject_committee', 'status' => 'progress'])->whereNull('exam_id')->whereIn('program_id', $program_ids)->get();
        if ($exam_applies->count() > 0) {
            foreach ($exam_applies as $exam_apply) {
                $subject_committee_users = SubjectCommitteeUser::where('subject_committee_id', $exam_apply->program->subject_committee->id)->count();
                $average = $subject_committee_users / 2;
                if ($exam_apply->subject_committee_count >= $average) {
                    $status = 'progress';
                    $state = 'council';
                    $remarks = 'Exam Applied has been accepted';
                    $exam_log_remarks = 'Profile Verified and forwarded to Council';
                    $suject = 'Application Form Approval Notification';

                    ExamApply::where('id', $exam_apply->id)->update(
                        [
                            'rejected' => 0,
                            'status' => $status,
                            'state' => $state,
                            'remarks' => $remarks,
                        ]
                    );
                    $exam_log = new ExamLog;
                    $exam_log->user_id = $exam_apply->user_id;
                    $exam_log->exam_apply_id = $exam_apply->id;
                    $exam_log->system_user_id = $this->data['user_id'];
                    $exam_log->status = $status;
                    $exam_log->remarks = $exam_log_remarks;
                    $exam_log->save();

                    $email_data = [
                        'name' => $exam_apply->user->name,
                        'email' => $exam_apply->user->email,
                        'status' => $status,
                        'subject' => $suject,
                        'remarks' => $remarks,
                    ];
                    $jobToDispatch = (new ExamApplyStatusJob($email_data))->delay(Carbon::now()->addSeconds(1));
                    // dispatch($jobToDispatch);
                }

            }
        }
    }
}
