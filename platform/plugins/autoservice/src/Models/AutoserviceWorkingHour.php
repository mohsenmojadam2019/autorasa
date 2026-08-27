<?php

namespace Botble\Autoservice\Models;

use Botble\Base\Models\BaseModel;

class AutoserviceWorkingHour extends BaseModel
{
    protected $table = 'service_center_working_hours';

    protected $fillable = [
        'service_center_id',
        'day',
    ];

    public function serviceCenter()
    {
        return $this->belongsTo(Autoservice::class, 'service_center_id');
    }

    public function timeSlots()
    {
        return $this->belongsToMany(
            AutoserviceTimeslot::class,
            'service_center_working_hour_time_slot',
            'working_hour_id',
            'time_slot_id'
        );
    }
}
