<?php

namespace App\Services\SubjectCommittee;

use Illuminate\Support\Facades\DB;
use App\Jobs\SubjectCommittee\MoveCouncilJob;
use App\Jobs\SubjectCommittee\MoveExamCommitteeJob;
use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\Program;
use App\Models\User;
use App\Models\SubjectCommitteeUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ApplicantService
{
    public function list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id)
    {

        // try {
            $subject_committee_ids = SubjectCommitteeUser::where('user_id', Auth::guard('subject_committee')->id())->pluck('subject_committee_id');
            $program_ids = Program::whereIn('subject_committee_id', $subject_committee_ids)->pluck('id');
            $query = ExamApply::select('*')->where('state', 'subject_committee')->whereIn('program_id', $program_ids);
            $query->where(function ($qry) {
                $qry->where('status', 'progress')->whereDoesntHave('exam_logs', function ($sql){
                    $sql->where(['system_user_id' => Auth::guard('subject_committee')->id(), 'status' => 'accepted']);
                })->orWhereDoesntHave('exam_logs', function ($sql){
                    $sql->where('system_user_id', Auth::guard('subject_committee')->id());
                });
            });


    
            //if($status == 'progress'){
                // dd(Auth::guard('subject_committee')->id());
                // $query->whereDoesntHave('exam_logs', function ($qry){
                //     $qry->where('system_user_id', Auth::guard('subject_committee')->id());
                // });

               




            // }
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
                $query->whereHas('user_info', function ($qry) use ($q) {
                    $qry->whereAny(['first_name', 'middle_name', 'last_name', 'citizenship_number'], 'LIKE', '%' . $q . '%');
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
                $query->where('level_id', $level_id);
            }
            if ($program_id) {
                $query->where('id', $program_id);
            }
            if ($status) {
                $query->where('status', $status);
            }
            $data['applicants'] = $query->orderBy('id', 'desc')->paginate($per_page);
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
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 400);
        // }
    }

    public function my_list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $system_user_id)
    {
        try {
            $subject_committee_ids = SubjectCommitteeUser::where('user_id', Auth::guard('subject_committee')->id())->pluck('subject_committee_id');
            $program_ids = Program::whereIn('subject_committee_id', $subject_committee_ids)->pluck('id');
            $query = ExamLog::select('*', DB::raw('MAX(id) as last_log_id'))->where('state', 'subject_committee')
            ->groupBy('exam_apply_id');
            $query->whereHas('exam_applies',function ($qry){
                $qry->where('state', 'subject_committee');
            });
          
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
                $query->orwhereHas('user_info', function ($qry) use ($q) {
                    $qry->whereAny(['first_name', 'middle_name', 'last_name', 'citizenship_number'], 'LIKE', '%' . $q . '%');
                });
            }
            if ($exam_id) {
                if ($exam_id == 'tslc') {
                    $query->whereHas('exam_applies', function($query) {
                        $query->whereNull('exam_id');
                    })->get();
                } else {
                    $query->whereHas('exam_applies', function($query) use ($exam_id) {
                        $query->where('exam_id', $exam_id);
                    })->get();
                }
            }
            if ($level_id) {
                $query->whereHas('exam_applies', function($query) use ($level_id) {
                    $query->where('level_id', $level_id);
                })->get();
            }
            if ($program_ids) {
                $query->whereHas('exam_applies', function($query) use ($program_ids) {
                    $query->whereIn('program_id', $program_ids);
                })->get();
            }
            if ($status) {
                $query->where('status', $status);
            }
            if ($system_user_id) {
                $query->where('system_user_id', $system_user_id);
            }
            $data['applicants'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['applicants']->appends(array('q' => $q, 'exam_id' => $exam_id, 'level_id' => $level_id, 'program_id' => $program_id, 'status' => $status, 'system_user_id' =>$system_user_id ));
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
    public function status($request)
    {
        try {
            $count = 0;
            $subject_committee_id = Auth::guard('subject_committee')->id();
            $subject_committee_member = User::where('id', $subject_committee_id)->first();
            if ($request['status'] === "accepted") {
                $count = 1;
                $status = 'progress';
                $log_status = 'accepted';
                $state = 'subject_committee';
                // dd($subject_committee_member);
                $remarks = 'Exam Applied has been accepted by ' . $subject_committee_member->name;
                $exam_log_remarks = 'Profile Verified by ' . $subject_committee_member->name;
                $suject = 'Application Form Approval Notification';
            } elseif ($request['status'] === "rejected") {
                $status = 'rejected';
                $log_status = $status;
                $state = 'subject_committee';
                $remarks = (!empty($request['remarks'])) ? 'Rejected By ' . $subject_committee_member->name. ' - ' . $request['remarks'] : 'Rejected By ' . $subject_committee_member->name;
                $exam_log_remarks = (!empty($request['remarks'])) ? 'Rejected By ' . $subject_committee_member->name. ' - ' . $request['remarks'] : 'Rejected By ' . $subject_committee_member->name;
                $suject = 'Application Form Status Update';
            } else {
                $status = 'pending';
                $log_status = $status;
                $state = 'subject_committee';
                $remarks = 'Pending By '.$subject_committee_member->name;
                $exam_log_remarks = 'Pending By '.$subject_committee_member->name;
            }
            $exam_apply = ExamApply::where('id', $request['id'])->first();
            $exam_apply->rejected = $request['status'] === "rejected" ? 1 : 0;
            $exam_apply->status = $status;
            $exam_apply->subject_committee_count = $exam_apply->subject_committee_count + $count;
            $exam_apply->state = $state;
            $exam_apply->remarks = $remarks;
            $exam_apply->save();

            $exam_log = new ExamLog;
            $exam_log->user_id = $exam_apply->user_id;
            $exam_log->exam_apply_id = $exam_apply->id;
            $exam_log->system_user_id = Auth::guard('subject_committee')->id();
            $exam_log->state = 'subject_committee';
            $exam_log->status = $log_status;
            $exam_log->remarks = $exam_log_remarks;
            $exam_log->save();
            $response['message'] = 'Status updated successfully.';
            $response['error'] = null;
            $response['status'] = 201;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function moveCouncil()
    {
        try {
            $subject_committee_ids = SubjectCommitteeUser::where('user_id', Auth::guard('subject_committee')->id())->pluck('subject_committee_id');
            $program_ids = Program::whereIn('subject_committee_id', $subject_committee_ids)->pluck('id');

            $exam_applies = ExamApply::where(['state' => 'subject_committee', 'status' => 'progress'])->whereNull('exam_id')->whereIn('program_id', $program_ids)->count();

            if ($exam_applies > 0) {
                $data = ['user_id' => Auth::guard('subject_committee')->id()];
                $jobToDispatch = (new MoveCouncilJob($data))->delay(Carbon::now()->addSeconds(1));
                dispatch($jobToDispatch);
                return 'success';
            } else {
                return 'no';
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function moveExamcommitteeList($per_page, $page, $q, $exam_id, $level_id, $status, $program_id)
    {
        // try {
            $subject_committee_ids = SubjectCommitteeUser::where('user_id', Auth::guard('subject_committee')->id())->pluck('subject_committee_id');
            $program_ids = Program::whereIn('subject_committee_id', $subject_committee_ids)->pluck('id');
            $subject_committee_users = SubjectCommitteeUser::whereIn('subject_committee_id', $subject_committee_ids)->count();
            $average = $subject_committee_users / 2;
            $query = ExamApply::where(['state' => 'subject_committee', 'status' => 'progress'])
                ->where('subject_committee_count','>=', $average)
                ->whereNotNull('exam_id')
                ->whereIn('program_id', $program_ids);
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
                $query->whereHas('user_info', function ($qry) use ($q) {
                    $qry->whereAny(['first_name', 'middle_name', 'last_name', 'citizenship_number'], 'LIKE', '%' . $q . '%');
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
                $query->where('level_id', $level_id);
            }
            if ($program_id) {
                $query->where('id', $program_id);
            }
            $data['applicants'] = $query->orderBy('id', 'desc')->paginate($per_page);
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
            
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 400);
        // }
    }

    public function moveExamcommittee()
    {
        try {
            $subject_committee_ids = SubjectCommitteeUser::where('user_id', Auth::guard('subject_committee')->id())->pluck('subject_committee_id');
            $program_ids = Program::whereIn('subject_committee_id', $subject_committee_ids)->pluck('id');
            $exam_applies = ExamApply::where(['state' => 'subject_committee', 'status' => 'progress'])->whereNotNull('exam_id')->whereIn('program_id', $program_ids)->count();
            if ($exam_applies > 0) {
                $data = ['user_id' => Auth::guard('subject_committee')->id()];
                $jobToDispatch = (new MoveExamCommitteeJob($data))->delay(Carbon::now()->addSeconds(30));
                dispatch($jobToDispatch);
                return 'success';
            } else {
                return 'no';
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
