<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Resource;

use OnixSystemsPHP\HyperfCore\DTO\Common\PaginationResultDTO;
use OnixSystemsPHP\HyperfCore\Resource\AbstractPaginatedResource;
use OpenApi\Attributes as OA;

/**
 * @method __construct(PaginationResultDTO $resource)
 * @property PaginationResultDTO $resource
 */
#[OA\Schema(
    schema: 'ResourceNotificationsPaginated',
    properties: [
        new OA\Property(property: 'list', type: 'array', items: new OA\Items(ref: '#/components/schemas/ResourceNotification')),
        new OA\Property(property: 'total', type: 'integer'),
        new OA\Property(property: 'page', type: 'integer'),
        new OA\Property(property: 'per_page', type: 'integer'),
        new OA\Property(property: 'total_pages', type: 'integer'),
    ],
)]
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
