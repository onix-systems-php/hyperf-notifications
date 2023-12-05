<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Mail;

use OnixSystemsPHP\HyperfMailer\Contract\ShouldQueue;
use OnixSystemsPHP\HyperfMailer\Mailable;
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
