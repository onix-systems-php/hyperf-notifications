<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use function Hyperf\Support\env;

return [
    /*
     * When the message is sent again, in seconds. Default: 10 minutes
     */
    'time' => env('REMINDER_RESEND_TIME', 60 * 10),
];
