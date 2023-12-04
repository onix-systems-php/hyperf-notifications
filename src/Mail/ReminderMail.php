<?php

namespace OnixSystemsPHP\HyperfNotifications\Mail;

use OnixSystemsPHP\HyperfMailer\Contract\ShouldQueue;
use OnixSystemsPHP\HyperfMailer\Mailable;
use OnixSystemsPHP\HyperfMailer\Message;
use OnixSystemsPHP\HyperfNotifications\Model\Notification;

class ReminderMail extends Mailable implements ShouldQueue
{
    public function __construct(private readonly Notification $notification)
    {
        if ($notification->image) {
            $this->attach($notification->image->full_path);
        }
    }

    public function build(): void
    {
        $this
            ->subject($this->notification->title)
            ->with(['text' => $this->textBody])
            ->htmlView('emails.reminder.reminder');
    }
}
