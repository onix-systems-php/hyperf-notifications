<?php

return [
    /*
     * When the message is sent again, in seconds. Default: 10 minutes
     */
    'time' => env('REMINDER_RESEND_TIME', 60 * 10),
];
