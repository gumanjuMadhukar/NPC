<?php
namespace App\Services\Site;

use App\Jobs\Site\OtpPasswordJob;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function checkLogin($request)
    {
        try {
            $check_data = array('email' => $request['email'], 'password' => $request['password']);
            $guard = User::where('email', '=', $request['email'])->first();
            if(!$guard) {
                $response['error'] = 'Email Not Matched!';
                $response['status'] = 406;
                return response()->json($response, $response['status']);
            }
            $guard_name = $guard->role->auth_name;
            if (Auth::guard($guard_name)->attempt($check_data)) {
                $response['data'] = array('redirect' => route($guard_name.'-dashboard'));
                $response['message'] = 'Login sucessfully.';
                $response['error'] = null;
                $response['status'] = 200;
                return response()->json($response, $response['status']);
            } else {
                $response['error'] = 'Email or Password Not Matched!';
                $response['status'] = 406;
                return response()->json($response, $response['status']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function otp($request)
    {
        try {
            DB::table('password_reset_tokens')->where('email', $request['email'])->delete();
            $otp = passwordResetOtp();
            DB::table('password_reset_tokens')->insert([
                'email' => $request['email'],
                'token' => $otp,
                'created_at' => Carbon::now(),
            ]);

            $user = User::where('email', $request['email'])->first();
            $email_data = [
                'otp' => $otp,
                'name' => $user->name,
                'email' => $user->email,
                'subject' => 'Reset Password',
            ];

            $jobToDispatch = (new OtpPasswordJob($email_data))->delay(Carbon::now()->addSeconds(1));
            dispatch($jobToDispatch);
            $response['message'] = 'We have mailed OTP to  reset password.';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function savePassword($request)
    {
        try {
            $updatePassword = DB::table('password_reset_tokens')
                ->where('token', $request['otp'])
                ->first();
            if ($updatePassword) {
                User::where('email', $updatePassword->email)->update([
                    'password' => Hash::make($request['new_password']),
                ]);
                DB::table('password_reset_tokens')
                    ->where('email', $updatePassword->email)
                    ->delete();
                $response['message'] = 'Passsword changed sucessfully.';
                $response['error'] = null;
                $response['status'] = 200;
                return response()->json($response, $response['status']);
            } else {
                $response['message'] = 'OTP entered is incorrect';
                $response['status'] = 422;
                $response['error'] = true;
                return response()->json($response, $response['status']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function registerSave($request)
    {
        try {
            $user = new User;
            $user->name = $request['name'];
            $user->phone = $request['phone'];
            $user->email = $request['email'];
            $user->is_foreign = $request['is_foreign'];
            $user->password = Hash::make($request['password']);
            $user->password_reference = $request['password'];
            $user->role_id = 1;
            // dd($user);
            $user->save();
            $response['data'] = $user;
            $response['message'] = 'Registered successfully';
            $response['error'] = null;
            $response['status'] = 201;;
            return response()->json($response,  $response['status']);
        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
