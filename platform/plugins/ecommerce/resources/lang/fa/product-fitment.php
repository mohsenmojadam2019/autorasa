<?php
return [
    'product_sitment' => 'سازگاری محصول',
    'sitment_groups' => [
        'title' => 'گروه‌های سازگاری',

        'create' => [
            'title' => 'ایجاد گروه سازگاری',
        ],

        'edit' => [
            'title' => 'ویرایش گروه سازگاری ":name"',
        ],
    ],

    'sitment_attributes' => [
        'title' => 'ویژگی‌های سازگاری',

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
            'title' => 'ایجاد ویژگی سازگاری',
        ],

        'edit' => [
            'title' => 'ویرایش ویژگی سازگاری ":name"',
        ],
    ],

    'sitment_tables' => [
        'title' => 'جداول سازگاری',

        'create' => [
            'title' => 'ایجاد جدول سازگاری',
        ],

        'edit' => [
            'title' => 'ویرایش جدول سازگاری ":name"',
        ],

        'fields' => [
            'groups' => 'گروه‌هایی که باید در این جدول نمایش داده شوند را انتخاب کنید',
            'name' => 'نام گروه',
            'assigned_groups' => 'گروه‌های اختصاص داده شده',
            'sorting' => 'مرتب‌سازی',
        ],
    ],

    'product' => [
        'sitment_table' => [
            'options' => 'گزینه‌ها',
            'title' => 'جدول سازگاری',
            'select_none' => 'هیچکدام',
            'description' => 'جدول سازگاری را برای نمایش در این محصول انتخاب کنید',
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
