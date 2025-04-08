<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function detail(Request $request, $id)
    {
        $user = $request->user();
        $job = Job::find($id);

        if ($user->role == 'worker') {
            $tasks = Task::where('job_id', $id)
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();
            $tasks = $tasks->map(function ($task) use ($user) {
                return [
                    'task' => $task,
                    'user_task' => $task->user($user->id),
                ];
            });
        } else {
            $tasks = Task::where('job_id', $id)->get();
        }

        $isJob = true;
        $isTask = false;
        return view('pages.jobs.detail', compact('job', 'tasks', 'isJob', 'isTask'));
    }
}
