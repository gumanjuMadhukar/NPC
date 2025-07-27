<?php

namespace App\Services\Registrar;

use App\Jobs\Registrar\ExamApplyStatusJob;
use App\Models\ExamApply;
use App\Models\ExamLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ApplicantService
{
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
                $query->where('id', $program_id);
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
    public function approvedList($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $role_name)
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
                    $query->whereHas('exam_applies', function ($query) {
                        $query->whereNull('exam_id');
                    })->get();
                } else {
                    $query->whereHas('exam_applies', function ($query) use ($exam_id) {
                        $query->where('exam_id', $exam_id);
                    })->get();
                }
            }
            if ($level_id) {
                $query->whereHas('exam_applies', function ($query) use ($level_id) {
                    $query->where('level_id', $level_id);
                })->get();
            }
            if ($program_id) {
                $query->whereHas('exam_applies', function ($query) use ($program_id) {
                    $query->where('program_id', $program_id);
                })->get();
            }
            $query->where('status', 'accepted');

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
    public function rejectedList($per_page, $page, $q, $exam_id, $level_id, $program_id, $role_name)
    {

        try {
            // $query = ExamApply::select('*')->where('state', 'operator');
            $query = ExamApply::select('exam_applies.*')
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
            if ($role_name) {
                $query->where('state', $role_name);
            }
            $data['applicants'] = $query->orderBy('id', 'asc')->paginate($per_page);

            $data['applicants']->appends(array('q' => $q, 'exam_id' => $exam_id, 'level_id' => $level_id, 'program_id' => $program_id, 'state' => $role_name));
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
    public function pendingList($per_page, $page, $q, $exam_id, $level_id, $program_id, $role_name)
    {

        try {
            // $query = ExamApply::select('*')->where('state', 'operator');
            $query = ExamApply::select('exam_applies.*')
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
            if ($role_name) {
                $query->where('state', $role_name);
            }
            $data['applicants'] = $query->orderBy('id', 'asc')->paginate($per_page);

            $data['applicants']->appends(array('q' => $q, 'exam_id' => $exam_id, 'level_id' => $level_id, 'program_id' => $program_id, 'state' => $role_name));
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
                $state = 'subject_committee';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Exam Applied has been accepted';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Profile Verified and forwarded to Subject Committee';
                $suject = 'Application Form Approval Notification';
            } elseif ($request['status'] === "rejected") {
                $status = 'rejected';
                $state = 'registrar';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Rejected By Registrar';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Rejected By Registrar';
                $suject = 'Application Form Status Update';
            } elseif ($request['status'] === "onhold") {
                $status = 'onhold';
                $state = 'operator';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Hold By Registrar';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Hold By Registrar';
            } else {
                $status = 'pending';
                $state = 'registrar';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Pending By Registrar';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Pending By Registrar';
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
            $exam_log->system_user_id = Auth::guard('registrar')->id();
            $exam_log->status = $request['status'];
            $exam_log->state = 'registrar';
            $exam_log->remarks = $exam_log_remarks;
            $exam_log->save();

            if ($request['status'] === "accepted" || $request['status'] === "rejected") {
                $email_data = [
                    'name' => $exam_apply->user->name,
                    'email' => $exam_apply->user->email,
                    'status' => $request['status'],
                    'subject' => $suject,
                    'remarks' => $remarks,
                ];
                $jobToDispatch = (new ExamApplyStatusJob($email_data))->delay(Carbon::now()->addSeconds(1));
                dispatch($jobToDispatch);
            }

            $response['message'] = 'Status updated successfully.';
            $response['error'] = null;
            $response['status'] = 201;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function moveToSubjectCommittee($exam_id)
    {
        try {
            $state = 'subject_committee';
            $remarks = 'Exam applied has been accepted by Registrar';
            $subject = 'Application Form Approval Notification';
            $status = 'accepted';

            $applicants = ExamApply::where('exam_id', $exam_id)->where('status', 'progress')->where('state', 'registrar')->get();
            foreach ($applicants as $applicant) {
                $applicant->state = $state;
                $applicant->remarks = $remarks;
                $applicant->save();

                $exam_log = new ExamLog;
                $exam_log->user_id = $applicant->user_id;
                $exam_log->exam_apply_id = $applicant->id;
                $exam_log->system_user_id = Auth::guard('registrar')->id();
                $exam_log->status = $status;
                $exam_log->state = 'registrar';
                $exam_log->remarks = $remarks;
                $exam_log->save();

                $email_data = [
                    'name' => $applicant->user->name,
                    'email' => $applicant->user->email,
                    'status' => $status,
                    'subject' => $subject,
                    'remarks' => $remarks,
                ];
                $jobToDispatch = (new ExamApplyStatusJob($email_data))->delay(Carbon::now()->addSeconds(1));
                dispatch($jobToDispatch);
            }

            return redirect()->back()->with('success', 'All applicants have been moved to the subject committee.');

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
