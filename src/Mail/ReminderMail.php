<?php

namespace OnixSystemsPHP\HyperfNotifications\Mail;

use OnixSystemsPHP\HyperfMailer\Contract\ShouldQueue;
use OnixSystemsPHP\HyperfMailer\Mailable;

class ReminderMail extends Mailable implements ShouldQueue
{
    public function __construct(string $subject, string $body)
    {
        $this->subject($subject)->textBody($body);
    }

    public function build(): void
    {
        $this
            ->with(['text' => $this->textBody])
            ->htmlView('emails.reminder.reminder');
    }
}
