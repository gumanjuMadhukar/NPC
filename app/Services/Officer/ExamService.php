<?php

namespace App\Services\Officer;

use App\Models\Exam;

class ExamService
{
    public function list($per_page, $page, $q)
    {
        try {
            $query = Exam::select('*');
            if ($q) {
                $query->whereAny(['name'], 'LIKE', '%' . $q . '%');
            }
            $data['exams'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['exams']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['exams']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['exams']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['exams']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['exams']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Exam::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'Exam enabled successfully';
            } else {
                $response['message'] = 'Exam disabled successfully';
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
                $exam = Exam::findOrFail($id);
                $response['message'] = 'Exam updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $exam = new Exam;
                $response['message'] = 'Exam created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $exam->name = $request['name'];
            $exam->name_nep = $request['name_nep'];
            $exam->opening_date = $request['opening_date'];
            $exam->closing_date = $request['closing_date'];
            $exam->description = $request['description'];
            $exam->status = $request['status'] ?? 0;
            $exam->save();
            $response['error'] = null;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
