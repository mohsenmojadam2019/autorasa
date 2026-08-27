@if(request()->ajax() && isset($products))
    @if ($products->isNotEmpty())
        <section class="tp-related-product">
            <div class="container">
                <div class="tp-section-title-wrapper-6 text-center mb-40">
                    <h3 class="section-title tp-section-title-6"
                        style="font-size: 18px; color: #212121">{{ __('Related Products') }}</h3>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="tp-product-related-slider fix">
                            <div class="tp-product-arrival-active swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events swiper-container-rtl "
                                 data-items-per-view="4"
                            >
                                <div class="swiper-wrapper">
                                    @foreach ($products as $product)
                                        <div class="swiper-slide">
                                            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item'))
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tp-related-swiper-scrollbar tp-swiper-scrollbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@else
    <div data-bb-toggle="block-lazy-loading" data-url="{{ route('public.ajax.related-products', $product) }}"
         class="position-relative" style="min-height: 14rem">
        <div class="loading-spinner"></div>
    </div>
@endif
