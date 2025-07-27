<?php
namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function list($per_page, $page, $q, $role_id)
    {

        try {
            $query = User::where('role_id', '<>', 1);
            if ($q) {
                $query->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
            }
            if ($role_id) {
                $query->where('role_id', $role_id);
            }
            $data['users'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['users']->appends(array('q' => $q, 'role_id' => $role_id));
            if ($page != 1) {
                $data['total_data'] = $data['users']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['users']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['users']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['users']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($request)
    {
        try {
            User::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
            if ($request->val == 1) {
                $response['message'] = 'User enabled successfully';
            } else {
                $response['message'] = 'User disabled successfully';
            }
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function store($request)
    {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $user = User::findOrFail($id);
                $response['message'] = 'User updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $id = 0;
                $user = new User;
                $response['message'] = 'User created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }
            $user->role_id = $request['role_id'];
            $user->name = $request['name'];
            $user->phone = $request['phone'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $user->password_reference = $request['password'];
            $user->status = $request['status'] ?? 0;
            $user->save();
            $response['error'] = null;
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function delete($request)
    {
        try {
            $id = $request->id;
            User::where('id', $id)->delete();
            $response['message'] = 'User deleted successfully.';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
