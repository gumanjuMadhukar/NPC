<?php
namespace App\Services\Council;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    public function store($request)
    {
        try {
            $id = Auth::guard('council')->id();
            $user = User::findOrFail($id);
            $user->name = $request['name'];
            $user->phone = $request['phone'];
            $user->save();
            $response['data'] = $user;
            $response['message'] = 'Profile updated successfully';
            $response['error'] = null;
            $response['status'] = 200;;
            return response()->json($response,  $response['status']);
        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updatePassword($request)
    {
        try {
            if (Hash::check($request['old_password'], Auth::guard('council')->user()->password)) {
                User::whereId(Auth::guard('council')->id())->update([
                    'password' => Hash::make($request['new_password']),
                    'password_reference' => $request['new_password'],
                ]);
                $response['message'] = 'Changed password successfully';
                $response['error'] = null;
                $response['status'] = 200;
                return response()->json($response,  $response['status']);
            } else {
                $response['message'] = null;
                $response['error'] = 'Old password does not match.';
                $response['status'] = 422;
                return response()->json($response,  $response['status']);
            }
        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
