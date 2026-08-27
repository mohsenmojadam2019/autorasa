<?php

namespace Botble\Campaign\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Campaign extends BaseModel
{
    protected $table = 'campaigns';

    protected $fillable = [
        'name',
        'status'
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];
}
