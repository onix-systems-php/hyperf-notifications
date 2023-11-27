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
use Psr\Container\ContainerInterface;
use Symfony\Component\Notifier\Texter;

use function Hyperf\Support\make;

class TexterInterface extends AbstractNotifier
{
    public function __invoke(ContainerInterface $container, array $parameters = [])
    {
        return make(
            Texter::class,
            ['transport' => $this->getTransport($container->get(ConfigInterface::class), 'texter')],
        );
    }
}
