<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\University\StoreRequest;
use App\Models\University;
use App\Services\Operator\UniversityService;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function __construct(protected UniversityService $service)
    {
    }
    public function list(Request $request)
    {
        $data['nav'] = 'university';
        $data['sub_nav'] = '';
        $data['page_title'] = 'University';
        $per_page = 10;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('operator.university.list', $data);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'university';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add University" : "Edit University";
        $data['action'] = route('operator-university-store');
        $data['row'] = University::where('id', $id)->first();
        return view('operator.university.add', $data);
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
