<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use function Hyperf\Support\env;

return [
    'texter' => [
        'twilio' => [
            'dsn' => env('TWILIO_DSN'),
            // 'factory_class' => \Symfony\Component\Notifier\Bridge\Twilio\TwilioTransportFactory::class,
        ],
    ],

    'chatter' => [
        'telegram' => [
            'dsn' => env('TELEGRAM_DSN'),
            // 'factory_class' => \Symfony\Component\Notifier\Bridge\Telegram\TelegramTransportFactory::class,
        ],
    ],
];
