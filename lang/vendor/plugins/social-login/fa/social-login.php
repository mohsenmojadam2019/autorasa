<?php

return [
    'settings' => [
        'title' => 'تنظیمات ورود اجتماعی',
        'description' => 'تنظیمات ورود از طریق شبکه‌های اجتماعی',
        'facebook' => [
            'enable' => 'فعال کردن ورود از طریق فیسبوک',
            'app_id' => 'شناسه برنامه',
            'app_secret' => 'رمز برنامه',
            'helper' => 'لطفاً به https://developers.facebook.com بروید تا برنامه جدید بسازید و شناسه برنامه و رمز برنامه را بروزرسانی کنید. URL بازگشت :callback',
            'data_deletion_request_callback_url' => 'این URL :url را به عنوان URL درخواست حذف داده‌ها در تنظیمات برنامه فیسبوک خود تنظیم کنید تا کاربران بتوانند درخواست حذف داده‌های خود را ارسال کنند.',
        ],
        'google' => [
            'enable' => 'فعال کردن ورود از طریق گوگل',
            'app_id' => 'شناسه برنامه',
            'app_secret' => 'رمز برنامه',
            'helper' => 'لطفاً به https://console.developers.google.com/apis/dashboard بروید تا برنامه جدید بسازید و شناسه برنامه و رمز برنامه را بروزرسانی کنید. URL بازگشت :callback',
        ],
        'github' => [
            'enable' => 'فعال کردن ورود از طریق گیت‌هاب',
            'app_id' => 'شناسه برنامه',
            'app_secret' => 'رمز برنامه',
            'helper' => 'لطفاً به https://github.com/settings/developers بروید تا برنامه جدید بسازید و شناسه برنامه و رمز برنامه را بروزرسانی کنید. URL بازگشت :callback',
        ],
        'linkedin' => [
            'enable' => 'فعال کردن ورود از طریق لینکدین',
            'app_id' => 'شناسه برنامه',
            'app_secret' => 'رمز برنامه',
            'helper' => 'لطفاً به https://www.linkedin.com/developers/apps/new بروید تا برنامه جدید بسازید و شناسه برنامه و رمز برنامه را بروزرسانی کنید. URL بازگشت :callback',
        ],
        'linkedin-openid' => [
            'enable' => 'فعال کردن ورود از طریق لینکدین با استفاده از OpenID Connect',
            'app_id' => 'شناسه برنامه',
            'app_secret' => 'رمز برنامه',
            'helper' => 'لطفاً به https://www.linkedin.com/developers/apps/new بروید تا برنامه جدید بسازید و شناسه برنامه و رمز برنامه را بروزرسانی کنید. URL بازگشت :callback',
        ],
        'enable' => 'آیا ورود اجتماعی را فعال کنیم؟',
        'style' => 'سبک',
        'minimal' => 'حداقل',
        'default' => 'پیش‌فرض',
        'basic' => 'بنیادی',
    ],
    'socials' => [
        'facebook' => 'فیسبوک',
        'google' => 'گوگل',
        'github' => 'گیت‌هاب',
        'linkedin' => 'لینکدین',
        'linkedin-openid' => 'لینکدین OpenID Connect',
    ],
    'menu' => 'ورود اجتماعی',
    'description' => 'مشاهده و بروزرسانی تنظیمات ورود اجتماعی',
    'sign_in_with' => 'ورود با استفاده از :provider',
];
