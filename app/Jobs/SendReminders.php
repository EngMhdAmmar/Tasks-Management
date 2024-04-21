<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use App\Traits\SendEmailTrait;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendEmailTrait;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $twoWeeksFromNow = Carbon::now()->addWeeks(2)->toDateString();
        $tasks = Task::whereDate('dead_line', '<=', $twoWeeksFromNow)->get();
        foreach($tasks as $task) {
            $leader = User::find($task->leader_id);
            $user = User::find($task->user_id);
            $this->sendReminder($leader->email, $task->id, $leader->name);
            $this->sendReminder($user->email, $task->id, $leader->name);
        }
    }
}
