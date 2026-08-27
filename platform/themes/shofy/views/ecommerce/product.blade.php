@php
    Theme::set('breadcrumbStyle', 'without-title');
    Theme::layout('full-width');
    Theme::asset()->container('footer')->usePath()->add('waypoints', 'plugins/waypoints/jquery.waypoints.min.js');

    $flashSale = $product->latestFlashSales()->first();
    Theme::set('pageTitle', $product->name);
@endphp

<section class="tp-product-details-area">
    {!! apply_filters('ads_render', null, 'detail_page_before') !!}

    <div class="tp-product-details-top bb-product-detail">
        <div class="container">
            <div class="row" style="display: flex;">
                <div class="col-lg-4">
                    <div class="tp-product-details-thumb-wrapper tp-tab" style="padding-top: 100px">

                        @include(EcommerceHelper::viewPath('includes.product-gallery'), ['productImageSize' => 'medium'])
                    </div>

                </div>

                <div class="col-lg-4" style="padding: 50px">
                    <div class="tp-product-details-thumb-wrapper me-0 me-md-3 tp-tab"
                         style="width: 303px; height: 374px; border-radius: 12px; padding: 16px;">
                        <h1 class="tp-product-details-title fw-bold" style="font-size: 18px; color: #212121">
                            {{ $product->name }}
                        </h1>

                        <div style="width: 267px; height: 288px; top: 337px; left: 560px; border-radius: 0.3px;">
                            <div class="tp-product-details-inventory d-flex align-items-center mb-10">
                                @if (is_plugin_active('marketplace') && $product->store->id)
                                    <div class="tp-product-details-stock mb-10">
                                        <span><a
                                                href="{{ $product->store->url }}">{{ $product->store->name }}</a></span>
                                    </div>
                                @endif

                                @if (EcommerceHelper::isReviewEnabled() && ($product->reviews_avg || theme_option('ecommerce_hide_rating_star_when_is_zero', 'no') === 'no'))
                                    <div class="tp-product-details-rating-wrapper d-flex align-items-center mb-10">
                                        <div class="tp-product-details-rating">
                                            @include(EcommerceHelper::viewPath('includes.rating-star'), ['avg' => $product->reviews_avg])
                                        </div>
                                        <div class="tp-product-details-reviews">
                                            <a href="{{ $product->url }}#product-review"
                                               data-bb-toggle="scroll-to-review">{{ __('(:count reviews)', ['count' => number_format($product->reviews_count)]) }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @include(EcommerceHelper::viewPath('includes.product-specification-detail'))

                            <div class="tp-product-details-query">
                                <div class="tp-product-details-query-item" @style(['display: none' => ! $product->sku])>
                                    <span>{{ __('SKU:') }}</span>
                                    <span data-bb-value="product-sku">{{ $product->sku }}</span>
                                </div>
                                @if ($product->categories->isNotEmpty())
                                    <div class="tp-product-details-query-item">
                                        <span>{{ __('Category:') }}</span>
                                        @foreach($product->categories as $category)
                                            <a href="{{ $category->url }}"
                                               title="{{ $category->name }}">{{ $category->name }}</a>
                                            <span class="me-1">@if (!$loop->last)
                                                    ,
                                                @endif</span>
                                        @endforeach
                                    </div>
                                @endif
                                @if ($product->tags->isNotEmpty())
                                    <div class="tp-product-details-query-item">
                                        <span>{{ __('Tag:') }}</span>
                                        @foreach($product->tags as $tag)
                                            <a href="{{ $tag->url }}">{{ $tag->name }}</a>
                                            <span class="me-1">@if (!$loop->last)
                                                    ,
                                                @endif</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="margin-bottom: auto">
                            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-sharing'))
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="tp-product-details-wrapper has-sticky">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.product-detail'))

                        {{--                        {!! dynamic_sidebar('product_details_sidebar') !!}--}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (EcommerceHelper::isEnabledCrossSaleProducts())
        @include(Theme::getThemeNamespace('views.ecommerce.includes.cross-sale-products'))
    @endif

    <div class="tp-product-details-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="tp-product-details-tab-nav tp-tab">
{{--                        <nav>--}}
{{--                            <div class="nav nav-tabs justify-content-center p-relative tp-product-tab"--}}
{{--                                 id="navPresentationTab" role="tablist">--}}
{{--                                <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab"--}}
{{--                                        data-bs-target="#nav-description" type="button" role="tab"--}}
{{--                                        aria-controls="nav-description" aria-selected="true" style="background-color: transparent !important; color: #111111">--}}
{{--                                    {{ __('Description') }}--}}
{{--                                </button>--}}
{{--                                @if (EcommerceHelper::isProductSpecificationEnabled() && $product->specificationAttributes->where('pivot.hidden', false)->isNotEmpty())--}}
{{--                                    <button class="nav-link" id="nav-specification-tab" data-bs-toggle="tab"--}}
{{--                                            data-bs-target="#nav-specification" type="button" role="tab"--}}
{{--                                            aria-controls="nav-specification" aria-selected="false" style="background-color: transparent !important; color: #111111">--}}
{{--                                        {{ __('Product Specification') }}--}}
{{--                                        مشخصات محصول--}}
{{--                                    </button>--}}
{{--                                @endif--}}

{{--                                @if(EcommerceHelper::isReviewEnabled())--}}
{{--                                    <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab"--}}
{{--                                            data-bs-target="#nav-review" type="button" role="tab"--}}
{{--                                            aria-controls="nav-review" aria-selected="false" style="background-color: transparent !important; color: #111111">--}}
{{--                                        {{ __('Reviews (:count)', ['count' => $product->reviews_count]) }}--}}
{{--                                    </button>--}}
{{--                                @endif--}}

{{--                                @if (is_plugin_active('marketplace') && $product->store->id)--}}
{{--                                    <button class="nav-link" id="nav-vendor-tab" data-bs-toggle="tab"--}}
{{--                                            data-bs-target="#nav-vendor" type="button" role="tab"--}}
{{--                                            aria-controls="nav-store" aria-selected="false" style="background-color: transparent !important; color: #111111">--}}
{{--                                        {{ __('Vendor') }}--}}
{{--                                    </button>--}}
{{--                                @endif--}}
{{--                                @if (is_plugin_active('faq') && $product->faq_items)--}}
{{--                                    <button class="nav-link" id="nav-faq-tab" data-bs-toggle="tab"--}}
{{--                                            data-bs-target="#nav-faq" type="button" role="tab" aria-controls="nav-faq"--}}
{{--                                            aria-selected="false" style="background-color: transparent !important; color: #111111">--}}
{{--                                        {{ __('FAQs') }}--}}
{{--                                    </button>--}}
{{--                                @endif--}}
{{--                                <span id="productTabMarker" class="tp-product-details-tab-line"></span>--}}
{{--                            </div>--}}
{{--                        </nav>--}}

                        <nav>
                            <div class="nav nav-tabs tp-product-tab overflow-auto flex-nowrap"
                                 id="navPresentationTab" role="tablist" style="white-space: nowrap;">

                                <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-description" type="button" role="tab"
                                        aria-controls="nav-description" aria-selected="true">
                                    {{ __('Description') }}
                                </button>

                                @if (EcommerceHelper::isProductSpecificationEnabled() && $product->specificationAttributes->where('pivot.hidden', false)->isNotEmpty())
                                    <button class="nav-link" id="nav-specification-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-specification" type="button" role="tab"
                                            aria-controls="nav-specification" aria-selected="false">
                                        مشخصات محصول
                                    </button>
                                @endif

                                @if(EcommerceHelper::isReviewEnabled())
                                    <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-review" type="button" role="tab"
                                            aria-controls="nav-review" aria-selected="false">
                                        {{ __('Reviews (:count)', ['count' => $product->reviews_count]) }}
                                    </button>
                                @endif

                                @if (is_plugin_active('marketplace') && $product->store->id)
                                    <button class="nav-link" id="nav-vendor-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-vendor" type="button" role="tab"
                                            aria-controls="nav-store" aria-selected="false">
                                        {{ __('Vendor') }}
                                    </button>
                                @endif

                                @if (is_plugin_active('faq') && $product->faq_items)
                                    <button class="nav-link" id="nav-faq-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-faq" type="button" role="tab"
                                            aria-controls="nav-faq" aria-selected="false">
                                        {{ __('FAQs') }}
                                    </button>
                                @endif

                                <span id="productTabMarker" class="tp-product-details-tab-line"></span>
                            </div>
                        </nav>
                        <style>
                            .tp-product-tab {
                                display: flex;
                                overflow-x: auto;
                                flex-wrap: nowrap;
                                scrollbar-width: thin;
                            }

                            .tp-product-tab::-webkit-scrollbar {
                                height: 4px;
                            }

                            .tp-product-tab::-webkit-scrollbar-thumb {
                                background: #ccc;
                                border-radius: 4px;
                            }

                            .tp-product-tab .nav-link {
                                white-space: nowrap;
                                flex-shrink: 0;
                            }

                        </style>

                        <div class="tab-content" id="navPresentationTabContent">
                            <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                                 aria-labelledby="nav-description-tab" tabindex="0">
                                <div class="tp-product-details-desc-wrapper">
                                    <div class="ck-content" style="font-size: 18px; color: #212121">
                                        {!! BaseHelper::clean($product->content) !!}
                                    </div>

                                    {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $product) !!}
                                </div>
                            </div>
                            @if (EcommerceHelper::isProductSpecificationEnabled() && $product->specificationAttributes->where('pivot.hidden', false)->isNotEmpty())
                                <div class="tab-pane fade" id="nav-specification" role="tabpanel"
                                     aria-labelledby="nav-specification-tab" tabindex="0">
                                    <div class="tp-product-details-additional-info">
                                        @include(EcommerceHelper::viewPath('includes.product-specification'))
                                    </div>
                                </div>
                            @endif
                            @if (EcommerceHelper::isReviewEnabled())
                                <div class="tab-pane fade" id="nav-review" role="tabpanel"
                                     aria-labelledby="nav-review-tab" tabindex="0">
                                    <div class="tp-product-details-review-wrapper pt-60" id="product-review">
                                        @include(EcommerceHelper::viewPath('includes.reviews'))
                                    </div>
                                </div>
                            @endif
                            @if (is_plugin_active('marketplace') && $product->store->id)
                                <div class="tab-pane fade" id="nav-vendor" role="tabpanel"
                                     aria-labelledby="nav-vendor-tab" tabindex="0">
                                    <div class="pt-60">
                                        @include(Theme::getThemeNamespace('views.marketplace.includes.vendor-info'), [
                                            'store' => $product->store,
                                        ])
                                    </div>
                                </div>
                            @endif

                            @if (is_plugin_active('faq') && $product->faq_items)
                                <div class="tab-pane fade" id="nav-faq" role="tabpanel" aria-labelledby="nav-faq-tab"
                                     tabindex="0">
                                    <div class="pt-60">
                                        @include(EcommerceHelper::viewPath('includes.product-faqs'), ['faqs' => $product->faq_items])
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tp-product-details-sticky-actions">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <div class="sticky-actions-img">
                        {{ RvMedia::image($product->image, $product->name) }}
                    </div>
                    <div class="sticky-actions-content">
                        <h4 class="fs-6 mb-1  fw-bold">{{ $product->name }}</h4>
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.product.style-1.price'))
                    </div>
                </div>
                @php
                    $isOutOfStock = $product->isOutOfStock();
                @endphp
                <div class="sticky-actions-button d-flex align-items-center gap-2">
                    <button
                        type="submit"
                        name="add-to-cart"
                        @class(['tp-product-details-add-to-cart-btn', 'btn-disabled' => $isOutOfStock])
                        @disabled($isOutOfStock)
                        {!! EcommerceHelper::jsAttributes('add-to-cart-in-form', $product) !!}
                    >
                        {{ __('Add To Cart') }}
                    </button>
                    @if (EcommerceHelper::isQuickBuyButtonEnabled())
                        <button
                            type="submit"
                            name="checkout"
                            @class(['tp-product-details-buy-now-btn', 'btn-disabled' => $isOutOfStock])
                            @disabled($isOutOfStock)
                        >{{ __('Buy Now') }}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! apply_filters('ads_render', null, 'detail_page_after') !!}
</section>

@if (EcommerceHelper::isEnabledRelatedProducts())
    @include(Theme::getThemeNamespace('views.ecommerce.includes.related-products'))
@endif
