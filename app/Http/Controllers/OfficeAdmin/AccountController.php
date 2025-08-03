<?php

namespace App\Http\Controllers\OfficeAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeAdmin\Account\ProfileRequest;
use App\Http\Requests\OfficeAdmin\Account\ChangePasswordRequest;
use App\Services\OfficeAdmin\AccountService;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function __construct(protected AccountService $service)
    {
    }
    public function index()
    {
        $nav = 'account';
        $sub_nav = '';
        $page_title = 'My Account';
		$data['user'] = Auth::guard('office_admin')->user();
        return view('officeadmin.account.index', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function store(ProfileRequest $request)
    {
        return $this->service->store($request->validated());
    }

    public function changePassword()
    {
        $nav = 'account';
        $sub_nav = '';
        $page_title = "Change Password";
        return view('officeadmin.account.change_password', compact('nav', 'sub_nav', 'page_title'));
    }
    
    public function updatePassword(ChangePasswordRequest $request)
    {
        return $this->service->updatePassword($request->validated());
    }

    public function logout()
    {
        Auth::guard('office_admin')->logout();
        return redirect(route('auth-login'));
    }


}
