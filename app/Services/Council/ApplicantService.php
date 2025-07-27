<?php

namespace App\Services\Council;

use App\Models\ExamApply;
use App\Models\ExamLog;
use Illuminate\Support\Facades\Auth;

class ApplicantService
{
    public function list($per_page, $page, $q, $exam_id, $level_id, $program_id, $status)
    {
        try {
            $query = ExamApply::select('*')->where('state', 'council');
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
            }
            if ($exam_id) {
                if($exam_id == 'tslc'){
                    $query->whereNull('exam_id');
                }else{
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
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            if ($request['status'] === "accepted") {
                $status = 'progress';
                $state = 'registrar';
                $remarks = 'Exam Applied has been accepted';
                $exam_log_remarks = 'Profile Verified and forwarded to Registrar';
            } elseif ($request['status'] === "rejected") {
                $status = 'rejected';
                $state = 'council';
                $remarks = $request['remarks'];
                $exam_log_remarks = 'Rejected By Council';
            } else {
                $status = 'pending';
                $state = 'council';
                $remarks = $request['remarks'];
                $exam_log_remarks = 'Pending By Council';
            }
            $exam_apply = ExamApply::where('id', $request['id'])->first();
            $exam_apply->rejected = $request['status'] === "rejected" ? 1 : 0;
            $exam_apply->status = $status;
            $exam_apply->state = $state;
            $exam_apply->remarks = $remarks;
            $exam_apply->save();
            //ExamApply::where('id', $request['id'])->update(['status' => $status, 'remarks' => $remarks]);
            $exam_log = new ExamLog;
            $exam_log->user_id = $exam_apply->user_id;
            $exam_log->exam_apply_id = $exam_apply->id;
            $exam_log->system_user_id = Auth::guard('council')->id();
            $exam_log->status = $request['status'];
            $exam_log->state = 'council';
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
   
    public function passedList($per_page, $page, $q)
    {
        try {
            $query = ExamApply::select('*')->where('state','council')->where('level_id','<>', 4)->where('status', 'progress')->orderby('id','desc');
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
            }
            $data['applicants'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['applicants']->appends(array('q' => $q));
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
