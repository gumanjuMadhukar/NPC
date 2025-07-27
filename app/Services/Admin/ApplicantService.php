<?php

namespace App\Services\Admin;

use App\Models\ExamApply;

class ApplicantService
{
    public function list($per_page, $page, $q, $exam_id, $level_id, $program_id, $status)
    {

        try {
            $query = ExamApply::select('*')->with('admit_card');
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
                $query->where('exam_id', $exam_id);
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
}
