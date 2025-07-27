<?php

namespace App\Services\ExamCommittee;

use App\Jobs\ExamCommittee\GenerateAdmitCard;
use App\Models\ExamApply;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ApplicantService
{
    // public function generateAdmitCard($request){
    //     $exam_id = $request['exam_id'];
    //     $program_id = $request['program_id'];

    //     try {
    //         $exam_applies = ExamApply::where([
    //                 'state' => 'exam_committee', 
    //                 'status' => 'progress', 
    //                 'is_admit_card_generate' => 0,
    //             ])
    //             ->whereNull('exam_id')
    //             ->whereIn('program_id', $program_id)
    //             ->count();

    //         if ($exam_applies > 0) {
    //             $data = ['user_id' => Auth::guard('exam_committee')->id()];
    //             $jobToDispatch = (new GenerateAdmitCard($data))->delay(Carbon::now()->addSeconds(1));
    //             dispatch($jobToDispatch);
    //             return 'success';
    //         } else {
    //             return 'no';
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }

    public function list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $role_name)
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

    public function approved_list($per_page, $page, $q, $exam_id, $level_id, $status, $program_id, $college_name, $role_name)
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
}
