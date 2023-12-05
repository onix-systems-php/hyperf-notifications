<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
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
                    'description' => 'The notifications migration for onix-systems-php/hyperf-notifications.',
                    'source' => __DIR__ . '/../publish/migrations/2022_12_28_112313_create_notifications_table.php',
                    'destination' => BASE_PATH . '/migrations/2022_12_28_112313_create_notifications_table.php',
                ],
                [
                    'id' => 'migration_drop_column',
                    'description' => 'The additional migration for onix-systems-php/hyperf-notifications.',
                    'source' => __DIR__ . '/../publish/migrations/2023_11_29_144509_remove_columns_from_notifications_table.php',
                    'destination' => BASE_PATH . '/migrations/2023_11_29_144509_remove_columns_from_notifications_table.php',
                ],
                [
                    'id' => 'migration_delivery',
                    'description' => 'The additional migration for onix-systems-php/hyperf-notifications.',
                    'source' => __DIR__ . '/../publish/migrations/2023_11_29_144510_add_notification_deliveries_table.php',
                    'destination' => BASE_PATH . '/migrations/2023_11_29_144510_add_notification_deliveries_table.php',
                ],
                [
                    'id' => 'migration_delivery_options',
                    'description' => 'The additional migration for onix-systems-php/hyperf-notifications.',
                    'source' => __DIR__ . '/../publish/migrations/2023_12_05_105257_add_options_to_notification_deliveries_table.php',
                    'destination' => BASE_PATH . '/migrations/2023_12_05_105257_add_options_to_notification_deliveries_table.php',
                ],

                [
                    'id' => 'config',
                    'description' => 'The notifier config for onix-systems-php/hyperf-notifications.',
                    'source' => __DIR__ . '/../publish/config/notifier.php',
                    'destination' => BASE_PATH . '/config/autoload/notifier.php',
                ],
                [
                    'id' => 'config_reminder',
                    'description' => 'The reminder config for onix-systems-php/hyperf-notifications.',
                    'source' => __DIR__ . '/../publish/config/reminder.php',
                    'destination' => BASE_PATH . '/config/autoload/reminder.php',
                ],

                [
                    'id' => 'view_layout',
                    'description' => 'The reminder view layout for onix-systems-php/hyperf-notifications.',
                    'source' => __DIR__ . '/../publish/view/layout.blade.php',
                    'destination' => BASE_PATH . '/storage/view/emails/layouts/reminder.blade.php',
                ],
                [
                    'id' => 'view_reminder',
                    'description' => 'The reminder view for onix-systems-php/hyperf-notifications.',
                    'source' => __DIR__ . '/../publish/view/reminder.blade.php',
                    'destination' => BASE_PATH . '/storage/view/emails/reminder/reminder.blade.php',
                ],
            ],
        ];
    }
}
