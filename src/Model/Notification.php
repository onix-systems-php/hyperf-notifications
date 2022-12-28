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
use Hyperf\Database\Model\Relations\MorphOne;
use OnixSystemsPHP\HyperfCore\Model\AbstractModel;
use OnixSystemsPHP\HyperfFileUpload\Model\Behaviour\FileRelations;
use OnixSystemsPHP\HyperfFileUpload\Model\File;

/**
 * @property int $id
 * @property int $user_id
 * @property string $transport
 * @property string $type
 * @property ?string $target
 * @property ?string $target_id
 * @property string $title
 * @property string $text
 * @property ?Carbon $seen_at
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 *
 * @property ?File $image
 * @method MorphOne image()
 */
class Notification extends AbstractModel
{
    use FileRelations;

    protected $table = 'notifications';

    protected $guarded = [];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'transport' => 'string',
        'type' => 'string',
        'target' => 'string',
        'target_id' => 'string',
        'title' => 'string',
        'text' => 'array',
        'seen_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fileRelations = [
            'image' => [
                'limit' => 1,
                'required' => false,
                'mimeTypes' => Value('file_upload.image_mime_types'),
                'presets' => [
                    '150x150' => ['fit' => [150, 150]],
                ],
            ],
        ];
    }
}
