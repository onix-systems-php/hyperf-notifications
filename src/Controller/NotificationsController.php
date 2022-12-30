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
use OpenApi\Annotations as OA;

class NotificationsController extends AbstractController
{
    /**
     * @OA\Get(
     *     path="/v1/notifications",
     *     summary="Get list of notifications",
     *     operationId="appNotifications",
     *     tags={"notifications"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(ref="#/components/parameters/Locale"),
     *     @OA\Parameter(ref="#/components/parameters/Pagination_page"),
     *     @OA\Parameter(ref="#/components/parameters/Pagination_per_page"),
     *     @OA\Parameter(ref="#/components/parameters/Pagination_order"),
     *     @OA\Parameter(ref="#/components/parameters/NotificationsFilter__user_id"),
     *     @OA\Parameter(ref="#/components/parameters/NotificationsFilter__transport"),
     *     @OA\Parameter(ref="#/components/parameters/NotificationsFilter__type"),
     *     @OA\Parameter(ref="#/components/parameters/NotificationsFilter__target"),
     *     @OA\Parameter(ref="#/components/parameters/NotificationsFilter__target_id"),
     *     @OA\Parameter(ref="#/components/parameters/NotificationsFilter__title"),
     *     @OA\Parameter(ref="#/components/parameters/NotificationsFilter__text"),
     *     @OA\Parameter(ref="#/components/parameters/NotificationsFilter__only_unread"),
     *     @OA\Response(response=200, description="", @OA\JsonContent(
     *         @OA\Property(property="status", type="string"),
     *         @OA\Property(property="data", ref="#/components/schemas/ResourceNotificationsPaginated"),
     *     )),
     *     @OA\Response(response=401, ref="#/components/responses/401"),
     *     @OA\Response(response=500, ref="#/components/responses/500"),
     * )
     */
    public function index(
        RequestInterface $request,
        NotificationsListingService $service
    ): ResourceNotificationsPaginated {
        return ResourceNotificationsPaginated::make(
            $service->list($request->getQueryParams(), PaginationRequestDTO::make($request))
        );
    }

    /**
     * @OA\Get(
     *     path="/v1/notifications/statistic",
     *     summary="Get notifications statistic",
     *     operationId="appNotificationStatistic",
     *     tags={"notifications"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(ref="#/components/parameters/Locale"),
     *     @OA\Response(response=200, description="", @OA\JsonContent(
     *         @OA\Property(property="status", type="string"),
     *         @OA\Property(property="data", ref="#/components/schemas/ResourceNotificationStatistic"),
     *     )),
     *     @OA\Response(response=401, ref="#/components/responses/401"),
     *     @OA\Response(response=500, ref="#/components/responses/500"),
     * )
     */
    public function statistic(NotificationStatisticService $service): ResourceNotificationStatistic
    {
        return ResourceNotificationStatistic::make($service->statistic());
    }

    /**
     * @OA\Post(
     *     path="/v1/notifications/{notificationId}/read",
     *     summary="Get notifications statistic",
     *     operationId="appNotificationStatistic",
     *     tags={"notifications"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="notificationId",
     *         in="path", required=true,
     *         @OA\Schema(type="integer"),
     *         description="Notification ID"
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/Locale"),
     *     @OA\Response(response=200, description="", @OA\JsonContent(
     *         @OA\Property(property="status", type="string"),
     *         @OA\Property(property="data", ref="#/components/schemas/ResourceNotificationStatistic"),
     *     )),
     *     @OA\Response(response=401, ref="#/components/responses/401"),
     *     @OA\Response(response=500, ref="#/components/responses/500"),
     * )
     */
    public function read(int $notificationId, NotificationReadService $service): ResourceNotification
    {
        return ResourceNotification::make($service->read($notificationId));
    }
}
