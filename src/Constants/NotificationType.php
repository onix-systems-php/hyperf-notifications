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
