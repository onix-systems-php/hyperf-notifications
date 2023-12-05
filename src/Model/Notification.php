<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfNotifications\Model;

use Carbon\Carbon;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\Database\Model\Relations\MorphOne;
use OnixSystemsPHP\HyperfCore\Model\AbstractOwnedModel;
use OnixSystemsPHP\HyperfFileUpload\Model\Behaviour\FileRelations;
use OnixSystemsPHP\HyperfFileUpload\Model\File;

/**
 * @property int $id
 * @property int $user_id
 * @property ?string $target
 * @property ?string $target_id
 * @property string $title
 * @property string $text
 * @property ?Carbon $seen_at
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 *
 * @property ?File $image
 * @property NotificationDelivery[] $deliveries
 *
 * @method MorphOne image()
 */
class Notification extends AbstractOwnedModel
{
    use FileRelations;

    public array $fileRelations = [
        'image' => [
            'limit' => 1,
            'required' => false,
            'mimeTypes' => [],
            'presets' => [
                '150x150' => ['fit' => [150, 150]],
            ],
        ],
    ];

    protected ?string $table = 'notifications';

    protected array $fillable = [
        'user_id',
        'target',
        'target_id',
        'title',
        'text',
        'seen_at',
    ];

    protected array $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'target' => 'string',
        'target_id' => 'string',
        'title' => 'string',
        'text' => 'string',
        'seen_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        $this->fileRelations['image']['mimeTypes'] = ApplicationContext::getContainer()
            ->get(ConfigInterface::class)
            ->get('file_upload.image_mime_types');

        parent::__construct($attributes);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(NotificationDelivery::class, 'notification_id', 'id');
    }
}
