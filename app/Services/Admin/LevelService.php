<?php
namespace App\Services\Admin;

use App\Models\Level;

class LevelService
{
    public function list($per_page, $page, $q)
    {
        try {
            $query = Level::select('*');
            if ($q) {
                $query->whereAny(['name', 'code'], 'LIKE', '%' . $q . '%');
            }
            $data['levels'] = $query->orderBy('order', 'desc')->paginate($per_page);
            $data['levels']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['levels']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['levels']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['levels']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['levels']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Level::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'Level enabled successfully';
            } else {
                $response['message'] = 'Level disabled successfully';
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
                $level = Level::findOrFail($id);
                $response['message'] = 'Level updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $level = new Level;
                $response['message'] = 'Level created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $level->name = $request['name'];
            $level->short_name_english = $request['short_name_english'];
            $level->short_name_nepali = $request['short_name_nepali'];
            $level->code = $request['code'];
            $level->order = $request['order'];
            $level->status = $request['status'] ?? 0;
            $level->save();
            $response['error'] = null;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
