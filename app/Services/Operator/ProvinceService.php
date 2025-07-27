<?php
namespace App\Services\Operator;

use App\Models\Province;

class ProvinceService
{
    public function list($per_page, $page, $q)
    {
        try {
            $query = Province::select('*');
            if ($q) {
                $query->whereAny(['name'], 'Like', '%' . $q . '%');
            }
            $data['provinces'] = $query->orderBy('id', 'asc')->paginate($per_page);
            $data['provinces']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['provinces']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['provinces']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['provinces']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['provinces']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Province::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'Province enabled successfully';
            } else {
                $response['message'] = 'Province disabled successfully';
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
                $province = Province::findOrFail($id);
                $response['message'] = 'Province updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $province = new Province;
                $response['message'] = 'Province created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $province->name = $request['name'];
            $province->status = $request['status'] ?? 0;
            $province->save();
            $response['error'] = null;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
