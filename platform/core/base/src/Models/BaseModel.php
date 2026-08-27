<?php

namespace Botble\Base\Models;

use Botble\Base\Contracts\BaseModel as BaseModelContract;
use Botble\Base\Facades\MacroableModels;
use Botble\Base\Models\Concerns\HasBaseEloquentBuilder;
use Botble\Base\Models\Concerns\HasMetadata;
use Botble\Base\Models\Concerns\HasUuidsOrIntegerIds;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class BaseModel extends Model implements BaseModelContract
{
    use HasBaseEloquentBuilder;
    use HasMetadata;
    use HasUuidsOrIntegerIds;

    public function getCreatedAtAttribute($value)
    {
        return Jalalian::fromDateTime($value)->format('Y/m/d H:i:s');
    }

//    public function getUpdatedAtAttribute($value)
//    {
//        return Jalalian::fromDateTime($value)->format('Y/m/d H:i:s');
//    }
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = $this->convertToGregorian($value);
    }

    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = $this->convertToGregorian($value);
    }

//    protected function convertToGregorian($date)
//    {
//        if (!$date) {
//            return null;
//        }
//
//        try {
//            [$year, $month, $day] = explode('/', substr($date, 0, 10));
//            $time = substr($date, 11);
//            $gregorian = Jalalian::fromFormat('Y/m/d', "{$year}/{$month}/{$day}")->toCarbon();
//            return $gregorian->format('Y-m-d') . ' ' . ($time ?: '00:00:00');
//        } catch (\Exception $e) {
//            return $date;
//        }
//    }
    protected function convertToGregorian($date)
    {
        if (!$date) {
            return null;
        }

        try {
            // اگر شامل ساعت هست
            [$datePart, $timePart] = explode(' ', $date);
            [$year, $month, $day] = explode('/', $datePart);
            $time = $timePart ?? '00:00:00';

            // زمان را به صورت کامل به Jalalian بده
            [$hour, $minute, $second] = explode(':', $time);
            $carbon = Jalalian::fromFormat('Y/m/d H:i:s', "{$year}/{$month}/{$day} {$hour}:{$minute}:{$second}")
                ->toCarbon();

            return $carbon->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return $date;
        }
    }

    public function __get($key)
    {
        if (MacroableModels::modelHasMacro(static::class, $method = 'get' . Str::studly($key) . 'Attribute')) {
            return $this->{$method}();
        }

        return parent::__get($key);
    }
}
