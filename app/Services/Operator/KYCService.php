<?php
namespace App\Services\Operator;

use App\Models\Certificate;
use App\Models\Kyc;

class KYCService
{
    public function list($per_page, $page, $q)
    {
        try {
            $query = Kyc::select('*');
            if ($q) {
                $query->whereAny(['name'], 'LIKE', '%' . $q . '%');
            }
            $data['kycs'] = $query->orderBy('created_at', 'asc')->paginate($per_page);
            $data['kycs']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['kycs']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['kycs']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['kycs']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['kycs']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function delete($id)
    {
        try {
            $exam_apply = Kyc::where('id', $id)->first();
            $exam_apply->delete();
            $response['message'] = 'KYC deleted successfully';
            $response['error'] = null;
            $response['status'] = 200;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function certificate_list($per_page, $page, $q, $is_printed , $level_id,  $program_id , $decision_date)
    {

        try {
            $query = Certificate::select('*')->where('is_printed', $is_printed);
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny([ 'email', 'phone'], 'LIKE', '%' . $q . '%');
                })->orWhereAny(['cert_registration_number', 'name'], 'LIKE', '%' . $q . '%');
            }
            if ($level_id) {
                $query->where('level_id', $level_id);
            }
            if ($program_id) {
                $query->where('program_id', $program_id);
            }
            if ($decision_date) {
                $query->where('decision_date', $decision_date);
            }

            $data['certificates'] = $query->orderBy('id', 'desc')->paginate($per_page);

            $data['certificates']->appends(array('q' => $q, 'level_id' => $level_id, 'program_id' => $program_id, 'decision_date' => $decision_date));
            if ($page != 1) {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['certificates']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['certificates']->count();
            }
            // dd($data);
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
