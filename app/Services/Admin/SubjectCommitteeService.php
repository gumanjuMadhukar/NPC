<?php
namespace App\Services\Admin;

use App\Models\SubjectCommittee;

class SubjectCommitteeService
{
    public function list($per_page, $page, $q)
    {
        try {
            $query = SubjectCommittee::select('*');
            if ($q) {
                $query->whereAny(['name', 'code'], 'Like', '%' . $q . '%');
            }
            $data['subjectcommittees'] = $query->orderBy('id', 'asc')->paginate($per_page);
            $data['subjectcommittees']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['subjectcommittees']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['subjectcommittees']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['subjectcommittees']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['subjectcommittees']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            SubjectCommittee::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'SubjectCommittee enabled successfully';
            } else {
                $response['message'] = 'SubjectCommittee disabled successfully';
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
                $subjectcommittee = SubjectCommittee::findOrFail($id);
                $response['message'] = 'Subject Committee updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $subjectcommittee = new SubjectCommittee;
                $response['message'] = 'Subject Committee created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $subjectcommittee->name = $request['name'];
            $subjectcommittee->code = $request['code'];
            $subjectcommittee->status = $request['status'] ?? 0;
            $subjectcommittee->save();
            $response['error'] = null;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
