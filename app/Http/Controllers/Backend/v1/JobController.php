<?php

namespace App\Http\Controllers\Backend\v1;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function storeJob(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = $request->user();
        $data = $request->only(['title', 'description']);
        $data['user_id'] = $user->id;

        Job::updateOrCreate(
            ['id' => $id],
            $data
        );

        $message = $id ? 'Job updated successfully.' : 'Job created successfully.';
        return redirect()->back()->with(['message' => $message]);
    }
}
