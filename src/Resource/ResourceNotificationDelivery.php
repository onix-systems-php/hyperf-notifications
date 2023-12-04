<?php

namespace OnixSystemsPHP\HyperfNotifications\Resource;

use OnixSystemsPHP\HyperfCore\Resource\AbstractResource;
use OnixSystemsPHP\HyperfNotifications\Constants\NotificationType;
use OnixSystemsPHP\HyperfNotifications\Model\NotificationDelivery;
use OpenApi\Attributes as OA;

/**
 * @method __construct(NotificationDelivery $resource)
 * @property NotificationDelivery $resource
 */
#[OA\Schema(
    schema: 'ResourceNotificationDelivery',
    properties: [
        new OA\Property('id', type: 'integer'),
        new OA\Property('notification_id', type: 'integer'),
        new OA\Property('type', type: 'string', enum: [NotificationType::PRIMARY, NotificationType::REMINDER]),
        new OA\Property('transport', type: 'string'),
        new OA\Property('sent_at', type: 'string'),
        new OA\Property('created_at', type: 'string'),
        new OA\Property('updated_at', type: 'string'),
    ],
)]
class ResourceNotificationDelivery extends AbstractResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'notification_id' => $this->resource->notification_id,
            'type' => $this->resource->type,
            'transport' => $this->resource->transport,
            'sent_at' => $this->resource->sent_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
