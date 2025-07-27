<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Auth\AuthRequest;
use App\Http\Requests\Site\Auth\OtpRequest;
use App\Http\Requests\Site\Auth\SavePasswordRequest;
use App\Http\Requests\Site\Auth\RegisterRequest;
use App\Models\District;
use App\Models\Municipality;
use App\Models\Profile;
use App\Services\Site\AuthService;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Client\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $service)
    {

    }

    public function login()
    {
        if (Auth::guard('student')->id()) {
            return redirect(route('student-dashboard'));
        }
        if (Auth::guard('operator')->id()) {
            return redirect(route('operator-dashboard'));
        }
        if (Auth::guard('admin')->id()) {
            return redirect(route('admin-dashboard'));
        }
        if (Auth::guard('registrar')->id()) {
            return redirect(route('registrar-dashboard'));
        }
        if (Auth::guard('council')->id()) {
            return redirect(route('council-dashboard'));
        }
        if (Auth::guard('subject_committee')->id()) {
            return redirect(route('subject_committee-dashboard'));
        }
        if (Auth::guard('exam_committee')->id()) {
            return redirect(route('exam_committee-dashboard'));
        }

//         $profiles = Profile::all();
//         foreach($profiles as $profile) {

//             DB::table('exam_registration')->where('profile_id', $profile->id)->update(array(
//                 'user_id'=>$profile->user_id,
// ));
//             // $district_id = District::where('name', $profile->district_id)->first();

//             // $municipality_id = Municipality::where('name', $profile->municipality_id)->first();

//             // Profile::where('id', $profile->id)->update(['municipality_id' =>  $municipality_id->id ?? null, 'district_id' => $municipality_id->district->id ?? null]);

//         }
        $data['page_title'] = 'Login';
        return view('site.auth.login', $data);
    }

    public function checkLogin(AuthRequest $request)
    {
        return $this->service->checkLogin($request->validated());
    }

    public function forgotPassword()
    {
        $data['page_title'] = 'Forgot Password';
        return view('site.auth.forgot_password', $data );
    }

    public function otp(OtpRequest $request)
    {
        return $this->service->otp($request->validated());
    }

    public function resetPassword()
    {
        $data['page_title'] = 'Reset Password';
        return view('site.auth.reset_password',  $data);
    }

    public function savePassword(SavePasswordRequest $request)
    {
        return $this->service->savePassword($request->validated());
    }

    public function register($is_foreign)
    {

        $data['is_foreign'] = $is_foreign;
        $data['page_title'] = 'Register';
        return view('site.auth.register', $data);
    }

    public function registerSave(RegisterRequest $request)
    {
        return $this->service->registerSave($request->validated());
    }

}
