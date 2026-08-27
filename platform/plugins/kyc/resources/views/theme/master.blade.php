<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <title> @yield('title', __('Checkout')) </title>
    {{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
    <script src="{{ asset('/vendor/core/core/base/libraries/jquery.min.js')}}"></script>

    </script>

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
    </style>

    {!! Html::style('vendor/core/core/base/libraries/font-awesome/css/fontawesome.min.css') !!}
    {!! Html::style('vendor/core/plugins/kyc/css/vendors.css') !!}

    {{--    @if (BaseHelper::isRtlEnabled())--}}
    {{--        {!! Html::style('vendor/core/plugins/ecommerce/css/front-theme-rtl.css?v=3.8.0') !!}--}}
    {{--    @endif--}}

    {!! Html::style('vendor/core/core/base/libraries/toastr/toastr.min.css') !!}
    {!! Html::style('vendor/core/plugins/kyc/css/app.css') !!}
    {!! Html::style('vendor/core/plugins/kyc/css/custom-rtl.css') !!}
    {!! Html::style('vendor/core/plugins/kyc/css/plugins/menu-types/horizontal-menu.css') !!}

    {!! Html::style('vendor/core/plugins/kyc/css/plugins/forms/wizard.css') !!}
    {{--    {!! Html::style('vendor/core/plugins/kyc/css/plugins/pickers/daterange/daterange.css') !!}--}}

    <style>

        .invalidalternatefile{
            border-color:#FF7588 !important;
        }
        input, button {
            border-radius: 12px !important;
        }
        a[role="menuitem"] {
            border-radius: 12px !important;
        }
        a.btn {
            border-radius: 12px !important;
        }
    </style>
</head>

@php
    Theme::addBodyAttributes([
        'class' => 'checkout-page',
    ]);
@endphp

<body style="background-color: #fff;" >
<div class="container my-0 my-md-3 my-lg-5 checkout-content-wrap">
    @yield('content')
</div>

@stack('footer')
{!! Html::script('vendor/core/core/base/libraries/toastr/toastr.min.js') !!}

{!! Html::script('vendor/core/plugins/kyc/js/vendors.min.js') !!}

{!! Html::script('vendor/core/plugins/kyc/js/ui/jquery.sticky.js') !!}

{!! Html::script('vendor/core/plugins/kyc/js/charts/jquery.sparkline.min.js') !!}

{!! Html::script('vendor/core/plugins/kyc/js/extensions/jquery.steps.min.js') !!}
{!! Html::script('vendor/core/plugins/kyc/js/forms/validation/jquery.validate.min.js') !!}
{!! Html::script('vendor/core/plugins/kyc/js/core/app-menu.js') !!}
{!! Html::script('vendor/core/plugins/kyc/js/core/app.js') !!}
{!! Html::script('vendor/core/plugins/kyc/js/scripts/customizer.js') !!}

{!! Html::script('vendor/core/plugins/kyc/js/scripts/ui/breadcrumbs-with-stats.js') !!}
{!! Html::script('vendor/core/plugins/kyc/js/scripts/forms/wizard-steps.js') !!}


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
