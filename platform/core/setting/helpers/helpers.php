<?php

use Botble\Base\Facades\BaseHelper;
use Botble\Setting\Facades\Setting;
use Botble\Setting\Supports\SettingStore;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Carbon\CarbonInterface;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

if (!function_exists('concatValuesFromJson')) {
    function concatValuesFromJson(string $json): string
    {
        $array = json_decode($json, true);

        if (!is_array($array)) {
            return '';
        }

        $result = '';
        foreach ($array as $item) {
            if (isset($item['value'])) {
                $result .= $item['value'];
            }
        }

        return $result;
    }
}
function getUpcomingWeekdaysWithDates(array $days): array
{
    $dayMap = [
        'شنبه'     => CarbonInterface::SATURDAY,
        'یکشنبه'   => CarbonInterface::SUNDAY,
        'دوشنبه'   => CarbonInterface::MONDAY,
        'سه شنبه'  => CarbonInterface::TUESDAY,
        'چهارشنبه' => CarbonInterface::WEDNESDAY,
        'پنجشنبه'  => CarbonInterface::THURSDAY,
        'جمعه'     => CarbonInterface::FRIDAY,
    ];

    $result = [];
    $today = Carbon::tomorrow();

    foreach ($days as $day) {
        if (!isset($dayMap[$day])) {
            continue;
        }

        $date = $today->copy()->next($dayMap[$day]);

        if ($today->dayOfWeek === $dayMap[$day]) {
            $date = $today->copy();
        }

        $result[] = [
            'day'         => $day,
            'date'        => $date->format('Y-m-d'), // تاریخ میلادی
            'jalali_date' => Jalalian::fromCarbon($date)->format('Y/m/d'), // تاریخ شمسی
        ];
    }

    // مرتب‌سازی بر اساس تاریخ
    usort($result, function ($a, $b) {
        return strtotime($a['date']) <=> strtotime($b['date']);
    });

    return $result;
}


if (! function_exists('setting')) {
    function setting(?string $key = null, $default = null)
    {
        if (! empty($key)) {
            try {
                return app(SettingStore::class)->get($key, $default);
            } catch (Throwable) {
                return $default;
            }
        }

        return Setting::getFacadeRoot();
    }
}

if (! function_exists('get_admin_email')) {
    function get_admin_email(): Collection
    {
        $email = setting('admin_email');

        if (! $email) {
            return collect();
        }

        $email = is_array($email) ? $email : (array) json_decode($email, true);

        return collect(array_filter($email));
    }
}

if (! function_exists('get_setting_email_template_content')) {
    function get_setting_email_template_content(string $type, string $module, string $templateKey): string
    {
        $defaultPath = platform_path($type . '/' . $module . '/resources/email-templates/' . $templateKey . '.tpl');
        $storagePath = get_setting_email_template_path($module, $templateKey);

        if ($storagePath != null && File::exists($storagePath)) {
            return BaseHelper::getFileData($storagePath, false);
        }

        return File::exists($defaultPath) ? BaseHelper::getFileData($defaultPath, false) : '';
    }
}

if (! function_exists('get_setting_email_template_path')) {
    function get_setting_email_template_path(string $module, string $templateKey): string
    {
        $template = apply_filters('setting_email_template_path', "$module/$templateKey.tpl", $module, $templateKey);

        return storage_path('app/email-templates/' . $template);
    }
}

if (! function_exists('get_setting_email_subject_key')) {
    function get_setting_email_subject_key(string $type, string $module, string $templateKey): string
    {
        $key = $type . '_' . $module . '_' . $templateKey . '_subject';

        return apply_filters('setting_email_subject_key', $key, $module, $templateKey);
    }
}

if (! function_exists('get_setting_email_subject')) {
    function get_setting_email_subject(string $type, string $module, string $templateKey): string
    {
        return setting(
            get_setting_email_subject_key($type, $module, $templateKey),
            trans(
                config(
                    $type . '.' . $module . '.email.templates.' . $templateKey . '.subject',
                    ''
                )
            )
        );
    }
}

if (! function_exists('get_setting_email_status_key')) {
    function get_setting_email_status_key(string $type, string $module, string $templateKey): string
    {
        return $type . '_' . $module . '_' . $templateKey . '_' . 'status';
    }
}

if (! function_exists('get_setting_email_status')) {
    function get_setting_email_status(string $type, string $module, string $templateKey): string
    {
        $default = config($type . '.' . $module . '.email.templates.' . $templateKey . '.enabled', true);

        return setting(get_setting_email_status_key($type, $module, $templateKey), $default);
    }
}
