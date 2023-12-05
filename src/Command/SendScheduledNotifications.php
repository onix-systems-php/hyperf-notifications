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
use OnixSystemsPHP\HyperfNotifications\Constants\NotificationType;
use OnixSystemsPHP\HyperfNotifications\Model\NotificationDelivery;
use OnixSystemsPHP\HyperfNotifications\Service\NotificationSendService;

use function Hyperf\Config\config;

#[Command]
class SendScheduledNotifications extends HyperfCommand
{
    private const CHUNK_COUNT = 1000;

    public function __construct(
        private readonly NotificationSendService $notificationSendService,
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
            ->chunkById(self::CHUNK_COUNT, static fn (iterable $deliveries) => $this->handleIterable($deliveries));
    }

    private function handleIterable(iterable $deliveries): void
    {
        foreach ($deliveries as $delivery) {
            $this->notificationSendService->run($delivery);
        }
    }
}
