<?php

namespace Botble\Campaign\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Operator extends BaseModel
{
    protected $table = 'operators';

    protected $fillable = [
        'name',
        'city',
        'address',
        'img',
        'status'
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];
    public function reserveAgencies()
    {
        return $this->hasMany(ReserveAgency::class, 'agency_id');
    }
}
