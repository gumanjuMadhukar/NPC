<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\ProgramExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Program\StoreRequest;
use App\Models\Level;
use App\Models\Program;
use App\Models\SubjectCommittee;
use App\Services\Admin\ProgramService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProgramController extends Controller
{

    public function __construct(protected ProgramService $service)
    {
    }

    public function list(Request $request)
    {
        $data['nav'] = 'program';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Program';
        $per_page = 200;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('admin.program.list', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'program';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add Program" : "Edit Program";
        $data['action'] = route('admin-program-store');
        $data['row'] = Program::where('id', $id)->first();
        $data['levels'] = Level::where('status', 1)->get();
        $data['subject_committees'] = SubjectCommittee::where('status', 1)->get();
        return view('admin.program.add', $data);
    }

    public function store(StoreRequest $request)
    {
        return $this->service->store($request->validated());
    }

    public function export()
    {
        return Excel::download(new ProgramExport, 'program-' . Carbon::now()->format('y-m-d') . '.xlsx');
    }

}
