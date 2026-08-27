<?php

namespace Botble\Autoservice\Models;

use Botble\Base\Models\BaseModel;

class AutoserviceTimeslot extends BaseModel
{
    protected $table = 'autoservice_time_slots';

    protected $fillable = [
        'service_center_id',
        'start_time',
        'end_time',
    ];

    public function serviceCenter()
    {
        return $this->belongsTo(Autoservice::class, 'service_center_id');
    }

    public function workingHours()
    {
        return $this->belongsToMany(
            AutoserviceWorkingHour::class,
            'service_center_working_hour_time_slot',
            'time_slot_id',
            'working_hour_id'
        );
    }
}
