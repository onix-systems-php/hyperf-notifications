<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Service;

use Carbon\Carbon;
use Hyperf\DbConnection\Annotation\Transactional;
use OnixSystemsPHP\HyperfCore\Constants\ErrorCode;
use OnixSystemsPHP\HyperfCore\Exception\BusinessException;
use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfNotifications\Model\Notification;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationRepository;

use function Hyperf\Tappable\tap;
use function Hyperf\Translation\__;

#[Service]
class NotificationReadService
{
    public function __construct(private readonly NotificationRepository $rNotification) {}

    #[Transactional(attempts: 1)]
    public function read(int $notificationId): Notification
    {
        return tap(
            $this->rNotification->getById($notificationId),
            function (Notification $notification) {
                $this->rNotification->update($notification, ['seen_at' => Carbon::now()]);
                if (! $this->rNotification->save($notification)) {
                    throw new BusinessException(ErrorCode::BAD_REQUEST_ERROR, __('exceptions.php.400'));
                }
            }
        );
    }
}
