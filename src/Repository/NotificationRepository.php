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
        return $this->fetchOne($this->queryById($id), $lock, $force);
    }

    public function queryById(int $id): Builder
    {
        return $this->query()->where('id', $id);
    }

    protected function fetchOne(Builder $builder, bool $lock, bool $force): ?Notification
    {
        /** @var ?Notification $result */
        $result = parent::fetchOne($builder, $lock, $force);
        return $result;
    }
}
