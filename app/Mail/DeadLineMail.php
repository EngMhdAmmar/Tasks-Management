<?php

namespace App\Mail;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon as SupportCarbon;

class DeadLineMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $task_id;
    /**
     * Create a new message instance.
     */
    public function __construct($task_id)
    {
        $this->task_id = $task_id;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dead Line Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $task = Task::find($this->task_id);
        $user = $task->user->name;
        return new Content(
            view: 'mail.assignment',
            with: [
                'name' => $user,
                'task' => $task->title,
                'days' => SupportCarbon::parse($task->dead_line)->diffInDays(Carbon::now()),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
