<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Service\Message;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Engine\Exception\RuntimeException;
use Symfony\Component\Notifier\Chatter;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\SentMessage;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Texter;
use Symfony\Component\Notifier\Transport\AbstractTransport;
use Symfony\Component\Notifier\Transport\Dsn;
use Symfony\Component\Notifier\Transport\TransportInterface;

abstract class AbstractMessageService
{
    public function __construct(protected readonly ConfigInterface $config) {}

    abstract public function send(MessageInterface $message): ?SentMessage;

    protected function getTransport(string $transportName, string $transport): AbstractTransport
    {
        $configPath = 'notifier.' . $transportName;

        $transportConfig = $this->config->get($configPath . '.' . $transport);
        if (! $transportConfig) {
            throw new RuntimeException('Config for "' . $transport . '". Not found!', 400);
        }

        $factoryClass = $transportConfig['factory_class'];
        if (! $factoryClass) {
            throw new RuntimeException('Factory class for "' . $transport . '" transport is empty!', 400);
        }
        if (! class_exists($factoryClass)) {
            throw new RuntimeException('Factory class "' . $factoryClass . '". Not found!', 400);
        }

        $dsn = $transportConfig['dsn'];
        if (! $dsn) {
            throw new RuntimeException('Invalid DSN for"' . $transport . '" transport.', 400);
        }

        return (new $factoryClass())->create(new Dsn($dsn));
    }

    protected function getNotifier(MessageInterface $interface): null|TransportInterface
    {
        if ($interface instanceof SmsMessage) {
            return new Texter($this->getTransport('texter', $interface->getTransport()));
        }
        if ($interface instanceof ChatMessage) {
            return new Chatter($this->getTransport('chatter', $interface->getTransport()));
        }

        return null;
    }
}
