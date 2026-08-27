<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <title> @yield('title', __('Checkout')) </title>

    @if (theme_option('favicon'))
        <link
            href="{{ RvMedia::getImageUrl(theme_option('favicon')) }}"
            rel="shortcut icon"
        >
    @endif

    {!! Theme::typography()->renderCssVariables() !!}

    <style>
        :root {
            --primary-color: {{ $primaryColor = theme_option('primary_color', '#58b3f0') }};
            --primary-color-rgb: {{ implode(',', BaseHelper::hexToRgb($primaryColor)) }};
        }
        @font-face {
            font-family: 'IRANSansX';
            /*src: url('/fonts/IRANSansX-Medium.woff2') format('woff2');*/
            src: url('/FONT/IRANSans/IRANSansXFaNum-Light.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        * {
            font-family: 'IRANSansX' !important;
        }
        .tp-header-search-btn .tp-search-btn {
            --tp-btn-color: var(--tp-common-white);
            width: 60px !important;
            height: 46px !important;
            line-height: 46px !important;
            background-color: var(--tp-theme-primary) !important;
            color: var(--tp-btn-color) !important;
            border-radius: 16px !important;
            border: none !important;
            padding: 0 !important;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
    {!! Html::style('vendor/core/core/base/libraries/font-awesome/css/fontawesome.min.css') !!}
    {!! Html::style('vendor/core/core/base/libraries/ckeditor/content-styles.css?v=3.8.0') !!}
    {!! Html::style('vendor/core/plugins/ecommerce/css/front-theme.css?v=3.8.0') !!}

    @if (BaseHelper::isRtlEnabled())
        {!! Html::style('vendor/core/plugins/ecommerce/css/front-theme-rtl.css?v=3.8.0') !!}
    @endif

    {!! Html::style('vendor/core/core/base/libraries/toastr/toastr.min.css') !!}

    {!! Html::script('vendor/core/plugins/ecommerce/js/checkout.js?v=3.8.0') !!}

    @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
        <link
            href="{{ asset('vendor/core/core/base/libraries/select2/css/select2.min.css') }}"
            rel="stylesheet"
        >
        <script src="{{ asset('vendor/core/core/base/libraries/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('vendor/core/plugins/location/js/location.js?v=3.8.0') }}"></script>
    @endif

    {!! apply_filters('ecommerce_checkout_header', null) !!}

    {!! Html::style('vendor/core/plugins/ecommerce/css/front-theme.css?v=3.8.0') !!}
    {!! Html::style('vendor/core/plugins/popup-chat/css/popup-chat.min.css') !!}
    {!! Html::style('themes/shofy/plugins/bootstrap/bootstrap.rtl.min.css') !!}
    {!! Html::style('vendor/core/plugins/ecommerce/css/front-ecommerce.css?v=1.2.5.5') !!}
    {!! Html::style('themes/shofy/css/animate.css') !!}
    {!! Html::style('themes/shofy/plugins/swiper/swiper-bundle.css') !!}
    {!! Html::style('vendor/core/plugins/ecommerce/libraries/slick/slick.css') !!}
    {!! Html::style('themes/shofy/css/theme.css?v=1.2.5.4') !!}
    {!! Html::style('vendor/core/plugins/ecommerce/libraries/lightgallery/css/lightgallery.min.css') !!}
    {!! Html::style('vendor/core/plugins/ecommerce/css/front-ecommerce-rtl.css?v=1.2.5.5') !!}
    {!! Html::style('themes/shofy/css/theme-rtl.css?v=1.2.5.4') !!}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        // تابع تبدیل اعداد فارسی و عربی به انگلیسی

        function convertToEnglishDigits(str) {

            const persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];

            const arabicDigits  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];

            for (let i = 0; i < 10; i++) {

                str = str.replaceAll(persianDigits[i], i).replaceAll(arabicDigits[i], i);

            }

            return str;

        }

        $(document).ready(function () {

            // فقط موقع ارسال فرم، اعداد به انگلیسی تبدیل می‌شن

            $('form').on('submit', function () {

                $(this).find('input[type="text"], input[type="tel"], input[type="number"]').each(function () {

                    const val = $(this).val();

                    if (val) {

                        $(this).val(convertToEnglishDigits(val));

                    }

                });

            });

        });
</script>
    @stack('header')
</head>

<body{!! Theme::bodyAttributes() !!}>
    {!! apply_filters('ecommerce_checkout_body', null) !!}
{{--    اضافه کردن هدر--}}
    {!! Theme::partial('header.styles.header-1') !!}


    <div class="container my-0 my-md-3 my-lg-5 checkout-content-wrap">
        @yield('content')
    </div>

    @stack('footer')

    {!! Html::script('vendor/core/plugins/ecommerce/js/utilities.js?v=3.8.0') !!}
    {!! Html::script('vendor/core/core/base/libraries/toastr/toastr.min.js') !!}

    <script type="text/javascript">
        window.messages = {
            error_header: '{{ __('Error') }}',
            success_header: '{{ __('Success') }}',
        }
    </script>

    @if (session()->has('success_msg') || session()->has('error_msg') || isset($errors))
        <script type="text/javascript">
            $(document).ready(function() {
                @if (session()->has('success_msg') && session('success_msg'))
                    MainCheckout.showNotice('success', '{{ session('success_msg') }}');
                @endif
                @if (session()->has('error_msg'))
                    MainCheckout.showNotice('error', '{{ session('error_msg') }}');
                @endif
                @if (isset($errors) && $errors->count())
                    MainCheckout.showNotice('error', '{{ $errors->first() }}');
                @endif
            });
        </script>
    @endif
    .<div class="row">
        {{--    اضافه کردن فوتر--}}
        {!! Theme::partial('footer') !!}
    </div>
    {!! apply_filters('ecommerce_checkout_footer', null) !!}
{{--    --}}
    {!! Theme::partial('mobile-checkout-navigation') !!}

</body>
</html>
