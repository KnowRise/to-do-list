<?php

namespace App\Http\Controllers\Backend\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $admin = $request->input('admin');
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            if ($user->role == 'admin' && !$admin) {
                auth()->logout();
                return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput();
            }

            return redirect()->route('dashboard')->with(['success' => 'Successfully Login']);
        }

        return redirect()->back()->withErrors(['login' => 'Invalid credentials'])->withInput();
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
