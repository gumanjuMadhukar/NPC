<?php

namespace App\Services\ExamCommittee;

use App\Exports\ExamCommittee\ApplicantExport;
use App\Jobs\ExamCommittee\GenerateAdmitCardJob;
use App\Models\ExamApply;
use App\Models\AdmitCard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class AdmitCardService
{

    function export($request)
    {
        try {
            return Excel::download(new ApplicantExport($request), 'admitcard_list.xlsx');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function generateAdmitCard($request){
        $exam_id = $request['exam_id'];
        $program_id = $request['program_id'];
        $subject_committee_id = $request['subject_committee_id'];
        $level_id = $request['level_id'];

        // try {
            // $exam_applies = ExamApply::where([
            //         'state' => 'exam_committee', 
            //         // 'status' => 'progress', 
            //         'is_admit_card_generate' => 0,
            //     ])
            //     ->whereNull('exam_id')
            //     ->where('program_id', $program_id)
            //     ->count();
            // // dd($exam_applies);

            // if ($exam_applies > 0) {
            
            $data = ['exam_id'=>$exam_id, 'program_id' => $program_id, 'subject_committee_id' => $subject_committee_id, 'level_id' => $level_id,  'user_id' => Auth::guard('exam_committee')->id()];
            $jobToDispatch = (new GenerateAdmitCardJob($data))->delay(Carbon::now()->addSeconds(2));
            dispatch($jobToDispatch);
            return 'success';
            // } else {
                // return 'no';
            // }
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 400);
        // }
    }

    public function list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $role_name)
    {
        try {
            $query = AdmitCard::select('exam_applies.*');
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
            if ($role_name) {
                $query->where('state', $role_name);
            }
            $data['applicants'] = $query->orderBy('id', 'asc')->paginate($per_page);

            $data['applicants']->appends(array('q' => $q, 'exam_id' => $exam_id, 'level_id' => $level_id, 'program_id' => $program_id, 'status' => $status, 'state' => $role_name));
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

    public function generateRoutine($exam_id, $start_date, $shift_count, $student_count){
        // $query = AdmitCard::select('admit_cards.*');
        // $query->where(function ($qry) use ($exam_id) {
        //     $qry->whereHas('exam_apply', function ($qry) use ($exam_id) {
        //         $qry->where('exam_id', 9);
        //     });
        // });
        // $admitcards = $query->with(['exam_apply' => function ($query) {
        //     $query->orderBy('level_id')->orderBy('program_id');
        // }])->get();
        
        $data = array();
        $admitcards = AdmitCard::join('exam_applies', 'admit_cards.exam_apply_id', '=', 'exam_applies.id')
        ->join('programs', 'exam_applies.program_id', '=', 'programs.id')
        ->join('subject_committees', 'programs.subject_committee_id', '=', 'subject_committees.id')
        ->where('exam_applies.exam_id', 12)
        ->orderBy('exam_applies.level_id', 'DESC')->orderBy('subject_committees.rank')->orderBy('admit_cards.id')
        ->select('admit_cards.*') // Select only fields from admit_cards
        ->get();
        // echo $admitcards->tosql();
        $day = 1;
        $shift = 1;
        $admitcards->chunk(330)->each(function ($chunkedStudents, $index) use (&$day, &$shift, &$data) {
            // echo '<pre>';
            $first_admit_card = $chunkedStudents->first();
            $last_admit_card = $chunkedStudents->first();
            $subject_committee_id = '';
            $program_id = '';
            $level_id = '';
            $count = 0;
            
            // echo 'Day: ' . $day . ' : ' . 'Shift: ' . $shift. '<br>';
            foreach ($chunkedStudents as $student) {
                // print_r($student['exam_apply']['program']->subject_committee_id);
                if($count == 0){
                    $subject_committee_id = $student['exam_apply']['program']->subject_committee_id;
                    $level_id = $student['exam_apply']->level_id;
                    $program_id = $student['exam_apply']['program']->id;
                    $count = 0;
                }
                // echo $program_id . '<br>';
                if($subject_committee_id != $student['exam_apply']['program']->subject_committee_id || $level_id != $student['exam_apply']->level_id || $program_id != $student['exam_apply']['program']->id){
                    // echo $student['exam_apply']['program_id'] . '<br>';
                    if($first_admit_card['symbol_number'] != $last_admit_card['symbol_number']){
                        $data[$day][$shift][] =  $first_admit_card['exam_apply']['program']->name . ':' . $first_admit_card['symbol_number'] . ' : ' . $last_admit_card['symbol_number'] . ' (' . $count . ')';
                    }else{
                        $data[$day][$shift][] =  $first_admit_card['exam_apply']['program']->name . ':' . $first_admit_card['symbol_number'] . ' (' . $count . ')';
                    }
                    $subject_committee_id = $student['exam_apply']['program']->subject_committee_id;
                    $program_id = $student['exam_apply']['program']->id;
                    $level_id = $student['exam_apply']->level_id;
                    $first_admit_card = $student;
                    $count = 0;
                }
                $count++;
                $last_admit_card = $student;
            }
            if($first_admit_card['symbol_number'] != $last_admit_card['symbol_number']){
                $data[$day][$shift][] =  $first_admit_card['exam_apply']['program']->name . ':' . $first_admit_card['symbol_number'] . ' : ' . $last_admit_card['symbol_number'] . ' (' . $count . ')';
            }else{
                $data[$day][$shift][] =  $first_admit_card['exam_apply']['program']->name . ':' . $first_admit_card['symbol_number'] . ' (' . $count . ')';
            }
            // echo '</pre>';
            if($shift == 5){
                $day++;
                $shift=1;
            }else{
                $shift++;
            }
        });
        return $data;
    }
}
