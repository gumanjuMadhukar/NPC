<?php

namespace App\Services\Officer;

use App\Models\ExamApply;
use App\Models\ExamLog;
use Illuminate\Support\Facades\Auth;
use App\Exports\Officer\ApplicantExport;
use App\Exports\Officer\ApplicantProgramExport;
use Maatwebsite\Excel\Facades\Excel;

class ApplicantService
{

    function export($request)
    {
        try {
            return Excel::download(new ApplicantExport($request), 'applicant.xlsx');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    function exportProgramWise($request)
    {
        try {
            return Excel::download(new ApplicantProgramExport($request), 'program_wise_applicant.xlsx');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $college_name, $role_name)
    {

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
                $query->where('level_id', $level_id);
            }
            if ($program_id) {
                $query->where('program_id', $program_id);
            }
            if ($status) {
                $query->where('status', $status);
            }
            if ($college_name) {
                $query->whereHas('user.qualifications', function ($qry) use ($college_name) {
                    $qry->where('college_name', $college_name);
                });
            }
            if ($role_name) {
                $query->where('state', $role_name);
            }
            $data['applicants'] = $query->orderBy('id', 'asc')->paginate($per_page);
            $data['applicants']->appends(array('q' => $q, 'exam_id' => $exam_id, 'level_id' => $level_id, 'program_id' => $program_id, 'status' => $status, 'college_name' => $college_name, 'state' => $role_name));
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
    public function approved_list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $role_name)
    {

        try {
            $query = ExamLog::select('*')->where('status', $status)->groupBy('user_id');
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
                    // $query->whereNull('exam_id');
                    $query->whereHas('exam_applies', function ($query) {
                        $query->whereNull('exam_id');
                    })->get();
                } else {
                    // $query->where('exam_id', $exam_id);
                    $query->whereHas('exam_applies', function ($query) use ($exam_id) {
                        $query->where('exam_id', $exam_id);
                    })->get();
                }
            }
            if ($level_id) {
                // $query->where('exam_applies.level_id', $level_id);
                $query->whereHas('exam_applies', function ($query) use ($level_id) {
                    $query->where('level_id', $level_id);
                })->get();
            }
            if ($program_id) {
                // $query->where('program_id', $program_id);
                $query->whereHas('exam_applies', function ($query) use ($program_id) {
                    $query->where('program_id', $program_id);
                })->get();
            }
            if ($role_name) {
                $query->where('state', $role_name);
                // if($status == "progress"  || $status == "accepted" ){
                //     $query->where('state','registrar');
                // }else{
                //     $query->where('state',$role_name);
                // }
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
    public function rejected_list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $role_name)
    {

        try {
            // $query = ExamApply::select('*')->where('state', 'Officer');
            $query = ExamApply::select('exam_applies.*')
                ->where('exam_applies.state', 'officer')
                ->where('exam_applies.status', 'rejected');
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
    public function pending_list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $role_name)
    {

        try {
            // $query = ExamApply::select('*')->where('state', 'Officer');
            $query = ExamApply::select('exam_applies.*')
                ->where('exam_applies.state', 'officer')
                ->whereIn('exam_applies.status', ['pending', 'onhold']);
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
                $state = 'officer';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Rejected By Officer';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Rejected By Officer';
            } elseif ($request['status'] === "onhold") {
                $status = 'onhold';
                $state = 'officer';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Hold By Officer';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Hold By Officer';
            } else {
                $status = 'pending';
                $state = 'officer';
                $remarks = $request['remarks'];
                $exam_log_remarks = 'Pending By Officer';
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
            $exam_log->system_user_id = Auth::guard('officer')->id();
            $exam_log->status = $request['status'];
            $exam_log->state = 'officer';
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
}
