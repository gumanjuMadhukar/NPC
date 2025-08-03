<?php
namespace App\Services\OfficeAdmin;

use App\Models\Fee;

class FeeService
{
    public function list($per_page, $page, $q)
    {
        try {
            $query = Fee::select('*');
            if ($q) {
                $query->whereAny(['name'], 'LIKE', '%' . $q . '%');
            }
            $data['fees'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['fees']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['fees']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['fees']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['fees']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['fees']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Fee::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'Fee enabled successfully';
            } else {
                $response['message'] = 'Fee disabled successfully';
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
                $fee = Fee::findOrFail($id);
                $response['message'] = 'Fee updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $fee = new Fee;
                $response['message'] = 'Fee created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $fee->name = $request['name'];
            $fee->level_id = $request['level_id'];
            $fee->amount = $request['amount'];
            $fee->college_type = $request['college_type'];
            $fee->description = $request['description'];
            $fee->status = $request['status'] ?? 0;
            $fee->save();
            $response['error'] = null;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
