<div
    @class([
        'tp-product-item-6 p-relative white-bg mb-40 p-3 rounded-4 mx-2',
        $class ?? null
    ])
    style="max-width: 358px; width: 100%; height: auto; border: 1px solid #C7C7C7;"
>
    <a href="{{ $product->url }}" class="d-block mb-3 ">
        {{ RvMedia::image($product->brand->logo, $product->brand->name, attributes: ['style' => 'height: 16px;']) }}
    </a>

    <h3 class="tp-product-title-2 text-truncate mt-2 text-start"
        style="font-size: 16px; font-weight: 700; line-height: 100%;">
        <a href="{{ $product->url }}" title="{!! $name = BaseHelper::clean($product->name) !!}"
           class="d-block" style="color:#212121 !important; ">{!! $name !!}</a>
    </h3>

    <div class="row g-3 ">
        <div class="col-7">
{{--            @dd($product)--}}
            @foreach($product->specificationAttributes->where('pivot.show_in_card', true) as $item)
                @if($item->pivot->attribute_id == 13)
                    <div>
                          <span class="d-block"
                                style="color:#212121 !important; font-weight: 700; font-size: 16px; line-height: 100%; width: 96px; height: 27px; margin-top: 20px">
                                   {{ $item->pivot->value ??null }}
                          </span>
                    </div>
                @endif
            @endforeach

            {{----}}
            <div @class(['tp-product-price-review text-center' => theme_option('product_listing_review_style', 'default') !== 'default'])>
                @include(Theme::getThemeNamespace('views.ecommerce.includes.product.style-5.rating'))

                {{-- قیمت اصلی + درصد تخفیف کنار هم در بالا --}}
                <div class="d-flex align-items-center justify-content-center gap-1 mt-2">
                    @php
                        $discount = get_sale_percentage($product->price, $product->front_sale_price);
                        $discount = str_replace('%', '', $discount);
                        $discount = ltrim($discount, '-');
                    @endphp

                    {{-- قیمت اصلی (خط‌خورده) --}}
                    @if ($discount)
                        <span
                            style="font-weight: 700; font-size: 15px; color: #888; text-decoration: line-through red;margin-left: 30px;">
                             {{ number_format($product->price) }}

                            {{-- درصد تخفیف به صورت badge یا placeholder --}}
                       <span
                           style="
                                width: 40px;
                                background-color: {{ $discount ? '#DC3545' : 'transparent' }};
                                color: {{ $discount ? '#fff' : 'transparent' }};
                                font-size: 13px;
                                font-weight: 700;
                                border-radius: 40px;
                                padding: 2px 6px;
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                            ">
        @if ($discount)
                               ٪{{ $discount }}
                           @else
                               &nbsp;
                           @endif
    </span>
</span>

                    @else
                        <span style="display: inline-block; width: 40px; height: 30px;"></span>
                    @endif


                </div>


                {{-- قیمت نهایی (با تخفیف) در پایین --}}
                <div class="mt-2">
                        <span style="font-weight: 700; font-size: 15px;padding-right: 20px">
                            {{ $product->price()->displayAsText() }}
                        </span>
                </div>
            </div>

            {{----}}
        </div>

        <div class="tp-product-thumb-5 w-img fix col-5 text-center"
             style="border: 0;border-right: 1px solid #C7C7C7;border-radius: unset;">
            <a href="{{ $product->url }}" style="position: relative; display: inline-block;">
                {!! RvMedia::image($product->image, $product->name, $style === 2 ? 'thumb' : 'medium', true, [
                    'class' => 'img-fluid',
                    'style' => 'width: 93px; height: 93px; object-fit: cover;'
                ]) !!}

                <span style="
                            position: absolute;
                            width: 40px;
                            height: 20px;
                            top: 100px; /* پایین‌تر از وسط تصویر 113px */
                            left: 10px;
                            border-radius: 73px;
                            background-color: #ccc;
                            font-weight: 700;
                            font-size: 13px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">
                             {{$item->pivot->value ??null}}
                  </span>
            </a>


            @include(Theme::getThemeNamespace('views.ecommerce.includes.product.badges'))
            @include(Theme::getThemeNamespace('views.ecommerce.includes.product.style-5.actions'))
        </div>
    </div>

    <div class="tp-product-content-5 mt-3">
        {!! apply_filters('ecommerce_before_product_item_content_renderer', null, $product) !!}

        @if (is_plugin_active('marketplace') && $product->store->getKey())
            <div class="tp-product-tag-5 text-center mb-2">
                <span><a href="{{ $product->store->url }}" class="fw-bold">{{ $product->store->name }}</a></span>
            </div>
        @endif

        @if (EcommerceHelper::isCartEnabled())
            <div class="d-flex justify-content-center mt-3">
                <button
                    type="button" class="btn w-100"
                    style="border-radius: 12px !important; background-color: #314088; color:white;"
                    @if($hasVariations = $product->variations->isNotEmpty())
                        data-bb-toggle="quick-shop"
                    data-url="{{ route('public.ajax.quick-shop', $product->slug) }}"
                    @else
                        data-bb-toggle="add-to-cart"
                    data-show-toast-on-success="false"
                    data-url="{{ route('public.cart.add-to-cart') }}"
                    data-id="{{ $product->original_product->id }}"
                    {!! EcommerceHelper::jsAttributes('add-to-cart', $product) !!}
                    @endif
                >
                    @if ($hasVariations)
                        {{ __('Select Options') }}
                    @else
                        {{ __('Add To Cart') }}
                    @endif
                </button>
            </div>
        @endif

        {!! apply_filters('ecommerce_after_product_item_content_renderer', null, $product) !!}
    </div>
</div>
