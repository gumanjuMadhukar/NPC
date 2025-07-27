<?php

namespace App\Services\ExamCommittee;

use App\Models\Exam;

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
}
