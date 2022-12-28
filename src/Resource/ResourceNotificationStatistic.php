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
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ResourceNotificationStatistic",
 *     type="object",
 *     @OA\Property(property="count", type="integer"),
 * )
 * @method __construct(array $resource)
 * @property array $resource
 */
class ResourceNotificationStatistic extends AbstractResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        return [
            'count' => $this->resource['count'],
        ];
    }
}
