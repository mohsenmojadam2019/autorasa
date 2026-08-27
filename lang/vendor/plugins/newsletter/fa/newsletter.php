<?php

return [
    'name' => 'خبرنامه‌ها',
    'newsletter_form' => 'فرم خبرنامه',
    'description' => 'مشاهده و حذف مشترکین خبرنامه',
    'settings' => [
        'email' => [
            'templates' => [
                'title' => 'خبرنامه',
                'description' => 'پیکربندی قالب‌های ایمیل خبرنامه',
                'to_admin' => [
                    'title' => 'ایمیل ارسال شده به مدیر',
                    'description' => 'قالب برای ارسال ایمیل به مدیر',
                    'subject' => 'کاربر جدید به خبرنامه شما مشترک شده است',
                    'newsletter_email' => 'ایمیل کاربری که به خبرنامه مشترک شده است',
                ],
                'to_user' => [
                    'title' => 'ایمیل ارسال شده به کاربر',
                    'description' => 'قالب برای ارسال ایمیل به مشترک',
                    'subject' => '{{ site_title }}: اشتراک تایید شده!',
                    'newsletter_name' => 'نام کامل کاربر که به خبرنامه مشترک شده است',
                    'newsletter_email' => 'ایمیل کاربری که به خبرنامه مشترک شده است',
                    'newsletter_unsubscribe_link' => 'لینک برای لغو اشتراک از خبرنامه',
                    'newsletter_unsubscribe_url' => 'آدرس URL برای لغو اشتراک از خبرنامه',
                ],
            ],
        ],
        'title' => 'خبرنامه',
        'panel_description' => 'مشاهده و به‌روزرسانی تنظیمات خبرنامه',
        'description' => 'تنظیمات برای خبرنامه (ارسال خودکار ایمیل خبرنامه به SendGrid، Mailchimp... وقتی که کسی در وب‌سایت به خبرنامه مشترک می‌شود).',
        'mailchimp_api_key' => 'کلید API Mailchimp',
        'mailchimp_list_id' => 'شناسه فهرست Mailchimp',
        'mailchimp_list' => 'فهرست Mailchimp',
        'sendgrid_api_key' => 'کلید API Sendgrid',
        'sendgrid_list_id' => 'شناسه فهرست Sendgrid',
        'sendgrid_list' => 'فهرست Sendgrid',
        'enable_newsletter_contacts_list_api' => 'آیا API فهرست تماس خبرنامه فعال باشد؟',
    ],
    'statuses' => [
        'subscribed' => 'مشترک شده',
        'unsubscribed' => 'لغو اشتراک شده',
    ],
];
