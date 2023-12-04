<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use OnixSystemsPHP\HyperfCore\Model\Builder;
use OnixSystemsPHP\HyperfMailer\Service\EmailService;
use OnixSystemsPHP\HyperfNotifications\Constants\NotificationType;
use OnixSystemsPHP\HyperfNotifications\Mail\ReminderMail;
use OnixSystemsPHP\HyperfNotifications\Model\NotificationDelivery;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationDeliveryRepository;
use OnixSystemsPHP\HyperfNotifications\Service\Message\SendMessageService;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\SmsMessage;

use function Hyperf\Config\config;

#[Command]
class SendScheduledNotifications extends HyperfCommand
{
    private const CHUNK_COUNT = 1000;

    public function __construct(
        private readonly SendMessageService $sendMessageService,
        private readonly EmailService $emailService,
        private readonly NotificationDeliveryRepository $rDelivery,
    ) {
        parent::__construct('reminders:send');
    }

    public function configure(): void
    {
        parent::configure();
        $this->setDescription('Send scheduled notifications that are ready to be sent');
    }

    public function handle(): void
    {
        $reminderTime = config('reminder.time');

        NotificationDelivery::query()
            ->whereHas(
                'notification',
                fn (Builder $query) => $query
                    ->whereNull('seen_at')
                    ->whereRaw("DATE(created_at + interval '" . $reminderTime . " seconds') >= now()")
            )
            ->whereType(NotificationType::REMINDER)
            ->whereNull('sent_at')
            ->groupBy(['id', 'notification_id'])
            ->chunkById(self::CHUNK_COUNT, function (iterable $deliveries) {
                /** @var NotificationDelivery $delivery */
                foreach ($deliveries as $delivery) {
                    $transport = $delivery->transport;
                    $user = $delivery->notification->user;
                    $notification = $delivery->notification;

                    if ($transport === 'email') {
                        $this->emailService->run($user, new ReminderMail($notification));
                        $this->makeSent($delivery);
                        continue;
                    }
                    if (in_array($transport, config('notifier.texter'), true)) {
                        if (! $phone = $this->getUserPhoneNumber($user)) {
                            continue;
                        }
                        $sms = new SmsMessage($phone, $notification->title);
                        $sms->transport($transport);
                        $this->sendMessageService->send($sms);
                        $this->makeSent($delivery);
                        continue;
                    }
                    if (in_array($transport, config('notifier.chatter'), true)) {
                        $chat = new ChatMessage($notification->title);
                        $chat->transport($transport);

                        $this->sendMessageService->send($chat);
                        $this->makeSent($delivery);
                    }
                }
            });
    }

    private function getUserPhoneNumber(object $user): ?string
    {
        $phone = null;
        if (property_exists($user, 'phone')) {
            $phone = $user->phone;
        }
        if (property_exists($user, 'phoneNumber')) {
            $phone = $user->phoneNumber;
        }
        if (property_exists($user, 'phone_number')) {
            $phone = $user->phone_number;
        }

        return $phone;
    }

    private function makeSent(NotificationDelivery $delivery): void
    {
        $delivery->sent();
        $this->rDelivery->save($delivery);
    }
}
