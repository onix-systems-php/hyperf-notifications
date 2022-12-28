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

use OnixSystemsPHP\HyperfCore\DTO\Common\PaginationResultDTO;
use OnixSystemsPHP\HyperfCore\Resource\AbstractPaginatedResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ResourceNotificationsPaginated",
 *     type="object",
 *     @OA\Property(property="list", type="array", @OA\Items(ref="#/components/schemas/ResourceNotification")),
 *     @OA\Property(property="total", type="integer"),
 *     @OA\Property(property="page", type="integer"),
 *     @OA\Property(property="per_page", type="integer"),
 *     @OA\Property(property="total_pages", type="integer"),
 * ),
 * @method __construct(PaginationResultDTO $resource)
 * @property PaginationResultDTO $resource
 */
class ResourceNotificationsPaginated extends AbstractPaginatedResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        $result = parent::toArray();
        $result['list'] = ResourceNotification::collection($this->resource->list);

        return $result;
    }
}
