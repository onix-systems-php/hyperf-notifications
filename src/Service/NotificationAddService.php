<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Service;

use Hyperf\DbConnection\Annotation\Transactional;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Rule;
use OnixSystemsPHP\HyperfCore\Constants\ErrorCode;
use OnixSystemsPHP\HyperfCore\Exception\BusinessException;
use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfNotifications\Constants\NotificationType;
use OnixSystemsPHP\HyperfNotifications\DTO\AddNotificationDTO;
use OnixSystemsPHP\HyperfNotifications\Model\Notification;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationDeliveryRepository;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationRepository;

use function Hyperf\Tappable\tap;
use function Hyperf\Translation\__;

#[Service]
class NotificationAddService
{
    public function __construct(
        private readonly NotificationRepository $rNotification,
        private readonly NotificationDeliveryRepository $rDelivery,
        private readonly ValidatorFactoryInterface $vf,
    ) {}

    #[Transactional(attempts: 1)]
    public function add(AddNotificationDTO $notificationData): Notification
    {
        $notification = tap(
            $this->rNotification->create($this->validate($notificationData)),
            function (Notification $notification) {
                if (! $this->rNotification->save($notification)) {
                    throw new BusinessException(ErrorCode::BAD_REQUEST_ERROR, __('exceptions.php.400'));
                }
            }
        );

        foreach ($notificationData->transports as $transport) {
            $delivery = $this->rDelivery->create([
                'notification_id' => $notification->id,
                ...$transport->toArray(),
            ]);
            $this->rDelivery->save($delivery);
        }

        return $notification;
    }

    private function validate(AddNotificationDTO $notificationData): array
    {
        return $this->vf
            ->make($notificationData->toArray(), [
                'transports' => ['required', 'array'],
                'transports.*.type' => ['required', 'string', Rule::in(NotificationType::ALL)],
                'transports.*.transport' => ['required', 'string', 'max:255'],
                'transports.*.options' => ['nullable', 'array'],
                'user_id' => ['required', Rule::exists('users', 'id')],
                'target' => ['nullable', 'string', 'max:255'],
                'target_id' => ['nullable', 'string', 'max:255'],
                'title' => ['required', 'string'],
                'text' => ['required', 'string'],
                'image' => ['nullable', 'array'],
                'image.id' => [Rule::exists('files', 'id')],
            ])
            ->validate();
    }
}
