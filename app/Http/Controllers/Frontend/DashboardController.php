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
            //
        } else if ($user->role == 'worker') {
            $jobs = Job::whereHas('tasks.users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('status', 'open')->get();
            return view('pages.workers.dashboard', compact('user', 'jobs'));
        } else if ($user->role == 'tasker')
        {
            //
        }
    }
}
