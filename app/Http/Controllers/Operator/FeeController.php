<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\Fee\StoreRequest;
use App\Models\Fee;
use App\Models\Level;
use App\Services\Operator\FeeService;
use Illuminate\Http\Request;

class FeeController extends Controller
{

    public function __construct(protected FeeService $service)
    {
    }

    public function list(Request $request)
    {
        $data['nav'] = 'fee';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Fee';
        $per_page = 10;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('operator.fee.list', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'fee';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add Fee" : "Edit Fee";
        $data['action'] = route('operator-fee-store');
        $data['row'] = Fee::where('id', $id)->first();
        $data['levels'] = Level::all();
        return view('operator.fee.add', $data);
    }

    public function store(StoreRequest $request)
    {
        return $this->service->store($request->validated());
    }
}
