<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Officer\Province\StoreRequest;
use App\Models\Province;
use App\Services\Officer\ProvinceService;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function __construct(protected ProvinceService $service)
    {
    }


    public function list(Request $request)
    {
        $data['nav'] = 'province';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Province';
        $per_page = 10;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('officer.province.list', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'province';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add Province" : "Edit Province";
        $data['action'] = route('officer-province-store');
        $data['row'] = Province::where('id', $id)->first();
        return view('officer.province.add', $data);
    }

    public function store(StoreRequest $request)
    {
        return $this->service->store($request->validated());
    }
}
