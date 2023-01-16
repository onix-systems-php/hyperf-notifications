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

use Hyperf\Database\Model\Builder;
use OnixSystemsPHP\HyperfCore\DTO\Common\PaginationRequestDTO;
use OnixSystemsPHP\HyperfCore\DTO\Common\PaginationResultDTO;
use OnixSystemsPHP\HyperfCore\Repository\AbstractRepository;
use OnixSystemsPHP\HyperfNotifications\Model\Filter\NotificationFilter;
use OnixSystemsPHP\HyperfNotifications\Model\Notification;

/**
 * @method Notification create(array $data)
 * @method Notification update(Notification $model, array $data)
 * @method Notification save(Notification $model)
 * @method bool delete(Notification $model)
 * @method Builder|NotificationRepository finder(string $type, ...$parameters)
 * @method null|Notification fetchOne(bool $lock, bool $force)
 */
class NotificationRepository extends AbstractRepository
{
    protected string $modelClass = Notification::class;

    public function getPaginated(
        array $filters,
        PaginationRequestDTO $paginationDTO,
        array $contain = []
    ): PaginationResultDTO {
        $query = $this->filter(new NotificationFilter($filters));
        if (! empty($contain)) {
            $query->with($contain);
        }

        return $this->paginate($query, $paginationDTO);
    }

    public function getById(int $id, bool $lock = false, bool $force = false): ?Notification
    {
        return $this->finder('id', $id)->fetchOne($lock, $force);
    }

    public function scopeId(Builder $query, int $id): void
    {
        $query->where('id', '=', $id);
    }
}
