# Hyperf-notifications component

Includes the following classes:

- DTO:
  - AddNotificationDTO.
- Model:
  - NotificationsFilter;
  - Notification.
- Repository:
  - NotificationRepository.
- Resource:
  - ResourceNotification.
  - ResourceNotificationsPaginated.
  - ResourceNotificationStatistic.
- Service:
  - NotificationAddService.
  - NotificationReadService.
  - NotificationsListingService.
  - NotificationStatisticService.

Install:

```shell script
composer require onix-systems-php/hyperf-notifications
```

Publish database migrations:

```shell script
php bin/hyperf.php vendor:publish onix-systems-php/notifications
```
