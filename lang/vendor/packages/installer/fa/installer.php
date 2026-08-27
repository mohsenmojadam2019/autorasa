<?php

return [

    /**
     *
     * Shared translations.
     *
     */
    'title' => 'نصب',
    'next' => 'گام بعدی',
    'back' => 'قبلی',
    'finish' => 'نصب کردن',
    'installation' => 'نصب',
    'forms' => [
        'errorTitle' => 'خطاهای زیر رخ داده است:',
    ],


    /**
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'title' => 'خوش آمدید',
        'message' => 'قبل از شروع، ما به برخی اطلاعات در مورد پایگاه داده نیاز داریم. شما باید موارد زیر را قبل از ادامه بدانید.',
        'language' => 'زبان',
        'next' => 'بزن بریم',
    ],

    /**
     *
     * ترجمه صفحه نیازمندی‌ها.
     *
     */
    'requirements' => [
        'title' => 'نیازمندی‌های سرور',
        'next' => 'بررسی مجوزها',
    ],

    /**
     *
     * ترجمه صفحه مجوزها.
     *
     */
    'permissions' => [
        'next' => 'پیکربندی محیط',
    ],

    /**
     *
     * ترجمه صفحه محیط.
     *
     */
    'environment' => [
        'wizard' => [
            'title' => 'تنظیمات محیط',
            'form' => [
                'name_required' => 'نام محیط الزامی است.',
                'app_name_label' => 'عنوان سایت',
                'app_name_placeholder' => 'عنوان سایت',
                'app_url_label' => 'URL',
                'app_url_placeholder' => 'URL',
                'db_connection_label' => 'اتصال به پایگاه داده',
                'db_connection_label_mysql' => 'MySQL',
                'db_connection_label_sqlite' => 'SQLite',
                'db_connection_label_pgsql' => 'PostgreSQL',
                'db_host_label' => 'میزبان پایگاه داده',
                'db_host_placeholder' => 'میزبان پایگاه داده',
                'db_port_label' => 'پورت پایگاه داده',
                'db_port_placeholder' => 'پورت پایگاه داده',
                'db_name_label' => 'نام پایگاه داده',
                'db_name_placeholder' => 'نام پایگاه داده',
                'db_username_label' => 'نام کاربری پایگاه داده',
                'db_username_placeholder' => 'نام کاربری پایگاه داده',
                'db_password_label' => 'کلمه عبور پایگاه داده',
                'db_password_placeholder' => 'کلمه عبور پایگاه داده',
                'buttons' => [
                    'install' => 'نصب',
                ],
                'db_host_helper' => 'اگر از Laravel Sail استفاده می‌کنید، فقط DB_HOST را به DB_HOST=mysql تغییر دهید. در برخی از هاست‌ها DB_HOST ممکن است به جای 127.0.0.1 به localhost تغییر یابد.',
                'db_connections' => [
                    'mysql' => 'MySQL',
                    'sqlite' => 'SQLite',
                    'pgsql' => 'PostgreSQL',
                ],
            ],
        ],
        'success' => 'تنظیمات فایل .env شما ذخیره شد.',
        'errors' => 'ناتوانی در ذخیره فایل .env، لطفاً آن را به صورت دستی ایجاد کنید.',
    ],

    'theme' => [
        'title' => 'انتخاب تم',
        'message' => 'یک تم برای شخصی‌سازی ظاهر وب‌سایت خود انتخاب کنید. این انتخاب همچنین داده‌های نمونه‌ای را که متناسب با تم انتخابی است، وارد می‌کند.',
    ],

    /**
     * صفحه ایجاد حساب.
     */
    'createAccount' => [
        'title' => 'ایجاد حساب کاربری',
        'form' => [
            'first_name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'username' => 'نام کاربری',
            'email' => 'ایمیل',
            'password' => 'کلمه عبور',
            'password_confirmation' => 'تأیید کلمه عبور',
            'create' => 'ایجاد',
        ],
    ],

    /**
     * License page.
     */

    'license' => [
        'title' => 'فعال‌سازی لایسنس',
        'skip' => 'فعلاً رد کردن',
    ],

    'install' => 'نصب',

    'final' => [
        'pageTitle' => 'نصب کامل شد',
        'title' => 'تمام شد',
        'message' => 'برنامه با موفقیت نصب شد.',
        'exit' => 'رفتن به داشبورد مدیریت',
    ],

    'install_success' => 'با موفقیت نصب شد!',

    'install_step_title' => 'نصب - مرحله :step: :title',

];
