<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Service\Message;

use OnixSystemsPHP\HyperfCore\Service\Service;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\SentMessage;

#[Service]
class SendMessageService extends AbstractMessageService
{
    public function send(MessageInterface $message): ?SentMessage
    {
        return $this->getNotifier($message)?->send($message);
    }
}
