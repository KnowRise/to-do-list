<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class UserTask extends Model
{
    use HasUuids;

    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'task_id',
        'status',
        'file_path',
        'completed_at',
    ];

    protected $table = 'user_tasks';

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'task_id' => 'string',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }
}
