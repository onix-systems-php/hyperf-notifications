<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace OnixSystemsPHP\HyperfNotifications\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use OnixSystemsPHP\HyperfCore\Controller\AbstractController;
use OnixSystemsPHP\HyperfCore\DTO\Common\PaginationRequestDTO;
use OnixSystemsPHP\HyperfNotifications\Resource\ResourceNotification;
use OnixSystemsPHP\HyperfNotifications\Resource\ResourceNotificationsPaginated;
use OnixSystemsPHP\HyperfNotifications\Resource\ResourceNotificationStatistic;
use OnixSystemsPHP\HyperfNotifications\Service\NotificationReadService;
use OnixSystemsPHP\HyperfNotifications\Service\NotificationsListingService;
use OnixSystemsPHP\HyperfNotifications\Service\NotificationStatisticService;
use OpenApi\Attributes as OA;

class NotificationsController extends AbstractController
{
    #[OA\Get(
        path: '/v1/notifications',
        operationId: 'appNotifications',
        summary: 'Get list of notifications',
        security: [['bearerAuth' => []]],
        tags: ['notifications'],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/Locale'),
            new OA\Parameter(ref: '#/components/parameters/Pagination_page'),
            new OA\Parameter(ref: '#/components/parameters/Pagination_per_page'),
            new OA\Parameter(ref: '#/components/parameters/Pagination_order'),
            new OA\Parameter(ref: '#/components/parameters/NotificationsFilter__user_id'),
            new OA\Parameter(ref: '#/components/parameters/NotificationsFilter__transport'),
            new OA\Parameter(ref: '#/components/parameters/NotificationsFilter__type'),
            new OA\Parameter(ref: '#/components/parameters/NotificationsFilter__target'),
            new OA\Parameter(ref: '#/components/parameters/NotificationsFilter__target_id'),
            new OA\Parameter(ref: '#/components/parameters/NotificationsFilter__title'),
            new OA\Parameter(ref: '#/components/parameters/NotificationsFilter__text'),
            new OA\Parameter(ref: '#/components/parameters/NotificationsFilter__only_unread'),
        ],
        responses: [
            new OA\Response(response: 200, description: '', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/ResourceNotificationsPaginated'),
            ])),
            new OA\Response(ref: '#/components/responses/401', response: 401),
            new OA\Response(ref: '#/components/responses/500', response: 500),
        ],
    )]
    public function index(
        RequestInterface $request,
        NotificationsListingService $service
    ): ResourceNotificationsPaginated {
        return ResourceNotificationsPaginated::make(
            $service->list($request->getQueryParams(), PaginationRequestDTO::make($request))
        );
    }

    #[OA\Get(
        path: '/v1/notifications/statistic',
        operationId: 'appNotificationStatistic',
        summary: 'Get notifications statistic',
        security: [['bearerAuth' => []]],
        tags: ['notifications'],
        parameters: [new OA\Parameter(ref: '#/components/parameters/Locale')],
        responses: [
            new OA\Response(response: 200, description: '', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/ResourceNotificationStatistic'),
            ])),
            new OA\Response(ref: '#/components/responses/401', response: 401),
            new OA\Response(ref: '#/components/responses/500', response: 500),
        ],
    )]
    public function statistic(NotificationStatisticService $service): ResourceNotificationStatistic
    {
        return ResourceNotificationStatistic::make($service->statistic());
    }

    #[OA\Post(
        path: '/v1/notifications/{notificationId}/read',
        operationId: 'appNotificationRead',
        summary: 'Read notification',
        security: [['bearerAuth' => []]],
        tags: ['notifications'],
        parameters: [
            new OA\Parameter(
                name: 'notificationId',
                description: 'Notification ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(response: 200, description: '', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/ResourceNotification'),
            ])),
            new OA\Response(ref: '#/components/responses/401', response: 401),
            new OA\Response(ref: '#/components/responses/500', response: 500),
        ]
    )]
    public function read(int $notificationId, NotificationReadService $service): ResourceNotification
    {
        return ResourceNotification::make($service->read($notificationId));
    }
}
