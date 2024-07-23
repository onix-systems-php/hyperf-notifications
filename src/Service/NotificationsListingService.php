<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Service;

use Hyperf\DbConnection\Annotation\Transactional;
use OnixSystemsPHP\HyperfCore\DTO\Common\PaginationRequestDTO;
use OnixSystemsPHP\HyperfCore\DTO\Common\PaginationResultDTO;
use OnixSystemsPHP\HyperfCore\Service\Service;
use OnixSystemsPHP\HyperfNotifications\Repository\NotificationRepository;

#[Service]
class NotificationsListingService
{
    public function __construct(
        private readonly NotificationRepository $rNotification,
    ) {}

    #[Transactional(attempts: 1)]
    public function list(array $filters, PaginationRequestDTO $paginationRequest): PaginationResultDTO
    {
        return $this->rNotification->getPaginated($filters, $paginationRequest);
    }
}
