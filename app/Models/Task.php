<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'job_id',
    ];

    protected $with = [
        'job',
    ];

    protected $casts = [
        'id' => 'string',
        'job_id' => 'string',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function userTaskFor($id)
    {
        return $this->userTasks()->where('user_id', $id)->first();
    }

    public function userTasks()
    {
        return $this->hasMany(UserTask::class, 'task_id');
    }
}
