<?php
namespace App\Services\Admin;

use App\Models\College;

class CollegeService
{
    public function list($per_page, $page, $q){
        
        try {
            $query = College::select('*');
            if ($q) {
                $query->whereAny(['name'], 'LIKE', '%' . $q . '%');
            }
            $data['colleges'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['colleges']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['colleges']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['colleges']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['colleges']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['colleges']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            College::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'College enabled successfully';
            } else {
                $response['message'] = 'College disabled successfully';
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
                $university = College::findOrFail($id);
                $response['message'] = 'College updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $university = new College;
                $response['message'] = 'College created successfully.';
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