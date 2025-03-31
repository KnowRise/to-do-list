<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTask extends Model
{
    use HasUuids, SoftDeletes;

    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'task_id',
        'status',
        'file_path',
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'task_id' => 'string',
    ];
}
