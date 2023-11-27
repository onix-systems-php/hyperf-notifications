<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'texter' => [
        'default' => env('NOTIFIER_TEXTER'),

        'twilio' => [
            'dsn' => env('TWILIO_DSN'),
            'factory_class' => '',
        ],
    ],

    'chatter' => [
        'default' => env('NOTIFIER_CHATTER'),

        'telegram' => [
            'dsn' => env('TELEGRAM_DSN'),
            'factory_class' => '',
        ],
    ],
];
