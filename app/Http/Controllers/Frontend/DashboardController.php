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
            $query = User::query();
            $query->whereNot('id', $user->id);

            // Search
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            }

            $users = $query->paginate(10);

            return view('pages.dashboard.main', compact('users'));
        } else if ($user->role == 'worker') {
            $jobs = Job::whereHas('tasks.userTasks', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orWhere('user_id', $user->id)->get();
        } else if ($user->role == 'tasker') {
            $jobs = Job::where('user_id', $user->id)->get();
        }
        return view('pages.dashboard.main', compact('jobs'));
    }
}
