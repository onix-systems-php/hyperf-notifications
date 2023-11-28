<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Service\Message;

use OnixSystemsPHP\HyperfCore\Service\Service;
use Swoole\Coroutine;
use Swoole\Coroutine\Channel;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\SentMessage;

#[Service]
class SendMessageService extends AbstractMessageService
{
    public function send(MessageInterface $message): ?SentMessage
    {
        $channel = new Channel(1);
        Coroutine::create(fn () => $channel->push($this->getNotifier($message)?->send($message)));

        return $channel->pop();
    }
}
