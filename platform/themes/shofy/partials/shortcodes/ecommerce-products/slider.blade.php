@php
    $slidesToShow = $shortcode->slides_to_show ?: 4;

    if ($shortcode->with_sidebar) {
        $slidesToShow = $slidesToShow - 1;
    }
@endphp

<section class="tp-product-arrival-area pt-5 pt-md-15 pb-5 pb-md-15">
    <div class="container">
        <div class="row align-items-center mb-10">
            <div class="col-6 col-md-6 col-xl-4 d-flex align-items-center px-3">
                <div class="w-100" style="font-size: 16px; line-height: 1.4;">
                {!! Theme::partial('section-title', compact('shortcode')) !!}
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-8 d-flex justify-content-end align-items-center px-3">
{{--                <div class="tp-product-arrival-more-wrapper d-flex justify-content-end ">--}}
{{--                    <div class="tp-product-arrival-arrow tp-swiper-arrow text-end tp-product-arrival-border">--}}
{{--                        <button type="button" class="tp-arrival-slider-button-prev">--}}
{{--                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M7 13L1 7L7 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                            </svg>--}}
{{--                        </button>--}}
{{--                        <button type="button" class="tp-arrival-slider-button-next">--}}
{{--                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M1 13L7 7L1 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                            </svg>--}}
{{--                        </button>--}}
                        <div class="tp-blog-more-wrapper d-flex justify-content-md-end " >
                            <div class="tp-blog-more text-end m-0 p-0" style="background-color: #f9f9f9 !important; font-size: 16px; line-height: 1.4;">
                                <a href="{{ route('public.products') }}" style="text-decoration: none; color:#314089;" >
{{--                                    {{ trans('plugins/ecommerce::products.view_all') }}--}}
                                    مشاهده همه
                                    <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 6.99976L1 6.99976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.9502 0.975414L16.0002 6.99941L9.9502 13.0244" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
{{--                                <span class="tp-blog-more-border"></span>--}}
                            </div>
                        </div>
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>

        @if($shortcode->with_sidebar)
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    @include(Theme::getThemeNamespace('partials.shortcodes.ecommerce-products.partials.sidebar'))
                </div>
                <div class="col-xl-8 col-lg-7">
                    @endif

                    <div class="row">
                        <div class="col-xl-12">
{{--                            <button type="button" class="tp-arrival-slider-button-prev">--}}
{{--                                <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path d="M7 13L1 7L7 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                </svg>--}}
{{--                            </button>--}}
                            <div class="tp-product-arrival-slider fix">
                                <div class="tp-product-arrival-active swiper-container" data-items-per-view="{{ $slidesToShow }}">
                                    <div class="swiper-wrapper">
                                        @foreach($products as $product)
                                            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item'), ['class' => 'swiper-slide'])
                                        @endforeach
                                    </div>
                                </div>
                            </div>
{{--                            <button type="button" class="tp-arrival-slider-button-next">--}}
{{--                                <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path d="M1 13L7 7L1 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                </svg>--}}
{{--                            </button>--}}

                        </div>
                    </div>

                    @if($shortcode->with_sidebar)
                </div>
            </div>
        @endif
    </div>
</section>
