<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\DTO;

use OnixSystemsPHP\HyperfCore\DTO\AbstractDTO;

class AddNotificationDTO extends AbstractDTO
{
    public int $user_id;

    /** @var TransportDTO[] */
    public array $transports;

    public ?string $target;

    public ?string $target_id;

    public ?array $image;

    public string $title;

    public string $text;
}
