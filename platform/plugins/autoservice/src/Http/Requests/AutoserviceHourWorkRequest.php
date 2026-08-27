<?php

namespace Botble\Autoservice\Http\Requests;

use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class AutoserviceHourWorkRequest extends Request
{
    public function rules(): array
    {
        return [
            'service_center_id' => ['required', 'integer', 'exists:service_centers,id'],
            'day' => ['required', 'string', 'max:50'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_center_id.required' => 'انتخاب مرکز خدمات الزامی است.',
            'service_center_id.exists' => 'مرکز خدمات انتخاب‌شده معتبر نیست.',
            'day.required' => 'روز الزامی است.',
            'start_time.required' => 'ساعت شروع الزامی است.',
            'start_time.date_format' => 'فرمت ساعت شروع باید به صورت HH:MM باشد.',
            'end_time.required' => 'ساعت پایان الزامی است.',
            'end_time.date_format' => 'فرمت ساعت پایان باید به صورت HH:MM باشد.',
            'end_time.after' => 'ساعت پایان باید بعد از ساعت شروع باشد.',
        ];
    }
}
