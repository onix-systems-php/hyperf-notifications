<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Service;

use Hyperf\DbConnection\Annotation\Transactional;
use OnixSystemsPHP\HyperfCore\Contract\CoreAuthenticatableProvider;
use OnixSystemsPHP\HyperfCore\Model\Builder;
use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfNotifications\Constants\NotificationType;
use OnixSystemsPHP\HyperfNotifications\DTO\NotificationStatisticResultDTO;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationRepository;

#[Service]
class NotificationStatisticService
{
    public function __construct(
        private readonly NotificationRepository $rNotification,
        private readonly CoreAuthenticatableProvider $coreAuthenticatableProvider,
    ) {}

    #[Transactional(attempts: 1)]
    public function run(): NotificationStatisticResultDTO
    {
        $user = $this->coreAuthenticatableProvider->user();

        return NotificationStatisticResultDTO::make([
            'count' => empty($user) ? 0 : $this->getNotificationQuantityByUserId($user->getId()),
        ]);
    }

    private function getNotificationQuantityByUserId(int $userId): int
    {
        return $this->rNotification->query()
            ->whereHas(
                'deliveries',
                fn (Builder $builder) => $builder->where('type', '=', NotificationType::PRIMARY)
            )
            ->finder('userId', $userId)
            ->finder('seen')
            ->count();
    }
}
