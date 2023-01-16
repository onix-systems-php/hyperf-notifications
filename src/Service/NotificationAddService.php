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
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Rule;
use OnixSystemsPHP\HyperfCore\Constants\ErrorCode;
use OnixSystemsPHP\HyperfCore\Exception\BusinessException;
use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfNotifications\DTO\AddNotificationDTO;
use OnixSystemsPHP\HyperfNotifications\Model\Notification;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationRepository;

#[Service]
class NotificationAddService
{
    public function __construct(
        private NotificationRepository $rNotification,
        private ValidatorFactoryInterface $vf,
    ) {
    }

    #[Transactional(attempts: 1)]
    public function add(AddNotificationDTO $notificationData): Notification
    {
        return tap(
            $this->rNotification->create($this->validate($notificationData)),
            function (Notification $notification) {
                if (! $this->rNotification->save($notification)) {
                    throw new BusinessException(ErrorCode::BAD_REQUEST_ERROR, __('exceptions.php.400'));
                }
            }
        );
    }

    private function validate(AddNotificationDTO $notificationData): array
    {
        return $this->vf
            ->make($notificationData->toArray(), [
                'transport' => ['required', 'string', 'max:255'],
                'type' => ['required', 'string', 'max:255'],
                'target' => ['nullable', 'string', 'max:255'],
                'target_id' => ['nullable', 'string', 'max:255'],
                'title' => ['nullable', 'string', 'max:255'],
                'image' => ['nullable', 'array'],
                'image.id' => [Rule::exists('files', 'id')],
            ])
            ->validate();
    }
}
