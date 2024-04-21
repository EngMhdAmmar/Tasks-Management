<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    // no need when name follows the convention
    protected $table = 'comments';

    protected $fillable = [
        'task_id',
        'user_id',
        'attachment',
        'comment',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
