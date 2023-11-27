<?php

namespace OnixSystemsPHP\HyperfNotifications\Contract;

use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Notifier\Chatter;

use function Hyperf\Support\make;

class ChatterInterface extends AbstractNotifier
{
    public function __invoke(ContainerInterface $container, array $parameters = [])
    {
        return make(
            Chatter::class,
            ['transport' => $this->getTransport($container->get(ConfigInterface::class), 'chatter')],
        );
    }
}
