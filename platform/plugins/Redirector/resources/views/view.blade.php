<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>
        @if ($statusCode == 410)
            صفحه حذف شده
        @elseif ($statusCode == 404)
            صفحه پیدا نشد
        @elseif ($statusCode == 500)
            خطای سرور
        @else
            صفحه منتقل شد
        @endif
    </title>

    {{-- Robots meta --}}
    <meta name="robots" content="{{ !empty($redirect) && $redirect->is_nofollow ? 'noindex, nofollow' : 'index, follow' }}">

    {{-- Canonical meta --}}
    <link rel="canonical" href="{{ !empty($redirect) && $redirect->is_canonical ? $redirect->target : url()->current() }}">

    {{-- Redirect --}}
    @if (!empty($redirect) && $statusCode === 200 && $redirect->target)
        <meta http-equiv="refresh" content="3;url={{ $redirect->target }}">
    @endif

    <style>
        body {
            font-family: Tahoma, sans-serif;
            text-align: center;
            margin-top: 100px;
            direction: rtl;
            color: #333;
        }

        a {
            color: #3490dc;
            text-decoration: none;
        }

        .loading {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }

        .error {
            color: #ff4d4d;
        }
    </style>
</head>
<body>

@if ($statusCode === 410)
    <h1 class="error">این صفحه حذف شده است</h1>
    <p>لینک مورد نظر دیگر در دسترس نیست.</p>
    <a href="{{ url('/') }}">بازگشت به صفحه اصلی</a>

@elseif ($statusCode === 404)
    <h1 class="error">خطای ۴۰۴</h1>
    <p>متأسفیم، صفحه مورد نظر پیدا نشد.</p>
    <a href="{{ url('/') }}">بازگشت به صفحه اصلی</a>

@elseif ($statusCode === 500)
    <h1 class="error">خطای ۵۰۰</h1>
    <p>مشکلی در سرور رخ داده است.</p>
    <a href="{{ url('/') }}">بازگشت به صفحه اصلی</a>

@else
    <h1>این صفحه به آدرس جدید منتقل شده است</h1>
    <p>
        شما به صورت خودکار به
        <a href="{{ $redirect->target }}">{{ $redirect->target }}</a>
        هدایت خواهید شد.
    </p>
    <div class="loading">لطفاً چند لحظه صبر کنید...</div>
@endif

</body>
</html>
