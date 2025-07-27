<?php

namespace App\Http\Controllers\SubjectCommittee;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectCommittee\Account\ProfileRequest;
use App\Http\Requests\SubjectCommittee\Account\ChangePasswordRequest;
use App\Services\SubjectCommittee\AccountService;
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
		$data['user'] = Auth::guard('subject_committee')->user();
        return view('subjectcommittee.account.index', compact('nav', 'sub_nav', 'page_title'), $data);
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
        return view('subjectcommittee.account.change_password', compact('nav', 'sub_nav', 'page_title'));
    }
    
    public function updatePassword(ChangePasswordRequest $request)
    {
        return $this->service->updatePassword($request->validated());
    }

    public function logout()
    {
        Auth::guard('subject_committee')->logout();
        return redirect(route('auth-login'));
    }


}
