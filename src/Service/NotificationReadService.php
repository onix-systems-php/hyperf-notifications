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

use Carbon\Carbon;
use Hyperf\DbConnection\Annotation\Transactional;
use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfNotifications\Model\Notification;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationRepository;

#[Service]
class NotificationReadService
{
    public function __construct(private NotificationRepository $rNotification)
    {
    }

    #[Transactional(attempts: 1)]
    public function read(int $notificationId): Notification
    {
        return tap(
            $this->rNotification->getById($notificationId),
            function (Notification $notification) {
                $this->rNotification->update($notification, ['seen_at' => Carbon::now()]);
                $this->rNotification->save($notification);
            }
        );
    }
}
