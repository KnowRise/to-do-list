<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function detail(Request $request, $id)
    {
        $user = $request->user();
        $tasks = Task::with(['job', 'users'])->find($id);

        $isJob = true;
        $isTask = false;
        return view('pages.jobs.detail', compact('tasks', 'isJob', 'isTask'));
    }
}
