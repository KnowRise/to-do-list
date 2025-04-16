<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function detail(Request $request, $id)
    {
        $user = $request->user();
        $job = Job::find($id);
        $job->image = $job->image != null ? asset(Storage::url($job->image)) : null;
        $job->video = $job->video != null ? asset(Storage::url($job->video)) : null;

        if ($user->role == 'worker') {
            $tasks = Task::where('job_id', $id)
                ->whereHas('userTasks', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->get();
        } else {
            $tasks = Task::where('job_id', $id)->get();
            // dd($tasks);
        }

        $type = 'job';
        return view('pages.detail.jobs.main', compact('job', 'tasks', 'type'));
    }

    public function search() {
        //
    }
}
