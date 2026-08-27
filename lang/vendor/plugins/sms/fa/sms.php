<?php

return [
    'name' => 'درگاه‌های پیامک',
    'Your_password_changed_successfully' => 'رمز عبور شما با موفقیت تغییر یافت',

    'settings' => [
        'title' => 'پیامک',
        'description' => 'پیکربندی تنظیمات ارسال پیامک.',
        'form' => [
            'default_sms_provider' => 'ارائه‌دهنده پیش‌فرض پیامک',
            'default_sms_provider_help' => 'این ارائه‌دهنده پیش‌فرض پیامک است که برای ارسال پیامک‌ها استفاده خواهد شد.',
        ],
    ],
    'configure_button' => 'پیکربندی',
    'save_button' => 'ذخیره',
    'activate_button' => 'فعال‌سازی',
    'deactivate_button' => 'غیرفعال‌سازی',
    'test_button' => 'ارسال پیامک تست',
    'test_modal' => [
        'title' => 'ارسال پیامک تست',
        'description' => 'جزئیات پیام را وارد کنید تا یک پیامک تست ارسال کنید.',
        'to' => 'ارسال به',
        'to_placeholder' => 'شماره تلفنی را که پیامک تست به آن ارسال می‌شود وارد کنید.',
        'message' => 'پیام',
    ],
    'gateway_description' => 'ارسال پیامک با استفاده از :name.',
    'send_sms_failed' => 'خطایی در ارسال پیامک رخ داد. بررسی پاسخ در بخش گزارش پیامک را مد نظر قرار دهید.',
    'sms_sent' => 'پیامک با موفقیت ارسال شد.',

    'enums' => [
        'log_statuses' => [
            'pending' => 'در انتظار',
            'success' => 'موفق',
            'failed' => 'ناموفق',
        ],
    ],

    'logs' => [
        'title' => 'گزارش‌های پیامک',
        'detail_title' => 'گزارش پیامک #:id',
        'id' => 'شناسه',
        'message_id' => 'شناسه پیام',
        'provider' => 'ارائه‌دهنده',
        'from' => 'از',
        'to' => 'به',
        'message' => 'پیام',
        'status' => 'وضعیت',
        'sent_at' => 'زمان ارسال',
        'response' => 'پاسخ',
    ],
    'phone_number_verification'=>'تایید شماره موبایل',
    'your_OTP_is_invalid_or_expired'=>'کد وارد شده صحیح نمی باشد.',
    'Your_phone_number_has_been_verified_successfully'=>'موبایل شما با موفقیت احراز شد.',
    'phone_number_login'=>'ورود با رمز یک بار مصرف',
    'forgot_password'=>'فراموشی رمز عبور',
    'Your_logedin_successfully'=>'شما با موفقیت وارد شدید.',
    'The :attribute has already been verified.'=>":attribute قبلاً تایید شده است."


];
