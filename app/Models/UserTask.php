<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTask extends Pivot
{
    use HasUuids, SoftDeletes;

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
}
