<?php

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
