<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace OnixSystemsPHP\HyperfNotifications\Resource;

use OnixSystemsPHP\HyperfCore\Resource\AbstractResource;
use OnixSystemsPHP\HyperfNotifications\DTO\NotificationStatisticResultDTO;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ResourceNotificationStatistic",
 *     type="object",
 *     @OA\Property(property="count", type="integer"),
 * )
 * @method __construct(NotificationStatisticResultDTO $resource)
 * @property NotificationStatisticResultDTO $resource
 */
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
