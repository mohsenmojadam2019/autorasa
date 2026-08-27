<?php

return [
    'settings' => [
        'description' => 'پیکربندی زمان انقضای کد OTP و نیازمندی‌های تأیید شماره تلفن.',
        'form' => [
            'setup_guard_alert' => 'لطفاً یک گارد انتخاب کنید و تنظیمات را ذخیره کنید تا بتوانید تنظیمات OTP را پیکربندی کنید.',
            'guard' => 'گارد',
            'guard_help' => 'گاردی که برای تأیید OTP استفاده خواهد شد.',
            'expires_in' => 'زمان انقضای کد OTP',
            'expires_in_help' => 'زمانی به دقیقه که کد OTP منقضی می‌شود. پیش‌فرض 5 دقیقه است.',
            'phone_verification' => 'فعال‌سازی تأیید شماره تلفن',
            'requires_phone_verification' => 'نیاز به تأیید شماره تلفن',
            'requires_phone_verification_help' => 'اگر فعال شود، کاربران باید شماره تلفن خود را تأیید کنند قبل از اینکه بتوانند از سیستم استفاده کنند.',
            'message' => 'پیام OTP',
            'message_help' => 'پیامی که برای کاربر ارسال می‌شود. از {code} برای درج کد OTP استفاده کنید.',
            'your_OTP_code_is'=>'کد احراز هویت شما:code',
            "bodyidmessage"=>'کد الگو',
            'bodymessage_help' => 'پیامی که برای کاربر ارسال می‌شود. از {code} برای درج کد OTP استفاده کنید.',
        ],
    ],
    'enter_code' => 'لطفاً کد 4 رقمی ارسال شده به :identifier را وارد کنید.',
    'code_expiry' => ':time ثانیه تا',
    'did_not_receive_otp' => 'کد OTP را دریافت نکردید؟',
    'resend_otp' => 'ارسال مجدد کد ',
    'otp_sent' => 'کد OTP به شماره تلفن شما ارسال شد.',
    'verify' => 'تأیید',
    'back'=>'بازگشت'
];
