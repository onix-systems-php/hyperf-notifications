<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\HasOne;
use OnixSystemsPHP\HyperfCore\Model\AbstractModel;

/**
 * @property int $id
 * @property int $notification_id
 * @property string $type
 * @property string $transport
 * @property ?array $options
 * @property ?Carbon $sent_at
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 *
 * @property Notification $notification
 */
class NotificationDelivery extends AbstractModel
{
    protected ?string $table = 'notification_deliveries';

    protected array $fillable = [
        'notification_id',
        'type',
        'transport',
        'options',
        'sent_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'notification_id' => 'integer',
        'type' => 'string',
        'transport' => 'string',
        'options' => 'array',
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function sent(): self
    {
        $this->sent_at = Carbon::now();

        return $this;
    }

    public function notification(): HasOne
    {
        return $this->hasOne(Notification::class, 'id', 'notification_id');
    }
}
