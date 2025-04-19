<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserTask;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $defaultProfile = 'profiles/default.png';
        User::create([
            'name' => env('ADMIN_NAME'),
            'username' => env('ADMIN_USERNAME'),
            'role' => env('ADMIN_ROLE'),
            'phone_number' => env('ADMIN_PHONE_NUMBER'),
            'phone_verified_at' => now(),
            'profile' => $defaultProfile,
            'password' => bcrypt(env('ADMIN_PASSWORD'))
        ]);

        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => 'Worker' . $i,
                'username' => 'worker' . $i,
                'role' => 'worker',
                'phone_number' => '12345678901' . $i,
                'phone_verified_at' => now(),
                'profile' => $defaultProfile,
                'password' => bcrypt('password123')
            ]);
        }

        User::create([
            'name' => 'Tasker',
            'username' => 'tasker',
            'role' => 'tasker',
            'phone_number' => '45678743456789',
            'phone_verified_at' => now(),
            'profile' => $defaultProfile,
            'password' => bcrypt('password123')
        ]);

        $tasker = User::where('role', 'tasker')->first();
        Job::create([
            'title' => 'Sample Job',
            'description' => 'This is a sample job description.',
            'user_id' => $tasker->id,
            'image' => 'image.png',
            'video' => 'video.mp4',
        ]);

        $job = Job::first();
        for ($i = 1; $i <= 20; $i++) {
            Task::create([
                'title' => 'Sample Task ' . $i,
                'description' => 'This is a sample task description ' . $i,
                'job_id' => $job->id,
            ]);
        }

        $tasks = Task::all();
        $workers = User::where('role', 'worker')->limit(3)->get();
        // foreach ($workers as $worker) {
        // }
        // foreach ($tasks as $task) {
        //     UserTask::create([
        //         'user_id' => $worker->id,
        //         'task_id' => $task->id,
        //         'status' => 'pending',
        //         'file_path' => null,
        //     ]);
        // }

        for ($i = 1; $i <= 20; $i++) {
            UserTask::create([
                'user_id' => $workers[rand(0,2)]->id,
                'task_id' => $tasks[rand(0,19)]->id,
                'status' => 'pending',
            ]);
        }

        // worker id = 1
        // worker id = 1
        // task id = 1

        // worker id = 1
        // task id = 2

        // worker id = 1
        // task id = 20

        // worker id = 2
        // worker id = 2
        // task id = 1

        // worker id = 2
        // task id = 2

        // worker id = 2
        // task id = 20

        // worker id = 3
        // worker id = 3
        // task id = 1

        // worker id = 3
        // task id = 2

        // worker id = 3
        // task id = 20

        // DONW!!!
    }
}
