<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace OnixSystemsPHP\HyperfNotifications;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'migration',
                    'description' => 'The socialite migration for onix-systems-php/hyperf-notifications.',
                    'source' => __DIR__ . '/../publish/migrations/2022_12_28_112313_create_notifications_table.php',
                    'destination' => BASE_PATH . '/migrations/2022_12_28_112313_create_notifications_table.php',
                ],
            ],
        ];
    }
}
