<?php
namespace App\Services\Operator;

use App\Models\Municipality;

class MunicipalityService
{
    public function list($per_page, $page, $q)
    {
        try {
            $query = Municipality::select('*');
            if($q){
                $query->whereAny(['name'], 'Like', '%' . $q . '%');
            }
            $data['municipalities'] = $query->orderBy('id', 'asc')->paginate($per_page);
            $data['municipalities']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['municipalities']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['municipalities']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['municipalities']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['municipalities']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Municipality::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'Municipality enabled successfully';
            } else {
                $response['message'] = 'Municipality disabled successfully';
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
                $municipality = Municipality::findOrFail($id);
                $response['message'] = 'Municipality updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $municipality = new Municipality;
                $response['message'] = 'Municipality created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $municipality->district_id = $request['district_id'];
            $municipality->name = $request['name'];
            $municipality->status = $request['status'] ?? 0;
            $municipality->save();
            $response['error'] = null;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}