<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;
use OnixSystemsPHP\HyperfNotifications\Controller\NotificationsController;

Router::addGroup('/v1/notifications', function () {
    Router::get('/', [NotificationsController::class, 'index']);
    Router::get('/statistic', [NotificationsController::class, 'statistic']);
    Router::get('/{notificationId}/read', [NotificationsController::class, 'statistic']);
});
