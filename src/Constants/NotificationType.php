<?php

namespace OnixSystemsPHP\HyperfNotifications\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class NotificationType extends AbstractConstants
{
    /**
     * @Message("Primary")
     */
    public const PRIMARY = 'primary';

    /**
     * @Message("Reminder")
     */
    public const REMINDER = 'reminder';

    public const ALL = [self::PRIMARY, self::REMINDER];
}
