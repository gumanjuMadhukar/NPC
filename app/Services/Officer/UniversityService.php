<?php
namespace App\Services\Officer;

use App\Models\University;

class UniversityService
{
    public function list($per_page, $page, $q){
        
        try {
            $query = University::select('*');
            if ($q) {
                $query->whereAny(['name'], 'LIKE', '%' . $q . '%');
            }
            $data['universities'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['universities']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['universities']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['universities']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['universities']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['universities']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            University::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'University enabled successfully';
            } else {
                $response['message'] = 'University disabled successfully';
            }
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function store($request)
    {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $university = University::findOrFail($id);
                $response['message'] = 'University updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $university = new University;
                $response['message'] = 'University created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $university->name = $request['name'];
            $university->status = $request['status'] ?? 0;
            $university->save();
            $response['error'] = null;
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}