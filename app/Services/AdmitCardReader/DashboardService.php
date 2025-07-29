<?php

namespace App\Services\AdmitCardReader;

use App\Models\Exam;
use App\Models\ExamApply;

class DashboardService
{
    public function list($per_page, $page, $q)
    {

        try {
            $query = Exam::select('*');
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
            }
            $data['exams'] = $query->orderBy('id', 'asc')->paginate($per_page);
            $data['exams']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['exams']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['exams']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['exams']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['exams']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function programWiseStudents($per_page, $page, $q, $program_id, $exam_id)
    {

        try {
            $query = ExamApply::select('*')->where('exam_id',$exam_id)->where('program_id', $program_id);
            if ($q) {
                $query->where(function ($qry) use ($q) {
                    $qry->whereHas('user', function ($qry) use ($q) {
                        $qry->where(function ($q2) use ($q) {
                            $q2->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                        });
                    })->orWhereHas('user_info', function ($qry) use ($q) {
                        $qry->where(function ($q2) use ($q) {
                            $q2->whereAny(['first_name', 'middle_name', 'last_name', 'citizenship_number'], 'LIKE', '%' . $q . '%');
                        });
                    });
                });
            }
            $data['program_wise_students'] = $query->orderBy('id', 'asc')->paginate($per_page);
            $data['program_wise_students']->appends(array('q'=> $q));
            if ($page != 1) {
                $data['total_data'] = $data['program_wise_students']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['program_wise_students']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['program_wise_students']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['program_wise_students']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
