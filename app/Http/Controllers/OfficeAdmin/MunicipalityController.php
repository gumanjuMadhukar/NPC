<?php

namespace App\Http\Controllers\OfficeAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeAdmin\Municipality\StoreRequest;
use App\Models\Municipality;
use App\Models\District;
use App\Services\OfficeAdmin\MunicipalityService;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function __construct(protected MunicipalityService $service)
    {
    }


    public function list(Request $request)
    {
        $data['nav'] = 'municipality';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Municipality';
        $per_page = 100;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('officeadmin.municipality.list', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'municipality';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add Municipality" : "Edit Municipality";
        $data['action'] = route('office_admin-municipality-store');
        $data['districts'] = District::where('status', 1)->get();
        $data['row'] = Municipality::where('id', $id)->first();
        return view('officeadmin.municipality.add', $data);
    }

    public function store(StoreRequest $request)
    {
        return $this->service->store($request->validated());
    }
}
