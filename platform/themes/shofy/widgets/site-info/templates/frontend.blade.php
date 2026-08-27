<style>

    /*.tp-footer-logo-main img {*/
    /*    width: 177px;*/
    /*    height: 80px;*/
    /*    top: 162px;*/
    /*    left: 995.82px;*/
    /*}*/

    .tp-footer-logo img {
        width: 98px;
        height: 98px;
        border-radius: 8px;
        border: 1px solid #C9D9E0;
        top: 162px;
        left: 995.82px;
    }


</style>


<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 d-flex">
    <div class="tp-footer-widget  mb-50">
        <div class="tp-footer-widget-content">
            <div class="tp-footer-logo-main mb-3">
                @if ($logo = $config['logo'] ?: theme_option('logo'))
                    <a href="{{ BaseHelper::getHomepageUrl() }}">
                        {{ RvMedia::image($logo, theme_option('site_title'), attributes: $attributes) }}
                    </a>
                @endif
            </div>

            <p class="tp-footer-desc" style="width: 175px;font-weight: 700;
               height: 24px;
               top: 56px;
               left: 995.82px;
            ">{{ $config['about'] }}</p>

            <p class="tp-footer-desc "
               style="
               color: #636363;
               height: 50px;
               top: 96px;
               font-weight:500;
               font-size: 16px
            ">{{ $config['description'] }}</p>


            <div class="tp-footer-logo">


                @if (($url = $config['url_1']) && $url !== '#' && $url !== '')
                    <a href="{{ $url }}" target="_blank">
                        {{ RvMedia::image($config['image_1'], 'footer image') }}
                    </a>
                @else
                    {{ RvMedia::image($config['image_1'], 'footer image') }}
                @endif


{{--                @if (($url = $config['url_2']) && $url !== '#' && $url !== '')--}}
{{--                    <a href="{{ $url }}" target="_blank">--}}
{{--                        <div>--}}
{{--                            {{ RvMedia::image($config['image_2'], 'footer image' ) }}</div>--}}
{{--                    </a>--}}
{{--                @else--}}
{{--                    {{ RvMedia::image($config['image_2'], 'footer image')}}--}}
{{--                @endif--}}
            </div>

            {{--social--}}
            {{--            @if($config['show_social_links'] && $socialLinks = Theme::getSocialLinks())--}}
            {{--                <div class="tp-footer-social">--}}
            {{--                    @foreach($socialLinks as $socialLink)--}}
            {{--                        @continue(! $socialLink->getUrl() || ! $socialLink->getIconHtml())--}}

            {{--                        <a {!! $socialLink->getAttributes() !!}>{{ $socialLink->getIconHtml() }}</a>--}}
            {{--                    @endforeach--}}
            {{--                </div>--}}
            {{--            @endif--}}
        </div>
    </div>
</div>
