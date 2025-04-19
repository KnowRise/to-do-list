<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        $admin = request()->has('admin');
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('pages.auth.login', compact('admin'));
    }
}
