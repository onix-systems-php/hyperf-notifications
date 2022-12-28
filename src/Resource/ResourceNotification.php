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
use OnixSystemsPHP\HyperfFileUpload\Resource\ResourceFile;
use OnixSystemsPHP\HyperfNotifications\Model\Notification;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ResourceNotification",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="transport", type="string"),
 *     @OA\Property(property="type", type="string"),
 *     @OA\Property(property="target", type="string"),
 *     @OA\Property(property="target_id", type="string"),
 *     @OA\Property(property="image", ref="#/components/schemas/ResourceFile"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="text", type="string"),
 *     @OA\Property(property="seen_at", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 *     @OA\Property(property="updated_at", type="string"),
 * )
 * @method __construct(Notification $resource)
 * @property Notification $resource
 */
class ResourceNotification extends AbstractResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'transport' => $this->resource->transport,
            'type' => $this->resource->type,
            'target' => $this->resource->target,
            'target_id' => $this->resource->target_id,
            'image' => ResourceFile::make($this->resource->image),
            'title' => $this->resource->title,
            'text' => $this->resource->text,
            'seen_at' => $this->resource->seen_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
