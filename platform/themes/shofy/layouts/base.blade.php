<!doctype html>
<html {!! Theme::htmlAttributes() !!}>
<head>

    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="msvalidate.01" content="5F89515FE7D642F1BFE18D0A2AAB1FCD" />
    <link href="{{ Theme::asset()->url('css/custom.css') }}" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'IRANSansX';
            /*src: url('/fonts/IRANSansX-Medium.woff2') format('woff2');*/
            /*src: url('/FONT/IRANSans/IRANSansXFaNum-Light.ttf') format('truetype');*/
            src: url('/FONT/IRANSans/IRANSansXFaNum-MediumD4.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        * {
            font-family: 'IRANSansX' !important;
            .ck-content > h1,
            .ck-content > h2,
            .ck-content > h3,
            .ck-content > h4,
            .ck-content > h5 {
                color: #212121 !important;
            }
        }
    </style>

    <!-- Preconnect for faster external script load -->
{{--    <link rel="preconnect" href="https://widget-react.raychat.io">--}}
{{--    <link rel="preconnect" href="https://www.googletagmanager.com">--}}

    <!-- Google Tag Manager -->
{{--    <script defer src="https://www.googletagmanager.com/gtag/js?id=G-B794PGTLEV"></script>--}}

{{--    <script defer>--}}
{{--        window.dataLayer = window.dataLayer || [];--}}
{{--        function gtag(){dataLayer.push(arguments);}--}}
{{--        gtag('js', new Date());--}}
{{--        gtag('config', 'G-B794PGTLEV');--}}
{{--    </script>--}}



    <!-- Google Tag Manager -->


    <!-- Raychat: Load after DOM ready -->


    @php
        $xmlString = '<?xml version="1.0"?><users><user>5F89515FE7D642F1BFE18D0A2AAB1FCD</user></users>';
        $xmlUser = base64_encode($xmlString);
    @endphp
    <meta name="custom-user" content="{{ $xmlUser }}" />

    {!! Theme::partial('header-meta') !!}
    {!! Theme::header() !!}

    <style>
        input, button {
            border-radius: 12px !important;
        }
        a.btn {
            border-radius: 12px !important;
        }
    </style>


{{--    --}}
    <!-- Google Tag Manager -->
    <script defer>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MKS4T23H');</script>


</head>
<body {!! Theme::bodyAttributes() !!} style="background-color: #F9F9F9 !important;">
{!! apply_filters(THEME_FRONT_BODY, null) !!}

@yield('content')

{!! Theme::footer() !!}
{{--<script>--}}
{{--    window.RAYCHAT_TOKEN = "9748b811-1ff7-4eab-b852-716620f3d4da";--}}
{{--    document.addEventListener("DOMContentLoaded", function () {--}}
{{--        setTimeout(function () {--}}
{{--            let s = document.createElement("script");--}}
{{--            s.src = "https://widget-react.raychat.io/install/widget.js";--}}
{{--            s.async = true; // کافی است--}}
{{--            document.head.appendChild(s);--}}
{{--        }, 5000); // 5 ثانیه تأخیر--}}
{{--    });--}}
{{--</script>--}}


<script defer>
    let encodedData = document.querySelector('meta[name="custom-user"]').getAttribute('content');
    let decodedData = atob(encodedData);
    let parser = new DOMParser();
    let xmlDoc = parser.parseFromString(decodedData, "application/xml");
    // console.log(xmlDoc);
</script>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MKS4T23H"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

</body>
</html>
