<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Resource;

use OnixSystemsPHP\HyperfCore\Resource\AbstractResource;
use OnixSystemsPHP\HyperfNotifications\DTO\NotificationStatisticResultDTO;
use OpenApi\Attributes as OA;

/**
 * @method __construct(NotificationStatisticResultDTO $resource)
 * @property NotificationStatisticResultDTO $resource
 */
#[OA\Schema(
    schema: 'ResourceNotificationStatistic',
    properties: [
        new OA\Property(property: 'count', type: 'integer'),
    ],
)]
class ResourceNotificationStatistic extends AbstractResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        return [
            'count' => $this->resource->count,
        ];
    }
}
