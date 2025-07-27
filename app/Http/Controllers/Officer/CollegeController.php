<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Officer\College\StoreRequest;
use App\Models\College;
use App\Services\Officer\CollegeService;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function __construct(protected CollegeService $service)
    {
    }
    public function list(Request $request)
    {
        $data['nav'] = 'college';
        $data['sub_nav'] = '';
        $data['page_title'] = 'College';
        $per_page = 10;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('officer.college.list', $data);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'college';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add College" : "Edit College";
        $data['action'] = route('officer-college-store');
        $data['row'] = College::where('id', $id)->first();
        return view('officer.college.add', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function store(StoreRequest $request)
    {   
        return $this->service->store($request->validated());
    }
}
