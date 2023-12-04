<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Repository;

use OnixSystemsPHP\HyperfCore\Model\Builder;
use OnixSystemsPHP\HyperfCore\Repository\AbstractRepository;
use OnixSystemsPHP\HyperfNotifications\Model\NotificationDelivery;

/**
 * @method NotificationDelivery create(array $data)
 * @method NotificationDelivery update(NotificationDelivery $model, array $data)
 * @method NotificationDelivery save(NotificationDelivery $model)
 * @method bool delete(NotificationDelivery $model)
 * @method Builder|NotificationDeliveryRepository finder(string $type, ...$parameters)
 * @method null|NotificationDelivery fetchOne(bool $lock, bool $force)
 */
class NotificationDeliveryRepository extends AbstractRepository
{
    protected string $modelClass = NotificationDelivery::class;

    public function getById(int $id, bool $lock = false, bool $force = false): ?NotificationDelivery
    {
        return $this->finder('id', $id)->fetchOne($lock, $force);
    }

    public function scopeId(Builder $query, int $id): void
    {
        $query->where('id', '=', $id);
    }
}
