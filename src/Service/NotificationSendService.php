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

use Hyperf\Context\ApplicationContext;
use Hyperf\SocketIOServer\SocketIO;
use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfMailer\Service\EmailService;
use OnixSystemsPHP\HyperfNotifications\Constants\NotificationTransport;
use OnixSystemsPHP\HyperfNotifications\Contract\HasContactPhoneNumber;
use OnixSystemsPHP\HyperfNotifications\Mail\ReminderMail;
use OnixSystemsPHP\HyperfNotifications\Model\NotificationDelivery;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationDeliveryRepository;
use OnixSystemsPHP\HyperfNotifications\Service\Message\SendMessageService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(NotificationDelivery $delivery): void
    {
        $transport = $delivery->transport;
        $user = $delivery->notification->user;
        $notification = $delivery->notification;

        if ($transport === NotificationTransport::SOCKET) {
            $this->handleSocket($notification->text);
            return;
        }

        if ($transport === NotificationTransport::EMAIL) {
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

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function handleSocket(string $text): void
    {
        $io = ApplicationContext::getContainer()->get(SocketIO::class);
        if (! $io) {
            return;
        }
        if (empty($delivery->options) || empty($delivery->options['event'])) {
            return;
        }
        $event = $delivery->options['event'];

        if (! empty($delivery->options['local'])) {
            $io->local->emit($event, $text);
            return;
        }

        // sending to all clients in "$delivery->options['in']" room, including sender
        if (! empty($delivery->options['in'])) {
            $io->in($delivery->options['in']);
        }
        // sending to all clients in namespace "$delivery->options['of']", including sender
        if (! empty($delivery->options['of'])) {
            $io->of($delivery->options['of']);
        }
        // sending to a specific room (including sender) or individual socketid (private message)
        if (! empty($delivery->options['to'])) {
            $io->to($delivery->options['to']);
        }

        $io->emit($event, $text);
    }

    private function makeSent(NotificationDelivery $delivery): void
    {
        $delivery->sent();
        $this->rDelivery->save($delivery);
    }
}
