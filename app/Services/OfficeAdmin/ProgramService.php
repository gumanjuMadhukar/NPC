<?php
namespace App\Services\OfficeAdmin ;

use App\Models\Program;

class ProgramService
{
    public function list($per_page, $page, $q)
    {
        try {
            $query = Program::select('*');
            if ($q) {
                $query->whereAny(['name'], 'LIKE', '%' . $q . '%');
            }
            $data['programs'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['programs']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['programs']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['programs']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['programs']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['programs']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            Program::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'Program enabled successfully';
            } else {
                $response['message'] = 'Program disabled successfully';
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
                $program = Program::findOrFail($id);
                $response['message'] = 'Program updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $program = new Program;
                $response['message'] = 'Program created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $program->name = $request['name'];
            $program->certificate_name = $request['certificate_name'];
            $program->code = $request['code'];
            $program->qualification = $request['qualification'];
            $program->level_id = $request['level_id'];
            // $program->subject_committee_id = $request['subject_committee_id'];
            $program->program_duration = $request['program_duration'];
            $program->duration_type = $request['duration_type'];
            $program->program_type = $request['program_type'];
            $program->has_exam = $request['has_exam'] ?? 0;
            $program->status = $request['status'] ?? 0;
            // dd('Here I am Aarati, stucked in the program store', $program);

            $program->save();
            $response['error'] = null;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
