<?php
namespace App\Services\Admin;

use App\Models\User;

class StudentService
{
    public function list($per_page, $page, $q){
        
        try {
            $query = User::where('role_id', 1);
            if ($q) {
                $query->whereAny(['name','email', 'phone',], 'LIKE', '%' . $q . '%');
            }
            $data['students'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['students']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['students']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['students']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['students']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['students']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delete($request)
    {
        try {
            $id = $request->id;
            User::where('id', $id)->delete();
            $response['message'] = 'Student deleted successfully.';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}