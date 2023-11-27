<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Contract;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Engine\Exception\RuntimeException;
use Symfony\Component\Notifier\Transport\AbstractTransport;
use Symfony\Component\Notifier\Transport\Dsn;

class AbstractNotifier
{
    protected function getTransport(ConfigInterface $config, string $defaultName): AbstractTransport
    {
        $configPath = 'notifier.' . $defaultName;

        $default = $config->get($configPath . '.default');
        if (! $default) {
            throw new RuntimeException('Default notifier for "' . $defaultName . '". Not found!', 400);
        }

        $factoryClass = $config->get($configPath . '.' . $default . '.factory_class');
        if (! $factoryClass) {
            throw new RuntimeException('Factory class for "' . $default . '" transport. Not found!', 400);
        }

        $dsn = $config->get($configPath . '.' . $default . '.dsn');
        if (! $dsn) {
            throw new RuntimeException('Invalid DSN for"' . $default . '".', 400);
        }

        return (new $factoryClass())->create(new Dsn($dsn));
    }
}
