<?php

namespace App\Http\Controllers\Backend\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function storeUser(Request $request, $id = null)
    {
        $requirements = [
            'name' => ['required']
        ];

        if ($id) {
            $user = User::find($id);
            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'Cannot found User']);
            }
        }

        if ($id) {
            $requirements['username'] = ['required', 'unique:users,username,' . $user->id];
            $requirements['email'] = ['required', 'unique:users,email,' . $user->id];
            $requirements['phone_number'] = ['required', 'unique:users,phone_number,' . $user->id];
        } else {
            $requirements['username'] = ['required', 'unique:users,username'];
            $requirements['phone_number'] = ['required', 'unique:users,phone_number'];
            $requirements['email'] = ['required', 'unique:users,email'];
            $requirements['role'] = ['required', 'in:worker,tasker,admin'];
            $requirements['password'] = ['required'];
        }

        $validator = Validator::make($request->all(), $requirements);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'username', 'email', 'phone_number']);
        if (!$id) {
            $data['role'] = $request->role;
            $data['password'] = bcrypt($request->password);
        }

        $user = User::updateOrCreate(
            ['id' => $id],
            $data
        );

        $message = $id == null ? 'User created Successfully' : 'User updated Successfully';
        return redirect()->back()->with(['message' => $message]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with(['message' => 'User deleted Successfully']);
    }

    public function users(Request $request, $id = null)
    {
        $search = $request->input('search');
        if ($id) {
            $user = User::select('id', 'username')->where('id', $id)->first();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return $user;
        }
        $users = User::where('role', 'worker')->select('id', 'username')->when(
            $search,
            function ($query, $search) {
                return $query->where('username', 'like', "%{$search}%");
            },
            function ($query) {
                return $query->latest()->take(4);
            }
        )->get();

        return $users;
    }
}
