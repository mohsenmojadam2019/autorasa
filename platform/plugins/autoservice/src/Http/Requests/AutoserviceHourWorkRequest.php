<?php

namespace Botble\Autoservice\Http\Requests;

use Botble\Autoservice\Models\AutoserviceWorkingHour;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class AutoserviceHourWorkRequest extends Request
{
    private const WEEKDAYS = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'];

    public function rules(): array
    {
        $workingHour = $this->route('autoservicehourwork');
        $workingHourId = $workingHour instanceof AutoserviceWorkingHour
            ? $workingHour->getKey()
            : (is_numeric($workingHour) ? (int) $workingHour : null);

        return [
            'service_center_id' => ['required', 'integer', 'exists:service_centers,id'],
            'day' => [
                'required',
                'string',
                'max:50',
                Rule::in(self::WEEKDAYS),
                Rule::unique('service_center_working_hours', 'day')
                    ->where(fn ($query) => $query->where('service_center_id', $this->input('service_center_id')))
                    ->ignore($workingHourId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'service_center_id.required' => 'انتخاب مرکز خدمات الزامی است.',
            'service_center_id.exists' => 'مرکز خدمات انتخاب‌شده معتبر نیست.',
            'day.required' => 'روز الزامی است.',
            'day.unique' => 'برای این مرکز خدمات، این روز قبلاً ثبت شده است.',
        ];
    }
}
