<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\District\StoreRequest;
use App\Models\District;
use App\Models\Province;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function __construct(protected DistrictService $service)
    {
    }


    public function list(Request $request)
    {
        $data['nav'] = 'district';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Districts';
        $per_page = 100;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('admin.district.list', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'district';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add District" : "Edit District";
        $data['action'] = route('admin-district-store');
        $data['provinces'] = Province::where('status', 1)->get();
        $data['row'] = District::where('id', $id)->first();
        return view('admin.district.add', $data);
    }

    public function store(StoreRequest $request)
    {
        return $this->service->store($request->validated());
    }
}
