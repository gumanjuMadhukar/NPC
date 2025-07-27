<?php

namespace App\Jobs\ExamCommittee;

use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Program;
use App\Models\AdmitCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class GenerateAdmitCardJob implements ShouldQueue
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
        $exam_id = $this->data['exam_id'];
        $program_id = $this->data['program_id'];
        $subject_committee_id = $this->data['subject_committee_id'];
        $level_id = $this->data['level_id'];
        // $status = 'progress';
        $exam_applies = ExamApply::where([
            'state' => 'exam_committee', 
            // 'status' => 'progress', 
            'exam_id' => $exam_id, 
            'program_id' => $program_id,
            'is_admit_card_generate' => 0,
            ])->get();
        
        $last_symbol_record = ExamApply::where([
            'state' => 'exam_committee', 
            // 'status' => 'progress', 
            'exam_id' => $exam_id,
            'level_id' => $level_id,
            'program_id' => $program_id,
            'is_admit_card_generate' => 1,
            ])
            // ->whereHas('program', function ($qry) use ($subject_committee_id) {
            //     $qry->where('subject_committee_id', $subject_committee_id);
            // })
            ->count();
        if($last_symbol_record){
            $symbol_number = $last_symbol_record + 1;
        }else{
            $symbol_number = 1;
        }
            
        if ($exam_applies->count() > 0) {
            foreach ($exam_applies as $exam_apply) {
                $admitcard = new AdmitCard();

                $admitcard->user_id = $exam_apply->user_id;
                $admitcard->exam_apply_id = $exam_apply->id;
                $admitcard->symbol_number = $exam_apply->exam->exam_number . '-' . $exam_apply->level->code . $symbol_number . '-' . $exam_apply->program->subject_committee->code;
                $symbol_number++;

                $admitcard->save();
                $exam_apply->is_admit_card_generate = 1;
                $exam_apply->update();

            }
        }
    }
}