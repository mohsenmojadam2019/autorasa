<?php

namespace Botble\Autoservice\Models;

use App\Models\Cities;
use App\Models\Province;
use Botble\Base\Models\BaseModel;
use Botble\Media\Facades\RvMedia;

class Autoservice extends BaseModel
{
    protected $table = 'service_centers';

    protected $fillable = [
        'title',
        'code',
        'province_id',
        'city_id',
        'area',
        'address',
        'pic',
        'lat',
        'long',
    ];
    protected $appends = ['img_tag', 'img_url'];

    public function getImgTagAttribute()
    {
        return RvMedia::image($this->pic, theme_option('site_title'), attributes: [
            'class' => 'img-fluid',
            'style' => 'width: 95px !important; height: 95px !important; object-fit: contain;'
        ]);
    }

    public function getImgUrlAttribute()
    {
        return RvMedia::getImageUrl($this->pic);
    }
    public function workingHours()
    {
        return $this->hasMany(AutoserviceWorkingHour::class, 'service_center_id');
    }

    public function timeSlots()
    {
        return $this->hasMany(AutoserviceTimeslot::class, 'service_center_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(Cities::class);
    }
}
