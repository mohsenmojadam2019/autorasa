<?php

return [
    'name' => 'اعلانات',

    'enums' => [
        'announce_placement' => [
            'top' => 'بالا',
            'bottom' => 'ثابت در پایین',
            'popup' => 'پاپ آپ',
            'theme' => 'ساختار داخلی تم',
        ],

        'text_alignment' => [
            'start' => 'شروع',
            'center' => 'مرکز',
        ],
    ],

    'validation' => [
        'font_size' => 'اندازه فونت باید یک مقدار معتبر اندازه فونت CSS باشد.',
        'text_color' => 'رنگ متن باید یک مقدار معتبر رنگ هگز باشد.',
    ],

    'create' => 'ایجاد اعلان جدید',
    'add_new' => 'اضافه کردن جدید',
    'settings' => [
        'name' => 'اعلان',
        'description' => 'مدیریت تنظیمات اعلان',
    ],

    'background_color' => 'رنگ پس‌زمینه',
    'font_size' => 'اندازه فونت',
    'font_size_help' => 'برای استفاده از مقدار پیش‌فرض آن را خالی بگذارید. مثال: 1rem، 1em، 12px، ...',
    'text_color' => 'رنگ متن',
    'start_date' => 'تاریخ شروع',
    'end_date' => 'تاریخ پایان',
    'has_action' => 'دارای اقدام',
    'action_label' => 'برچسب اقدام',
    'action_url' => 'URL اقدام',
    'action_open_new_tab' => 'باز کردن در تب جدید',
    'dismissible_label' => 'اجازه دادن به کاربر برای بستن اعلان',
    'placement' => 'مکان قرارگیری',
    'text_alignment' => 'تراز متن',
    'is_active' => 'فعال است',
    'max_width' => 'عرض حداکثر',
    'max_width_help' => 'برای استفاده از مقدار پیش‌فرض آن را خالی بگذارید. مثال: 100%، 500px، ...',
    'max_width_unit' => 'واحد عرض حداکثر',
    'font_size_unit' => 'واحد اندازه فونت',
    'autoplay_label' => 'پخش خودکار',
    'autoplay_delay_label' => 'تاخیر پخش خودکار',
    'autoplay_delay_help' => 'تاخیر بین هر اعلان به میلی‌ثانیه. برای استفاده از مقدار پیش‌فرض آن را خالی بگذارید (5000).',
    'lazy_loading' => 'بارگذاری تنبل',
    'lazy_loading_description' => 'فعال‌سازی این گزینه برای بهبود سرعت بارگذاری صفحه',
    'hide_on_mobile' => 'پنهان کردن در موبایل',
];
