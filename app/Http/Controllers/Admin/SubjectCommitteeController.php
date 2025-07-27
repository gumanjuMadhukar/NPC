<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubjectCommittee\StoreRequest;
use App\Models\SubjectCommittee;
use App\Services\Admin\SubjectCommitteeService;
use Illuminate\Http\Request;

class SubjectCommitteeController extends Controller
{
    public function __construct(protected SubjectCommitteeService $service)
    {
    }


    public function list(Request $request)
    {
        $data['nav'] = 'subjectcommittee';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Subject Committee';
        $per_page = 10;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('admin.subjectcommittee.list', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'subjectcommittee';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add Subject Committee" : "Edit Subject Committee";
        $data['action'] = route('admin-subjectcommittee-store');
        $data['row'] = SubjectCommittee::where('id', $id)->first();
        return view('admin.subjectcommittee.add', $data);
    }

    public function store(StoreRequest $request)
    {
        return $this->service->store($request->validated());
    }
}
