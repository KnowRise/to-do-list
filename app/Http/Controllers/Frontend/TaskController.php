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
        $task = Task::with(['job', 'userTasks'])->find($id);

        return view('pages.detail.tasks.main', compact('task'));
    }
}
