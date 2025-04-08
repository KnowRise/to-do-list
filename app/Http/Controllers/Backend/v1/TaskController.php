<?php

namespace App\Http\Controllers\Backend\v1;

use App\Http\Controllers\Controller;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
}
