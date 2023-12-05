<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class NotificationTransport extends AbstractConstants
{
    /**
     * @Message("Socket")
     */
    public const SOCKET = 'socket';

    /**
     * @Message("Email")
     */
    public const EMAIL = 'email';

    public const ALL = [self::SOCKET, self::EMAIL];
}
