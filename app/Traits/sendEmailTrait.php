<?php

namespace App\Traits;

use App\Mail\AssignmentEmail;
use App\Mail\DeadLineMail;
use App\Mail\ReminderMail;
use App\Mail\VerificationCodeEmail;
use Exception;
use Illuminate\Support\Facades\Mail;

trait SendEmailTrait
{
    private function sendVerifyEmail($email, $user, $verificationCode)
    {
        try {
            Mail::to($email)->send(new VerificationCodeEmail($user, $verificationCode));
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }

    private function sendReminder($email, $task_id, $name) {
        try {
            Mail::to($email)->send(new ReminderMail($task_id, $name));
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }

    private function sendDeadLine($email, $task_id) {
        try {
            Mail::to($email)->send(new DeadLineMail($task_id));
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }

    private function sendAssignment($email, $task_id) {
        try {
            Mail::to($email)->send(new AssignmentEmail($task_id));
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }
}
