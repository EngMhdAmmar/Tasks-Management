<?php

namespace App\Jobs;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use App\Traits\SendEmailTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDeadLine implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendEmailTrait;

    protected $task_id;

    /**
     * Create a new job instance.
     */
    public function __construct($task_id)
    {
        // dd($this->task_id);
        $this->task_id = $task_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $task = Task::find($this->task_id);
        if($task->status == TaskStatus::Done) return;
        $leader = User::find($task->leader_id);
        $user = User::find($task->user_id);
        $this->sendDeadLine($leader->email, $task->id);
        $this->sendDeadLine($user->email, $task->id);
    }
}
