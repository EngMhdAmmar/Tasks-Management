<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\ScheduleType;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'leader_id',
        'user_id',
        'title',
        'description',
        'dead_line',
        'priority',
        'schedule',
        'completed_at',
    ];

    protected $casts = [
        'priority' => Priority::class,
        'schedule' => ScheduleType::class,
        'status' => TaskStatus::class,
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id', 'id');
    }
}
