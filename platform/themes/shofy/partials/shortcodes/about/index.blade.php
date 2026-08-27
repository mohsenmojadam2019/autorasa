<section class="tp-about-area pt-15 pb-120">
    <div class="container" style="background-color: #f9f9f9;">
{{--        <div class="row">--}}

            @if($shortcode->description and $shortcode->title_1)
                <div class="border-1 mt-1 w-100 col-12 p-4" style="background-color: #FFFFFF;">
                    <span style="padding:12px; font-size: 20px;font-weight: 700; line-height: 100%;">
                        {{$shortcode->title_1}}
                    </span>
                    <br>
                    <p class="justified-text">
                        {{  $shortcode->description  }}
                    </p>
                </div>
            @endif
        <div class="border-1 mt-1 col-12 position-relative bannerStepShortCode"
             style="background-color: #F7F9FA; overflow: hidden; min-height: 600px;">

            @if($shortcode->image_1 || $shortcode->image_2 || $shortcode->image_3)
                <div class="row mt-4 position-relative d-none d-md-block" id='imageboxabout' style="z-index: 2;">
                    <h4 class="text-center" style="color:#314088 !important;">
                        @if($shortcode->title_2) {{ $shortcode->title_2 }} @endif
                    </h4>
                    <div class="col-12 p-4 d-flex justify-content-center">
                        @if($shortcode->image_1)
                            <img src="{{ RvMedia::getImageUrl($shortcode->image_1) }}" alt="{{ $shortcode->title }}"
                                 class="img-fluid rounded" style="max-height: 460px; object-fit: cover;"/>
                        @endif
                    </div>
                </div>

                <div class="row mt-4 position-relative d-block d-md-none" id='imageboxabout2' style="z-index: 2;">
                    <h4 class="text-center text-primary">
                        @if($shortcode->title_2) {{ $shortcode->title_2 }} @endif
                    </h4>
                    <div class="col-12 p-4 d-flex justify-content-center">
                        @if($shortcode->image_2)
                            <img src="{{ RvMedia::getImageUrl($shortcode->image_2) }}" alt="{{ $shortcode->title }}"
                                 class="img-fluid rounded" style="max-height: 460px; object-fit: cover;"/>
                        @endif
                    </div>
                </div>
            @endif
        </div>

{{--        </div>--}}
    </div>
</section>
<style>
    .justified-text {
        text-align: justify;
        font-size: 18px;
        font-weight: 400;
        line-height: 1.8; /* معادل 180٪ */
    }
    /*#imageboxabout::before {*/
    /*    content: "";*/
    /*    position: absolute;*/
    /*    top: 10%; !* فاصله از بالا *!*/
    /*    left: 0;*/
    /*    width: 110%;*/
    /*    height: 110%; !* از ۱۰٪ تا ۹۰٪ (یعنی بین بالا و پایین ۱۰٪ فاصله هست) *!*/
    /*    background-image: url('/About-us-Pattern-Desktop.png');*/
    /*    background-size: cover; !* یا contain یا اندازه دلخواه *!*/
    /*    background-position: center top;*/
    /*    background-repeat: no-repeat;*/
    /*    z-index: -1;*/
    /*}*/
    /*#imageboxabout2::before {*/
    /*    content: "";*/
    /*    position: absolute;*/
    /*    top: 10%; !* فاصله از بالا *!*/
    /*    left: 0;*/
    /*    width: 110%;*/
    /*    height: 110%; !* از ۱۰٪ تا ۹۰٪ (یعنی بین بالا و پایین ۱۰٪ فاصله هست) *!*/
    /*    background-image: url('/About-us-pattern-left.png');*/
    /*    background-size: cover; !* یا contain یا اندازه دلخواه *!*/
    /*    background-position: center top;*/
    /*    background-repeat: no-repeat;*/
    /*    z-index: -1;*/
    /*}*/
</style>
