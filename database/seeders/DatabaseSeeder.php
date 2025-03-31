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

        // Schema::create('users', function (Blueprint $table) {
        // $table->uuid('id')->primary();
        // $table->string('name');
        // $table->string('email')->unique();
        // $table->string('username')->unique();
        // $table->enum('role', ['worker', 'tasker', 'admin'])->default('worker');
        // $table->string('phone_number')->unique();
        // $table->timestamp('email_verified_at')->nullable();
        // $table->timestamp('phone_verified_at')->nullable();
        // $table->string('email_verification_code')->nullable();
        // $table->string('phone_verification_code')->nullable();
        // $table->timestamp('email_verification_code_expiry')->nullable();
        // $table->timestamp('phone_verification_code_expiry')->nullable();
        // $table->string('profile')->nullable();
        // $table->string('password');
        // $table->softDeletes();
        // $table->rememberToken();
        // $table->timestamps();
        // });
        $defaultProfile = 'profiles/default.png';
        User::create([
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'username' => env('ADMIN_USERNAME'),
            'role' => env('ADMIN_ROLE'),
            'phone_number' => env('ADMIN_PHONE_NUMBER'),
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'profile' => $defaultProfile,
            'password' => bcrypt(env('ADMIN_PASSWORD'))
        ]);

        User::create([
            'name' => 'Worker',
            'email' => 'worker@example.com',
            'username' => 'worker',
            'role' => 'worker',
            'phone_number' => '12345678901',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'profile' => $defaultProfile,
            'password' => bcrypt('password123')
        ]);

        User::create([
            'name' => 'Tasker',
            'email' => 'tasker@example.com',
            'username' => 'tasker',
            'role' => 'tasker',
            'phone_number' => '12345678902',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'profile' => $defaultProfile,
            'password' => bcrypt('password123')
        ]);

        // Schema::create('jobs', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->string('title');
        //     $table->text('description')->nullable();
        //     $table->enum('status', ['open', 'closed'])->default('open');
        //     $table->foreignUuid('tasker_id')->constrained('users')->cascadeOnDelete();
        //     $table->softDeletes();
        //     $table->timestamps();
        // });
        $tasker = User::where('role', 'tasker')->first();
        Job::create([
            'title' => 'Sample Job',
            'description' => 'This is a sample job description.',
            'status' => 'open',
            'tasker_id' => $tasker->id,
        ]);

        // Schema::create('tasks', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->string('title');
        //     $table->text('description')->nullable();
        //     $table->timestamp('start_date');
        //     $table->timestamp('end_date')->nullable();
        //     $table->enum('repeat_type', ['none', 'daily', 'weekly', 'monthly'])->default('none');
        //     $table->unsignedInteger('repeat_interval')->default(1);
        //     $table->unsignedInteger('repeat_count')->default(0);
        //     $table->unsignedInteger('repeat_gap')->default(1);
        //     $table->foreignUuid('job_id')->constrained('jobs')->cascadeOnDelete();
        //     $table->softDeletes();
        //     $table->timestamps();
        //     $table->index(['start_date', 'end_date', 'repeat_type']);
        // });
        $job = Job::first();
        Task::create([
            'title' => 'Sample Task',
            'description' => 'This is a sample task description.',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'repeat_type' => 'none',
            'repeat_interval' => 0,
            'repeat_count' => 0,
            'repeat_gap' => 0,
            'job_id' => $job->id,
        ]);

        // Schema::create('user_tasks', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
        //     $table->foreignUuid('task_id')->constrained()->cascadeOnDelete();
        //     $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
        //     $table->string('file_path')->nullable();
        //     $table->softDeletes();
        //     $table->timestamps();
        // });
        $task = Task::first();
        $worker = User::where('role', 'worker')->first();
        UserTask::create([
            'user_id' => $worker->id,
            'task_id' => $task->id,
            'status' => 'pending',
            'file_path' => null,
        ]);
    }
}
