<?php
return [
    'product_specification' => 'مشخصات محصول',
    'specification_groups' => [
        'title' => 'گروه‌های مشخصات',

        'create' => [
            'title' => 'ایجاد گروه مشخصات',
        ],

        'edit' => [
            'title' => 'ویرایش گروه مشخصات ":name"',
        ],
    ],

    'specification_attributes' => [
        'title' => 'ویژگی‌های مشخصات',

        'group' => 'گروه مرتبط',
        'group_placeholder' => 'گروه مورد نظر را انتخاب کنید',
        'type' => 'نوع فیلد',
        'default_value' => 'مقدار پیش‌فرض',
        'options' => [
            'heading' => 'گزینه‌ها',

            'add' => [
                'label' => 'افزودن گزینه جدید',
            ],
        ],

        'create' => [
            'title' => 'ایجاد ویژگی مشخصات',
        ],

        'edit' => [
            'title' => 'ویرایش ویژگی مشخصات ":name"',
        ],
    ],

    'specification_tables' => [
        'title' => 'جداول مشخصات',

        'create' => [
            'title' => 'ایجاد جدول مشخصات',
        ],

        'edit' => [
            'title' => 'ویرایش جدول مشخصات ":name"',
        ],

        'fields' => [
            'groups' => 'گروه‌هایی که باید در این جدول نمایش داده شوند را انتخاب کنید',
            'name' => 'نام گروه',
            'assigned_groups' => 'گروه‌های اختصاص داده شده',
            'sorting' => 'مرتب‌سازی',
        ],
    ],

    'product' => [
        'specification_table' => [
            'options' => 'گزینه‌ها',
            'title' => 'جدول مشخصات',
            'select_none' => 'هیچکدام',
            'description' => 'جدول مشخصات را برای نمایش در این محصول انتخاب کنید',
            'group' => 'گروه',
            'attribute' => 'ویژگی',
            'value' => 'مقدار ویژگی',
            'hide' => 'مخفی کردن',
            'sorting' => 'مرتب‌سازی',
        ],
    ],

    'enums' => [
        'field_types' => [
            'text' => 'متن',
            'textarea' => 'متن بلند',
            'select' => 'انتخاب',
            'checkbox' => 'چک باکس',
            'radio' => 'رادیو',
        ],
    ],
];
