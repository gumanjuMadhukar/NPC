<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Officer\Level\StoreRequest;
use App\Models\Level;
use App\Services\Officer\LevelService;
use Illuminate\Http\Request;

class LevelController extends Controller
{

    public function __construct(protected LevelService $service)
    {
    }

    public function list(Request $request)
    {
        $data['nav'] = 'level';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Level';
        $per_page = 10;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('officer.level.list', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'level';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add Level" : "Edit Level";
        $data['action'] = route('officer-level-store');
        $data['order'] = getMax('levels', 'order');
        $data['row'] = Level::where('id', $id)->first();
        return view('officer.level.add', $data);
    }

    public function store(StoreRequest $request)
    {
        return $this->service->store($request->validated());
    }
}
