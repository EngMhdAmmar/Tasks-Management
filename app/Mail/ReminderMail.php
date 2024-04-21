<?php

namespace App\Mail;

use App\Models\Task;
use App\Traits\SendEmailTrait;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $task_id;
    protected $name;

    /**
     * Create a new message instance.
     */
    public function __construct($task_id, $name)
    {
        $this->task_id = $task_id;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Remainder Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $task = Task::find($this->task_id);
        return new Content(
            view: 'mail.assignment',
            with: [
                'name' => $this->name,
                'task' => $task->title,
                'days' => $task->dead_line->diffInDays(Carbon::now()),
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
