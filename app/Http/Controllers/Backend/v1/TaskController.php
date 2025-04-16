<?php

namespace App\Http\Controllers\Backend\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Node\FunctionNode;

class TaskController extends Controller
{
    public function submitTasks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => ['required', 'array'],
            'files.*' => ['file', 'mimes:txt,pdf,docx,zip,jpg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $request->user();
        $files = $request->file('files');
        $userTasks = UserTask::whereIn('task_id', array_keys($files))
            ->where('user_id', $user->id)
            ->get();
        foreach ($userTasks as $userTask) {
            $file = $files[$userTask->task_id];
            $filePath = '/tasks/' . $userTask->task_id . '/users/' . $user->id;
            $fileName = $file->hashName() . '.' . $file->getClientOriginalName();
            $file->storeAs($filePath, $fileName);
            $userTask->file_path = $filePath;
            $userTask->status = 'completed';
            $userTask->completed_at = now();
            $userTask->save();
        }

        return redirect()->back()->with(['message' => 'Tasks submitted successfully.']);
    }

    // Tasker
    public function storeTask(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'job_id' => ['required', 'exists:jobs,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only('title', 'description');
        if ($id) {
            $task = Task::find($id);
            if (!$task) {
                return redirect()->back()->withErrors(['error' => 'Task not found.']);
            }
            if ($task->job->user_id != $request->user()->id) {
                return redirect()->back()->withErrors(['error' => 'You are not authorized to update this task.']);
            }
            if ($task->job_id != $request->input('job_id')) {
                return redirect()->back()->withErrors(['error' => 'You cannot change the job of this task.']);
            }
        }

        $data['job_id'] = $request->input('job_id');
        $task = Task::updateOrCreate(
            ['id' => $id],
            $data
        );


        if ($id) {
            $message = 'Task Updated Successfully';
        } else {
            $message = 'Task Created Successfully';
        }

        return redirect()->back()->with(['message' => $message]);
    }

    public function deleteTask(Request $request, $id)
    {
        $user = $request->user();
        $task = Task::find($id);
        $jobId = $task->job_id;

        if ($task->job->user_id != $user->id) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to delete this task.']);
        }

        $task->delete();

        return redirect()->route('jobs.detail', ['id' => $jobId])->with(['message' => 'Task deleted successfully.']);
    }

    public function deleteUserTask($id)
    {
        $userTask = UserTask::find($id);
        $userTask->Delete();

        return redirect()->back()->with(['message' => 'Task deleted successfully.']);
    }

    public function storeUserTask(Request $request, $id)
    {
        $taskId = $request->input('task_id');
        if ($taskId) {
            if ($taskId == $id) {
                return redirect()->back()->withErrors(['error' => 'You cannot copy the task to itself.']);
            }

            $task = Task::find($id);
            $copyTask = Task::find($taskId);

            if (!$copyTask || !$task) {
                return redirect()->back()->withErrors(['error' => 'Task not found.']);
            }

            if ($task->job->user_id != $request->user()->id) {
                return redirect()->back()->withErrors(['error' => 'You are not authorized to update this task.']);
            }

            $userIds = $task->userTasks()->pluck('user_id')->toArray();
            $userCopyIds = $copyTask->userTasks()->pluck('user_id')->toArray();

            $toAdd = array_diff($userCopyIds, $userIds);
            $toDelete = array_diff($userIds, $userCopyIds);
            // dd([
            //     'userIds' => $userIds,
            //     'userCopyIds' => $userCopyIds,
            //     'toAdd' => $toAdd,
            //     'toDelete' => $toDelete,
            // ]);

            UserTask::where('task_id', $task->id)->whereIn('user_id', $toDelete)->delete();

            foreach ($toAdd as $userId) {
                UserTask::create([
                    'task_id' => $task->id,
                    'user_id' => $userId,
                ]);
            }

            // $toAdd = array_diff($userCopyIds, $userIds);

            // foreach ($toAdd as $userId) {
            //     UserTask::create([
            //         'task_id' => $id,
            //         'user_id' => $userId,
            //     ]);
            // }

            return redirect()->back()->with(['message' => 'User Task Assigned Successfully']);
        }

        $validator = Validator::make($request->all(), [
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $task = Task::find($id);
        if (!$task) {
            return redirect()->back()->withErrors(['error' => 'Task not found.']);
        }
        if ($task->job->user_id != $request->user()->id) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to update this task.']);
        }

        $userIds = $request->input('user_ids');
        $exitingUserTasks = UserTask::where('task_id', $id)->pluck('user_id')->toArray();
        $newUserIds = array_diff($userIds, $exitingUserTasks);

        foreach ($newUserIds as $userId) {
            UserTask::create([
                'task_id' => $id,
                'user_id' => $userId,
            ]);
        }

        return redirect()->back()->with(['message' => 'User Task Created Successfully']);
    }

    // DATA
    public function tasks(Request $request)
    {
        $search = $request->input('search');
        $tasks = Task::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        }, function ($query) {
            return $query->limit(10); // Ambil 10 pertama kalau ga ada pencarian
        })->get();

        return $tasks;
    }
}
