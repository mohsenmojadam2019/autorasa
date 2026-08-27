<?php

return [
    'create' => 'ایجاد یک پست جدید',
    'form' => [
        'name' => 'نام',
        'name_placeholder' => 'نام پست (حداکثر :c کاراکتر)',
        'description' => 'توضیحات',
        'description_placeholder' => 'توضیح کوتاه برای پست (حداکثر :c کاراکتر)',
        'categories' => 'دسته‌بندی‌ها',
        'tags' => 'برچسب‌ها',
        'tags_placeholder' => 'برچسب‌ها',
        'content' => 'محتوا',
        'is_featured' => 'ویژه کردن این پست',
        'note' => 'توضیحات محتوا',
        'format_type' => 'فرمت',
    ],
    'cannot_delete' => 'پست قابل حذف نیست',
    'post_deleted' => 'پست حذف شد',
    'posts' => 'پست‌ها',
    'post' => 'پست',
    'edit_this_post' => 'ویرایش این پست',
    'no_new_post_now' => 'در حال حاضر پستی وجود ندارد!',
    'menu_name' => 'پست‌ها',
    'widget_posts_recent' => 'پست‌های اخیر',
    'categories' => 'دسته‌بندی‌ها',
    'category' => 'دسته‌بندی',
    'author' => 'نویسنده',
    'export' => [
        'description' => 'صادرات پست‌ها به فایل CSV/Excel.',
        'total' => 'کل پست‌ها',
    ],
    'import' => [
        'description' => 'وارد کردن پست‌ها از فایل CSV/Excel.',
        'done_message' => ':created پست ایجاد شد و :updated پست به‌روزرسانی شد.',
        'rules' => [
            'nullable_string_max' => 'فیلد :attribute می‌تواند یک مقدار رشته‌ای با حداکثر طول :max کاراکتر باشد یا می‌تواند خالی باشد.',
            'sometimes_array' => 'فیلد :attribute می‌تواند یک مقدار آرایه‌ای باشد یا می‌تواند خالی باشد.',
            'in' => ':attribute باید یکی از مقادیر زیر باشد: :values.',
            'nullable_string' => 'فیلد :attribute می‌تواند یک مقدار رشته‌ای باشد یا می‌تواند خالی باشد.',
            'nullable_string_max_in' => 'فیلد :attribute می‌تواند خالی باشد، یا اگر مقدار داده شد باید یک رشته با حداکثر طول :max کاراکتر باشد و باید یکی از مقادیر زیر باشد: :values.',
        ],
    ],
];
