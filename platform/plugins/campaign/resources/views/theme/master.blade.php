<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <meta name="robots" content="noindex, nofollow">

    <title> @yield('title', __('Checkout')) </title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        @media (min-width: 769px) {
    .custom-width {
      width: 60% !important;
    }
  }
    @media (max-width: 768px) {
        .custom-width {
      width: 100% !important;
    }
      .shadow-sm {
        padding: 2rem 2.5rem !important; /* Half the padding for mobile */
        margin: 0 2px 2rem 2px !important; /* Adjust margins accordingly */
      }
    }
        @font-face {
    font-family: 'RAvi';
    src: url('/FONT/RAvi/RaviFaNum-Regular.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'RAvi';
    src: url('/FONT/RAvi/RaviFaNum-Bold.woff2') format('woff2');
    font-weight: bold;
    font-style: normal;
}

@font-face {
    font-family: 'RAvi';
    src: url('/FONT/RAvi/RaviFaNum-Light.woff2') format('woff2');
    font-weight: 300;
    font-style: normal;
}

@font-face {
    font-family: 'RAvi';
    src: url('/FONT/RAvi/RaviFaNum-Medium.woff2') format('woff2');
    font-weight: 500;
    font-style: normal;
}

@font-face {
    font-family: 'RAvi';
    src: url('/FONT/RAvi/RaviFaNum-SemiBold.woff2') format('woff2');
    font-weight: 600;
    font-style: normal;
}

@font-face {
    font-family: 'RAvi';
    src: url('/FONT/RAvi/RaviFaNum-Thin.woff2') format('woff2');
    font-weight: 100;
    font-style: normal;
}
        h1, h2, h3, h4, h5, h6 {
            font-family: Ravi !important;
        }

    </style>
{{--    {!! Html::style('vendor/core/core/base/libraries/font-awesome/css/fontawesome.min.css') !!}--}}
    {!! Html::style('vendor/core/plugins/kyc/css/vendors.css') !!}
    {!! Html::style('vendor/core/plugins/campaign/css/campaign.css') !!} <!-- Include the custom CSS file -->

{{--    @if (BaseHelper::isRtlEnabled())--}}
{{--        {!! Html::style('vendor/core/plugins/ecommerce/css/front-theme-rtl.css?v=3.8.0') !!}--}}
{{--    @endif--}}

    {!! Html::style('vendor/core/core/base/libraries/toastr/toastr.min.css') !!}
{{--    {!! Html::style('vendor/core/plugins/kyc/css/app.css') !!}--}}
{{--    {!! Html::style('vendor/core/plugins/kyc/css/custom-rtl.css') !!}--}}
{{--    {!! Html::style('vendor/core/plugins/kyc/css/plugins/menu-types/horizontal-menu.css') !!}--}}

{{--    {!! Html::style('vendor/core/plugins/kyc/css/plugins/forms/wizard.css') !!}--}}
{{--    {!! Html::style('vendor/core/plugins/kyc/css/plugins/pickers/daterange/daterange.css') !!}--}}

</head>

@php
    Theme::addBodyAttributes([
        'class' => 'checkout-page',
    ]);
@endphp

<body style="background-color: #fff; font-family: Ravi !important;" >
    <div class="container my-0 my-md-3 my-lg-5 checkout-content-wrap">
        @yield('content')
    </div>

    @stack('footer')
    {!! Html::script('vendor/core/core/base/libraries/toastr/toastr.min.js') !!}

{{--    {!! Html::script('vendor/core/plugins/kyc/js/vendors.min.js') !!}--}}

{{--    {!! Html::script('vendor/core/plugins/kyc/js/ui/jquery.sticky.js') !!}--}}

{{--    {!! Html::script('vendor/core/plugins/kyc/js/charts/jquery.sparkline.min.js') !!}--}}

{{--    {!! Html::script('vendor/core/plugins/kyc/js/extensions/jquery.steps.min.js') !!}--}}
{{--    {!! Html::script('vendor/core/plugins/kyc/js/forms/validation/jquery.validate.min.js') !!}--}}
{{--    {!! Html::script('vendor/core/plugins/kyc/js/core/app-menu.js') !!}--}}
{{--    {!! Html::script('vendor/core/plugins/kyc/js/core/app.js') !!}--}}
{{--    {!! Html::script('vendor/core/plugins/kyc/js/scripts/customizer.js') !!}--}}

{{--    {!! Html::script('vendor/core/plugins/kyc/js/scripts/ui/breadcrumbs-with-stats.js') !!}--}}
{{--    {!! Html::script('vendor/core/plugins/kyc/js/scripts/forms/wizard-steps.js') !!}--}}


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

</body>
</html>
