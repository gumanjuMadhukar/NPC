<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\Exam\StoreRequest;
use App\Models\Exam;
use App\Services\Operator\ExamService;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public function __construct(protected ExamService $service)
    {
    }

    public function list(Request $request)
    {
        $data['nav'] = 'exam';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Exam';
        $per_page = 10;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('operator.exam.list', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'exam';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add Exam" : "Edit Exam";
        $data['action'] = route('operator-exam-store');
        $data['row'] = Exam::where('id', $id)->first();
        return view('operator.exam.add', $data);
    }

    public function store(StoreRequest $request)
    {
        return $this->service->store($request->validated());
    }
}
