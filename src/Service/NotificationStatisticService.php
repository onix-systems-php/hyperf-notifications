<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Service;

use Hyperf\DbConnection\Annotation\Transactional;
use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfNotifications\DTO\NotificationStatisticResultDTO;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationRepository;

#[Service]
class NotificationStatisticService
{
    public function __construct(private NotificationRepository $rNotification) {}

    #[Transactional(attempts: 1)]
    public function statistic(): NotificationStatisticResultDTO
    {
        return NotificationStatisticResultDTO::make([
            'count' => $this->rNotification->query()->count(),
        ]);
    }
}
