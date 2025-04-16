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
            'image_null' => ['nullable', 'in:true'],
            'video_null' => ['nullable', 'in:true'],
            'image' => ['nullable', 'mimes:jpeg,png,jpg,svg'],
            'video' => ['nullable', 'mimes:mp4'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = $request->user();
        $imageNull = $request->image_null == 'true';
        $videoNull = $request->video_null == 'true';

        if (($imageNull && $request->hasFile('image')) || ($videoNull && $request->hasFile('video'))) {
            return redirect()->back()->withErrors(['error' => 'You cannot upload a file and set it to null at the same time.'])->withInput();
        }

        $job = Job::find($id) ?? new Job();

        $job->title = $request->title;
        $job->description = $request->description;

        // ==== IMAGE ====
        if ($imageNull) {
            $job->image = null;
        } elseif ($request->hasFile('image')) {
            $job->image = $request->file('image')->store('jobs/' . ($job->id ?? 'temp') . '/images', 'public');
        }
        // Kalau gak null dan gak upload → do nothing, biarin image lama.

        // ==== VIDEO ====
        if ($videoNull) {
            $job->video = null;
        } elseif ($request->hasFile('video')) {
            $job->video = $request->file('video')->store('jobs/' . ($job->id ?? 'temp') . '/videos', 'public');
        }

        $job->user_id = $user->id;
        $job->save();

        $message = $id ? 'Job updated successfully.' : 'Job created successfully.';
        return redirect()->back()->with(['message' => $message]);
    }

    public function deleteJob(Request $request, $id)
    {
        $user = $request->user();
        $job = Job::find($id);

        if ($job->user_id != $user->id) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to delete this job.']);
        }

        $job->delete();

        return redirect()->route('dashboard')->with(['message' => 'Job deleted successfully.']);
    }
}
