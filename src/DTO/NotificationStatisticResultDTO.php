<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\DTO;

use OnixSystemsPHP\HyperfCore\DTO\AbstractDTO;

class NotificationStatisticResultDTO extends AbstractDTO
{
    public int $count;
}
