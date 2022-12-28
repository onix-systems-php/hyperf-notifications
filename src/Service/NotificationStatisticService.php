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

use Hyperf\DbConnection\Annotation\Transactional;
use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfNotifications\Model\Notification;

#[Service]
class NotificationStatisticService
{
    #[Transactional(attempts: 1)]
    public function statistic(): array
    {
        return [
            'count' => Notification::count(),
        ];
    }
}
