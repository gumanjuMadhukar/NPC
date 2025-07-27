<?php
namespace App\Services\Operator;

use App\Models\District;

class DistrictService
{
    public function list($per_page, $page, $q)
    {
        try {
            $query = District::select('*');
            if($q){
                $query->whereAny(['name'], 'Like', '%' . $q . '%');
            }
            $data['districts'] = $query->orderBy('id', 'asc')->paginate($per_page);
            $data['districts']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['districts']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['districts']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['districts']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['districts']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            District::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'District enabled successfully';
            } else {
                $response['message'] = 'District disabled successfully';
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
                $district = District::findOrFail($id);
                $response['message'] = 'District updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $district = new District;
                $response['message'] = 'District created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $district->province_id = $request['province_id'];
            $district->name = $request['name'];
            $district->status = $request['status'] ?? 0;
            $district->save();
            $response['error'] = null;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}