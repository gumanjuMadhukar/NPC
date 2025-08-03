<?php

namespace App\Http\Controllers\AdmitCardReader;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmitCardReader\Account\ProfileRequest;
use App\Http\Requests\AdmitCardReader\Account\ChangePasswordRequest;
use App\Services\AdmitCardReader\AccountService;
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
		$data['user'] = Auth::guard('admit_card_reader')->user();
        return view('admitcardreader.account.index', compact('nav', 'sub_nav', 'page_title'), $data);
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
        return view('admitcardreader.account.change_password', compact('nav', 'sub_nav', 'page_title'));
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        return $this->service->updatePassword($request->validated());
    }

    public function logout()
    {
        Auth::guard('admit_card_reader')->logout();
        return redirect(route('auth-login'));
    }


}
