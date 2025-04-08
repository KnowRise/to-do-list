<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'repeat_type',
        'repeat_interval',
        'repeat_count',
        'repeat_gap',
        'deadline',
        'job_id',
    ];

    protected $with = [
        'job',
        'users',
    ];

    protected $casts = [
        'id' => 'string',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'job_id' => 'string',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user($id)
    {
        return $this->users->where('id', $id)->first();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks')
            ->using(UserTask::class)
            ->withPivot('status', 'file_path', 'completed_at');
    }
}
