<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace OnixSystemsPHP\HyperfNotifications\Model\Filter;

use Hyperf\Database\Model\Builder;
use OnixSystemsPHP\HyperfCore\Model\Filter\AbstractFilter;
use OpenApi\Attributes as OA;

#[
    OA\Parameter(parameter: 'NotificationsFilter__only_unread', name: 'only_unread', in: 'query', schema: new OA\Schema(type: 'boolean')),
    OA\Parameter(parameter: 'NotificationsFilter__transport', name: 'transport', in: 'query', schema: new OA\Schema(type: 'string')),
    OA\Parameter(parameter: 'NotificationsFilter__type', name: 'type', in: 'query', schema: new OA\Schema(type: 'string')),
    OA\Parameter(parameter: 'NotificationsFilter__target', name: 'target', in: 'query', schema: new OA\Schema(type: 'string')),
    OA\Parameter(parameter: 'NotificationsFilter__target_id', name: 'target_id', in: 'query', schema: new OA\Schema(type: 'string')),
    OA\Parameter(parameter: 'NotificationsFilter__title', name: 'title', in: 'query', schema: new OA\Schema(type: 'string')),
    OA\Parameter(parameter: 'NotificationsFilter__text', name: 'text', in: 'query', schema: new OA\Schema(type: 'string')),
    OA\Parameter(parameter: 'NotificationsFilter__user_id', name: 'user_id', in: 'query', schema: new OA\Schema(type: 'integer')),
]
class NotificationFilter extends AbstractFilter
{
    public function userId(int $param): void
    {
        $this->builder->where('user_id', '=', $param);
    }

    public function transport(string $param): void
    {
        $this->builder->where('transport', '=', $param);
    }

    public function type(string $param): void
    {
        $this->builder->where('type', '=', $param);
    }

    public function target(string $param): void
    {
        $this->builder->where('target', '=', $param);
    }

    public function targetId(string $param): void
    {
        $this->builder->where('target_id', '=', $param);
    }

    public function title(string $param): void
    {
        $this->builder->where('title', 'LIKE', "%{$param}%");
    }

    public function text(string $param): void
    {
        $this->builder->where('text', 'LIKE', "%{$param}%");
    }

    public function onlyUnread(bool $param): void
    {
        $this->builder->when($param, static fn (Builder $builder) => $builder->whereNull('seen_at'));
    }
}
