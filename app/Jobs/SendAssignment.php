<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use App\Traits\SendEmailTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAssignment implements ShouldQueue
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
        $user = User::find($task->user_id);
        $this->sendAssignment($user->email, $task->id);
    }
}
