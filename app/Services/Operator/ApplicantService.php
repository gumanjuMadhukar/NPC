<?php

namespace App\Services\Operator;

use App\Exports\Operator\ApplicantExport;
use App\Exports\Operator\ApplicantProgramExport;
use App\Jobs\Operator\ExamApplyStatusJob;
use App\Models\ExamApply;
use App\Models\ExamLog;
use App\Models\UserInfo;
use App\Models\UserQualification;
use App\Traits\StoreImageTrait;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ApplicantService
{

    use StoreImageTrait;

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

    public function list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $college_name, $state_name)
    {

        try {
            // $query = ExamApply::select('*')->where('state', 'operator');
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
            if ($college_name) {
                $query->whereHas('user.qualifications', function ($qry) use ($college_name) {
                    $qry->where('college_name', $college_name);
                });
            }
            if ($state_name) {
                $query->where('state', $state_name);
            }
            $data['applicants'] = $query->orderBy('id', 'asc')->paginate($per_page);

            $data['applicants']->appends(array('q' => $q, 'exam_id' => $exam_id, 'level_id' => $level_id, 'program_id' => $program_id, 'status' => $status, 'college_name' => $college_name, 'state' => $state_name));
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
    public function myList($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $college_name, $state_name)
    {

        try {
            // $query = ExamApply::select('*')->where('state', 'operator');
            $query = ExamApply::select('exam_applies.*')
                ->where('exam_applies.state', 'operator');
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
                if (is_array($status)) {
                    $query->whereIn('status', $status);
                } else {
                    $query->where('status', $status);
                }
            }
            if ($college_name) {
                $query->whereHas('user.qualifications', function ($qry) use ($college_name) {
                    $qry->where('college_name', $college_name);
                });
            }
            if ($state_name) {
                $query->where('state', $state_name);
            }
            $data['applicants'] = $query->orderBy('id', 'asc')->paginate($per_page);

            $data['applicants']->appends(array('q' => $q, 'exam_id' => $exam_id, 'level_id' => $level_id, 'program_id' => $program_id, 'status' => $status, 'college_name' => $college_name, 'state' => $state_name));
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

    public function approved_list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $college_name, $role_name)
    {

        try {
            // $query = ExamApply::select('*')->where('state', 'operator');
            $query = ExamApply::select('exam_applies.*')
                ->where('exam_applies.state', '<>', 'operator');
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

            if ($college_name) {
                $query->whereHas('user.qualifications', function ($qry) use ($college_name) {
                    $qry->where('college_name', $college_name);
                });
            }
            if ($role_name) {
                $query->where('state', '<>', $role_name);
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
    public function rejected_list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $college_name, $role_name)
    {

        try {
            // $query = ExamApply::select('*')->where('state', 'operator');
            $query = ExamApply::select('exam_applies.*')
                ->where('exam_applies.state', 'operator')
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
    public function pending_list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $college_name, $role_name)
    {

        try {
            // $query = ExamApply::select('*')->where('state', 'operator');
            $query = ExamApply::select('exam_applies.*')
                ->where('exam_applies.state', 'operator')
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

            if ($college_name) {
                $query->whereHas('user.qualifications', function ($qry) use ($college_name) {
                    $qry->where('college_name', $college_name);
                });
            }
            if ($role_name) {
                $query->where('state', $role_name);
            }
            $data['applicants'] = $query->orderBy('id', 'asc')->paginate($per_page);

            $data['applicants']->appends(array('q' => $q, 'exam_id' => $exam_id, 'level_id' => $level_id, 'program_id' => $program_id, 'status' => $status, 'college_name' => $college_name));
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
                $state = 'officer';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Exam Applied has been accepted';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Profile Verified and forwarded to Officer';
                $subject = 'Application Form Approval Notification';
            } elseif ($request['status'] === "rejected") {
                $status = 'rejected';
                $state = 'operator';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Rejected By Computer Operator';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Rejected By Computer Operator';
                $subject = 'Application Form Status Update';
            } elseif ($request['status'] === "onhold") {
                $status = 'onhold';
                $state = 'operator';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Hold By Computer Operator';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Hold By Computer Operator';
            } else {
                $status = 'pending';
                $state = 'operator';
                $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Pending By Computer Operator';
                $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Pending By Computer Operator';
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
            $exam_log->system_user_id = Auth::guard('operator')->id();
            $exam_log->status = $request['status'];
            $exam_log->state = 'operator';
            $exam_log->remarks = $exam_log_remarks;
            $exam_log->save();

            if ($request['status'] === "accepted" || $request['status'] === "rejected") {
                $email_data = [
                    'name' => $exam_apply->user->name,
                    'email' => $exam_apply->user->email,
                    'status' => $request['status'],
                    'subject' => $subject,
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

    public function edit_apply($request)
    {
        try {
            $exam_apply = ExamApply::where('id', $request['id'])->first();
            if (preg_match('#^data:image.*?base64,#', $request['voucher_image'])) {
                $voucher_image = $this->StoreBase64Image($request['voucher_image'], '/student/');
            } else {
                $voucher_image = ($request['voucher_image']) ? $request['voucher_image'] : null;
            }
            $exam_apply->exam_id = $request['exam_id'];
            $exam_apply->level_id = $request['level'];
            $exam_apply->program_id = $request['program'];
            $exam_apply->voucher_image = $voucher_image;
            // $exam_apply->status = 'progress';
            // $exam_apply->state = 'operator';
            $exam_apply->update();

            // $exam_log = new ExamLog;
            // $exam_log->user_id = $exam_apply->user_id;
            // $exam_log->exam_apply_id = $exam_apply->id;
            // $exam_log->system_user_id = Auth::guard('operator')->id();
            // $exam_log->status = 'progress';
            // $exam_log->remarks = 'File has been updated.';
            // $exam_log->save();

            $response['data'] = $exam_apply;
            $response['message'] = 'Application Updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function savePersonal($request)
    {
        try {
            $user_info = UserInfo::where('id', $request['id'])->first();
            if (preg_match('#^data:image.*?base64,#', $request['profile_picture'])) {
                $profile_picture = $this->StoreBase64Image($request['profile_picture'], '/student/');
            } else {
                $profile_picture = ($request['profile_picture']) ? $request['profile_picture'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['citizenship_front'])) {
                $citizenship_front = $this->StoreBase64Image($request['citizenship_front'], '/student/');
            } else {
                $citizenship_front = $request['citizenship_front'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['citizenship_back'])) {
                $citizenship_back = $this->StoreBase64Image($request['citizenship_back'], '/student/');
            } else {
                $citizenship_back = $request['citizenship_back'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['signature_image'])) {
                $signature_image = $this->StoreBase64Image($request['signature_image'], '/student/');
            } else {
                $signature_image = $request['signature_image'] ?? null;
            }
            $user_info->profile_picture = $profile_picture;
            $user_info->citizenship_front = $citizenship_front;
            $user_info->citizenship_back = $citizenship_back;
            $user_info->signature_image = $signature_image;
            $user_info->first_name = $request['first_name'];
            $user_info->middle_name = $request['middle_name'];
            $user_info->last_name = $request['last_name'];
            $user_info->first_name_nep = $request['first_name_nep'];
            $user_info->middle_name_nep = $request['middle_name_nep'];
            $user_info->last_name_nep = $request['last_name_nep'];
            $user_info->dob_eng = $request['dob_eng'];
            $user_info->dob_nep = $request['dob_nep'];
            $user_info->sex = $request['sex'];
            $user_info->marital_status = $request['marital_status'];
            $user_info->ethinic = $request['ethinic'];
            $user_info->citizenship_number = $request['citizenship_number'];
            $user_info->citizenship_issue_date = $request['citizenship_issue_date'];
            $user_info->citizenship_issue_district = $request['citizenship_issue_district'];
            $user_info->province_id = $request['province'];
            $user_info->district_id = $request['district'];
            $user_info->municipality_id = $request['municipality'];
            $user_info->ward_no = $request['ward_no'];
            $user_info->level_id = $request['level'];
            $user_info->update();
            $response['data'] = $user_info;
            $response['message'] = 'Profile updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function saveTslc($request)
    {
        try {
            $user_qualification = UserQualification::where(['id' => $request['id'], 'level_id' => 4])->first();
            if (preg_match('#^data:image.*?base64,#', $request['transcript_image'])) {
                $transcript_image = $this->StoreBase64Image($request['transcript_image'], '/student/');
            } else {
                $transcript_image = ($request['transcript_image']) ? $request['transcript_image'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_2'])) {
                $transcript_bac_2 = $this->StoreBase64Image($request['transcript_bac_2'], '/student/');
            } else {
                $transcript_bac_2 = ($request['transcript_bac_2']) ? $request['transcript_bac_2'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_3'])) {
                $transcript_bac_3 = $this->StoreBase64Image($request['transcript_bac_3'], '/student/');
            } else {
                $transcript_bac_3 = ($request['transcript_bac_3']) ? $request['transcript_bac_3'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['ojt_image'])) {
                $ojt_image = $this->StoreBase64Image($request['ojt_image'], '/student/');
            } else {
                $ojt_image = $request['ojt_image'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = ((isset($request['college_type']) && $request['college_type'] == 'nepal') || ($request['id'] > 0)) ? $request['college_name'] : $request['international_college_name'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university = $request['board_university'];
            $user_qualification->registration_number = $request['registration_number'];
            $user_qualification->transcript_image = $transcript_image;
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->transcript_bac_2 = $transcript_bac_2;
            $user_qualification->transcript_bac_3 = $transcript_bac_3;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->ojt_image = $ojt_image;
            $user_qualification->update();
            $response['data'] = null;
            $response['message'] = 'TSLC updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function saveSlc($request)
    {
        try {
            $user_qualification = UserQualification::where(['id' => $request['id'], 'level_id' => 5])->first();
            if (preg_match('#^data:image.*?base64,#', $request['transcript_image'])) {
                $transcript_image = $this->StoreBase64Image($request['transcript_image'], '/student/');
            } else {
                $transcript_image = ($request['transcript_image']) ? $request['transcript_image'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = $request['school_name'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university = $request['board_university'];
            $user_qualification->transcript_image = $transcript_image;
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->equivalence_certificate = $equivalence_certificate;
            $user_qualification->update();
            $response['data'] = null;
            $response['message'] = 'SLC updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function savePcl($request)
    {
        try {
            $user_qualification = UserQualification::where(['id' => $request['id'], 'level_id' => 3])->first();
            if (!$user_qualification) {
                $user_qualification = new UserQualification;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_image'])) {
                $transcript_image = $this->StoreBase64Image($request['transcript_image'], '/student/');
            } else {
                $transcript_image = ($request['transcript_image']) ? $request['transcript_image'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['council_registration_certificate'])) {
                $council_registration_certificate = $this->StoreBase64Image($request['council_registration_certificate'], '/student/');
            } else {
                $council_registration_certificate = $request['council_registration_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['ojt_pcl_community_1_image'])) {
                $ojt_pcl_community_1_image = $this->StoreBase64Image($request['ojt_pcl_community_1_image'], '/student/');
            } else {
                $ojt_pcl_community_1_image = $request['ojt_pcl_community_1_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['ojt_pcl_community_2_image'])) {
                $ojt_pcl_community_2_image = $this->StoreBase64Image($request['ojt_pcl_community_2_image'], '/student/');
            } else {
                $ojt_pcl_community_2_image = $request['ojt_pcl_community_2_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['noc_image'])) {
                $noc_image = $this->StoreBase64Image($request['noc_image'], '/student/');
            } else {
                $noc_image = $request['noc_image'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = ((isset($request['college_type']) && $request['college_type'] == 'nepal' && isset($request['board_university']) && $request['board_university'] == 'PCL') || ($request['id'] > 0)) ? $request['college_name'] : $request['international_college_name'];
            $user_qualification->admission_year = $request['admission_year'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university = $request['board_university'];
            $user_qualification->registration_number = $request['registration_number'];
            $user_qualification->transcript_image = $transcript_image;
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->equivalence_certificate = $equivalence_certificate;
            $user_qualification->council_registration_certificate = $council_registration_certificate;
            $user_qualification->ojt_pcl_community_1_image = $ojt_pcl_community_1_image;
            $user_qualification->ojt_pcl_community_2_image = $ojt_pcl_community_2_image;
            $user_qualification->noc_image = $noc_image;
            $user_qualification->update();
            $response['data'] = null;
            $response['message'] = 'PCL updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function saveBachelor($request)
    {
        try {
            $user_qualification = UserQualification::where(['id' => $request['id'], 'level_id' => 2])->first();
            if (!$user_qualification) {
                $user_qualification = new UserQualification;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_2'])) {
                $transcript_bac_2 = $this->StoreBase64Image($request['transcript_bac_2'], '/student/');
            } else {
                $transcript_bac_2 = ($request['transcript_bac_2']) ? $request['transcript_bac_2'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_3'])) {
                $transcript_bac_3 = $this->StoreBase64Image($request['transcript_bac_3'], '/student/');
            } else {
                $transcript_bac_3 = ($request['transcript_bac_3']) ? $request['transcript_bac_3'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_4'])) {
                $transcript_bac_4 = $this->StoreBase64Image($request['transcript_bac_4'], '/student/');
            } else {
                $transcript_bac_4 = ($request['transcript_bac_4']) ? $request['transcript_bac_4'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_5'])) {
                $transcript_bac_5 = $this->StoreBase64Image($request['transcript_bac_5'], '/student/');
            } else {
                $transcript_bac_5 = ($request['transcript_bac_5']) ? $request['transcript_bac_5'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_6'])) {
                $transcript_bac_6 = $this->StoreBase64Image($request['transcript_bac_6'], '/student/');
            } else {
                $transcript_bac_6 = ($request['transcript_bac_6']) ? $request['transcript_bac_6'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_7'])) {
                $transcript_bac_7 = $this->StoreBase64Image($request['transcript_bac_7'], '/student/');
            } else {
                $transcript_bac_7 = ($request['transcript_bac_7']) ? $request['transcript_bac_7'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_8'])) {
                $transcript_bac_8 = $this->StoreBase64Image($request['transcript_bac_8'], '/student/');
            } else {
                $transcript_bac_8 = ($request['transcript_bac_8']) ? $request['transcript_bac_8'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['intership_image'])) {
                $intership_image = $this->StoreBase64Image($request['intership_image'], '/student/');
            } else {
                $intership_image = $request['intership_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['noc_image'])) {
                $noc_image = $this->StoreBase64Image($request['noc_image'], '/student/');
            } else {
                $noc_image = $request['noc_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['visa_image'])) {
                $visa_image = $this->StoreBase64Image($request['visa_image'], '/student/');
            } else {
                $visa_image = $request['visa_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['passport_image'])) {
                $passport_image = $this->StoreBase64Image($request['passport_image'], '/student/');
            } else {
                $passport_image = $request['passport_image'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = ((isset($request['college_type']) && $request['college_type'] == 'nepal') || ($request['id'] > 0)) ? $request['college_name'] : $request['international_college_name'];
            $user_qualification->admission_year = $request['admission_year'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university = ((isset($request['board_university']) && $request['board_university'] != 'Other') || ($request['id'] > 0)) ? $request['board_university'] : $request['other_board_university'];
            $user_qualification->registration_number = $request['registration_number'];
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->transcript_bac_2 = $transcript_bac_2;
            $user_qualification->transcript_bac_3 = $transcript_bac_3;
            $user_qualification->transcript_bac_4 = $transcript_bac_4;
            $user_qualification->transcript_bac_5 = $transcript_bac_5;
            $user_qualification->transcript_bac_6 = $transcript_bac_6;
            $user_qualification->transcript_bac_7 = $transcript_bac_7;
            $user_qualification->transcript_bac_8 = $transcript_bac_8;
            $user_qualification->equivalence_certificate = $equivalence_certificate;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->intership_image = $intership_image;
            $user_qualification->noc_image = $noc_image;
            $user_qualification->visa_image = $visa_image;
            $user_qualification->passport_image = $passport_image;
            $user_qualification->update();
            $response['data'] = null;
            $response['message'] = 'Bachelor updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function saveMaster($request)
    {
        try {
            $user_qualification = UserQualification::where(['id' => $request['id'], 'level_id' => 1])->first();
            if (!$user_qualification) {
                $user_qualification = new UserQualification;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_mas_marksheet'])) {
                $transcript_mas_marksheet = $this->StoreBase64Image($request['transcript_mas_marksheet'], '/student/');
            } else {
                $transcript_mas_marksheet = ($request['transcript_mas_marksheet']) ? $request['transcript_mas_marksheet'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_2'])) {
                $transcript_bac_2 = $this->StoreBase64Image($request['transcript_bac_2'], '/student/');
            } else {
                $transcript_bac_2 = ($request['transcript_bac_2']) ? $request['transcript_bac_2'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_3'])) {
                $transcript_bac_3 = $this->StoreBase64Image($request['transcript_bac_3'], '/student/');
            } else {
                $transcript_bac_3 = ($request['transcript_bac_3']) ? $request['transcript_bac_3'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['intership_image'])) {
                $intership_image = $this->StoreBase64Image($request['intership_image'], '/student/');
            } else {
                $intership_image = $request['intership_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['noc_image'])) {
                $noc_image = $this->StoreBase64Image($request['noc_image'], '/student/');
            } else {
                $noc_image = $request['noc_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['visa_image'])) {
                $visa_image = $this->StoreBase64Image($request['visa_image'], '/student/');
            } else {
                $visa_image = $request['visa_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['passport_image'])) {
                $passport_image = $this->StoreBase64Image($request['passport_image'], '/student/');
            } else {
                $passport_image = $request['passport_image'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = ((isset($request['college_type']) && $request['college_type'] == 'nepal') || ($request['id'] > 0)) ? $request['college_name'] : $request['international_college_name'];
            $user_qualification->admission_year = $request['admission_year'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university = ((isset($request['board_university']) && $request['board_university'] != 'Other') || ($request['id'] > 0)) ? $request['board_university'] : $request['other_board_university'];
            $user_qualification->registration_number = $request['registration_number'];
            $user_qualification->transcript_mas_marksheet = $transcript_mas_marksheet;
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->transcript_bac_2 = $transcript_bac_2;
            $user_qualification->transcript_bac_3 = $transcript_bac_3;
            $user_qualification->equivalence_certificate = $equivalence_certificate;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->intership_image = $intership_image;
            $user_qualification->noc_image = $noc_image;
            $user_qualification->visa_image = $visa_image;
            $user_qualification->passport_image = $passport_image;
            $user_qualification->update();
            $response['data'] = null;
            $response['message'] = 'Master updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function delete($id)
    {
        try {
            $exam_apply = ExamApply::where('id', $id)->first();
            $exam_apply->delete();
            $response['message'] = 'Application Deleted successfully';
            $response['error'] = null;
            $response['status'] = 200;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function collegeImageDelete($request)
    {
        try {
            $field_name = $request->field_name;
            $ras = UserQualification::where(['user_id' => Auth::guard('student')->id(), 'id' => $request->id])->first();
            if ($ras) {
                Storage::disk('public')->delete('/student/' . $ras->$field_name);
                $ras->$field_name = '';
                $ras->save();
            }
            $response['message'] = 'Image deleted successfully.';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function state($request)
    {
        try {
            $status = 'progress';
            $state = $request['state'];
            $remarks = 'Exam Applied has been forwarded to' . $request['state'];
            $exam_log_remarks = 'Profile Verified and forwarded to ' . $request['state'];
            $subject = 'Application Form Forwarded Notification';

            $exam_apply = ExamApply::where('id', $request['id'])->first();
            $exam_apply->status = $status;
            $exam_apply->state = $state;
            $exam_apply->remarks = $remarks;
            $exam_apply->save();

            $exam_log = new ExamLog;
            $exam_log->user_id = $exam_apply->user_id;
            $exam_log->exam_apply_id = $exam_apply->id;
            $exam_log->system_user_id = Auth::guard('operator')->id();
            $exam_log->status = $status;
            $exam_log->state = $state;
            $exam_log->remarks = $exam_log_remarks;
            $exam_log->save();

            $email_data = [
                'name' => $exam_apply->user->name,
                'email' => $exam_apply->user->email,
                'state' => $state,
                'status' => $status,
                'subject' => $subject,
                'remarks' => $remarks,
            ];
            $jobToDispatch = (new ExamApplyStatusJob($email_data))->delay(Carbon::now()->addSeconds(1));
            dispatch($jobToDispatch);

            $response['message'] = 'File forwarded to ' . $request['state'] . ' successfully.';
            $response['error'] = null;
            $response['status'] = 201;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function forwardReExam($request)
    {
        try {
            $status = 'progress';
            $state = 'exam-committee';
            $remarks = 'Exam Applied has been forwarded to ' . $state;
            $exam_log_remarks = 'Profile Verified and forwarded to ' . $state;
            $subject = 'Application Form Forwarded Notification';

            $exam_applies = ExamApply::where('state', 'operator')->where('status','re-exam')->get();
            foreach ($exam_applies as $exam_apply) {
                $exam_apply->status = $status;
                $exam_apply->state = $state;
                $exam_apply->remarks = $remarks;
                $exam_apply->save();

                $exam_log = new ExamLog;
                $exam_log->user_id = $exam_apply->user_id;
                $exam_log->exam_apply_id = $exam_apply->id;
                $exam_log->system_user_id = Auth::guard('operator')->id();
                $exam_log->status = $status;
                $exam_log->state = $state;
                $exam_log->remarks = $exam_log_remarks;
                $exam_log->save();

                $email_data = [
                    'name' => $exam_apply->user->name,
                    'email' => $exam_apply->user->email,
                    'state' => $state,
                    'status' => $status,
                    'subject' => $subject,
                    'remarks' => $remarks,
                ];
                $jobToDispatch = (new ExamApplyStatusJob($email_data))->delay(Carbon::now()->addSeconds(1));
                dispatch($jobToDispatch);
            }
            
            $response['message'] = 'File forwarded to exam committee successfully.';
            $response['error'] = null;
            $response['status'] = 201;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    function selectedForwardReExam($request) {
        try {
            $status = 'progress';
            $state = 'exam-committee';
            $remarks = 'Exam Applied has been forwarded to ' . $state;
            $exam_log_remarks = 'Profile Verified and forwarded to ' . $state;
            $subject = 'Application Form Forwarded Notification';
            $ids = $request['selected_ids'];

            $exam_applies = ExamApply::where('state', 'operator')->whereIn('id', $ids)->where('status','re-exam')->get();
            foreach ($exam_applies as $exam_apply) {
                $exam_apply->status = $status;
                $exam_apply->state = $state;
                $exam_apply->remarks = $remarks;
                $exam_apply->save();

                $exam_log = new ExamLog;
                $exam_log->user_id = $exam_apply->user_id;
                $exam_log->exam_apply_id = $exam_apply->id;
                $exam_log->system_user_id = Auth::guard('operator')->id();
                $exam_log->status = $status;
                $exam_log->state = $state;
                $exam_log->remarks = $exam_log_remarks;
                $exam_log->save();

                $email_data = [
                    'name' => $exam_apply->user->name,
                    'email' => $exam_apply->user->email,
                    'state' => $state,
                    'status' => $status,
                    'subject' => $subject,
                    'remarks' => $remarks,
                ];
                $jobToDispatch = (new ExamApplyStatusJob($email_data))->delay(Carbon::now()->addSeconds(1));
                dispatch($jobToDispatch);
            }
            
            $response['message'] = 'File forwarded to exam committee successfully.';
            $response['error'] = null;
            $response['status'] = 201;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
