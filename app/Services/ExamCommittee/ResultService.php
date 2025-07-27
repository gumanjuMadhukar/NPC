<?php
namespace App\Services\ExamCommittee;

use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\AdmitCard;
use App\Models\ExamLog;
use Illuminate\Support\Facades\Auth;
use Excel;

class ResultService
{
    public function result($result)
    {
        $admit_card = AdmitCard::where('symbol_number', $result[0])->first();
        $admit_card->is_taken = 1;
        $admit_card->update();
        $this->update_result($admit_card->exam_apply_id, $result[3] );
    }

    public function update_absent($exam_id = NULL)
    {
        $query = AdmitCard::whereNull('is_taken');
        $query = $query->where(function ($qry) use ($exam_id) {
            $qry->whereHas('exam_apply', function ($qry) use ($exam_id) {
                $qry->where(function ($query) use ($exam_id) {
                    $query->where('exam_id', $exam_id);
                });
            });
        });
        $admit_cards = $query->get();
        foreach($admit_cards as $admit_card){
            $this->update_result($admit_card->exam_apply_id, 'ABSENT');
        }
    }

    private function update_result($exam_apply_id, $result){
        $exam_apply = ExamApply::where('id', $exam_apply_id)->first();
        $exam_log_remarks = 'Profile Accepted and forwarded to Council';
        if($result == 'PASSED'){
            $exam_apply->is_passed = 1;
            $exam_apply->state = 'council';
            $exam_apply->status = 'progress';
        }else{
            $exam_apply->rejected = 1;
            $exam_apply->status = 'rejected';
            $exam_log_remarks = "Rejected By Exam Committee";
        }

        $exam_log = new ExamLog;
        $exam_log->user_id = $exam_apply->user_id;
        $exam_log->exam_apply_id = $exam_apply->id;
        $exam_log->system_user_id = Auth::guard('exam_committee')->id();
        $exam_log->status = $exam_apply->state;
        $exam_log->state = 'operator';
        $exam_log->remarks = $exam_log_remarks;
        $exam_log->save();

        $exam_apply->update();
    }

    public function list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $role_name){
        try {
            $query = ExamApply::select('exam_applies.*');
            if ($q) {
                $query->where(function ($qry) use ($q) {
                    $qry->whereHas('user', function ($qry) use ($q) {
                        $qry->where(function ($query) use ($q) {
                            $query->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                        });
                    })
                    ->orWhereHas('user_info', function ($qry) use ($q) {
                        $qry->where(function ($query) use ($q) {
                            $query->whereAny(['first_name', 'middle_name', 'last_name', 'citizenship_number'], 'LIKE', '%' . $q . '%');
                        });
                    });
                });
            }
            if ($exam_id) {
                if ($exam_id == 'tslc') {
                    $query->whereNull('exam_id');
                } else {
                    $query->where('exam_id', $exam_id);
                }
            }
            if ($level_id) {
                $query->where('exam_applies.level_id', $level_id);
            }
            if ($program_id) {
                $query->where('program_id', $program_id);
            }
            if ($status) {
                $query->where('status', $status);
            }
            
            $query->where(function($query) {
                $query->where('state', 'exam_committee')
                      ->orWhere('state', 'council');
            });

            $data['applicants'] = $query->orderBy('id', 'asc')->paginate($per_page);

            $data['applicants']->appends(array('q' => $q, 'exam_id' => $exam_id, 'level_id' => $level_id, 'program_id' => $program_id, 'status' => $status));
            if ($page != 1) {
                $data['total_data'] = $data['applicants']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['applicants']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['applicants']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['applicants']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}