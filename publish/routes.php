<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;
use OnixSystemsPHP\HyperfNotifications\Controller\NotificationsController;

Router::addGroup('/v1/notifications', function () {
    Router::get('', [NotificationsController::class, 'index']);
    Router::get('/statistic', [NotificationsController::class, 'statistic']);
    Router::post('/{notificationId}/read', [NotificationsController::class, 'read']);
});
