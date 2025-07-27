<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }
    public function list(Request $request)
    {
        $data['nav'] = 'user';
        $data['sub_nav'] = '';
        $data['page_title'] = 'User';
        $per_page = 10;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['role_id'] = $request->role_id ?? '';
        $data['roles'] = Role::where('id', '<>', 1)->orderBy('name', 'asc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['role_id']);
        return view('admin.user.list', $data);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'user';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add User" : "Edit User";
        $data['action'] = route('admin-user-store');
        $data['row'] = User::where('id', $id)->first();
        $data['roles'] = Role::where('id', '<>', 1)->orderBy('name', 'asc')->get();
        return view('admin.user.add', $data);
    }

    public function status(Request $request)
    {
        return $this->service->status($request);
    }

    public function store(StoreRequest $request)
    {   
        return $this->service->store($request->validated());
    }

    public function delete(Request $request)
    {
        return $this->service->delete($request);
    }
}
