<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'tasker_id',
    ];

    protected $casts = [
        'id' => 'string',
        'tasker_id' => 'string',
    ];

    public function tasker()
    {
        return $this->belongsTo(User::class, 'tasker_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
