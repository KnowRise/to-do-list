<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        if ($user->role == 'admin') {
            $users = User::where('id', '!=', $user->id)->get();
            return view('pages.dashboard', compact('users'));
        } else if ($user->role == 'worker') {
            $jobs = Job::whereHas('tasks.userTasks', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orWhere('user_id', $user->id)->get();
        } else if ($user->role == 'tasker') {
            $jobs = Job::where('user_id', $user->id)->get();
        }
        return view('pages.dashboard', compact('jobs'));
    }
}
