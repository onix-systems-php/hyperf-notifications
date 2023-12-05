<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Service;

use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfMailer\Service\EmailService;
use OnixSystemsPHP\HyperfNotifications\Contract\HasContactPhoneNumber;
use OnixSystemsPHP\HyperfNotifications\Mail\ReminderMail;
use OnixSystemsPHP\HyperfNotifications\Model\NotificationDelivery;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationDeliveryRepository;
use OnixSystemsPHP\HyperfNotifications\Service\Message\SendMessageService;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\SmsMessage;

use function Hyperf\Config\config;

#[Service]
class NotificationSendService
{
    public function __construct(
        private readonly SendMessageService $sendMessageService,
        private readonly EmailService $emailService,
        private readonly NotificationDeliveryRepository $rDelivery,
    ) {}

    public function run(NotificationDelivery $delivery): void
    {
        $transport = $delivery->transport;
        $user = $delivery->notification->user;
        $notification = $delivery->notification;

        if ($transport === 'socket') {
            return;
        }

        if ($transport === 'email') {
            $this->emailService->run($user, new ReminderMail($notification));
            $this->makeSent($delivery);
            return;
        }

        if (in_array($transport, config('notifier.texter'), true)) {
            if (! $user instanceof HasContactPhoneNumber) {
                return;
            }

            $sms = new SmsMessage($user->getContactPhoneNumber(), $notification->title);
            $sms->transport($transport);
            $this->sendMessageService->send($sms);
            $this->makeSent($delivery);
            return;
        }

        if (in_array($transport, config('notifier.chatter'), true)) {
            $chat = new ChatMessage($notification->title);
            $chat->transport($transport);

            $this->sendMessageService->send($chat);
            $this->makeSent($delivery);
        }
    }

    private function makeSent(NotificationDelivery $delivery): void
    {
        $delivery->sent();
        $this->rDelivery->save($delivery);
    }
}
