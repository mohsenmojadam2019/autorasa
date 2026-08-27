@if(! isset($shortcode))
    @include(Theme::getThemeNamespace('views.ecommerce.includes.filters.results'))
@endif

@if($products->isNotEmpty())
    @php
        $products->loadMissing(['brand']);
    @endphp

    @if ($layout ?? get_product_layout() === 'grid')
        @php
            $itemsPerRow ??= get_products_per_row_by_layout();
            $itemsPerRowOnMobile = theme_option('ecommerce_products_per_row_mobile', 2);
            $colmdClass=12/$itemsPerRow;
            $colsmClass=12/$itemsPerRowOnMobile;
        @endphp

{{--        <div class="row row-cols-xxl-{{ $itemsPerRow }} row-cols-md-{{ $itemsPerRow - 1 }} row-cols-sm-{{ $itemsPerRowOnMobile }} row-cols-{{ $itemsPerRowOnMobile }} mb-30">--}}
        <div class="container">
            <div class="row justify-content-center g-3 mb-30">
                @foreach ($products as $product)
                    <div class="col-12 col-sm-{{ $colsmClass }} col-md-{{ $colmdClass }}">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item'), ['layout' => 'grid'])
                    </div>
                @endforeach
            </div>
        </div>




    @else
        <div class="row mb-30">
            <div class="col-xl-12">
                @foreach ($products as $product)
                    @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item'), ['layout' => 'list'])
                @endforeach
            </div>
        </div>
    @endif
@else
    <div class="alert alert-warning rounded-0">
        <div class="d-flex align-items-center gap-2">
            <x-core::icon name="ti ti-info-circle" />
            {{ __('No products were found matching your selection.') }}
        </div>
    </div>
@endif

@if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
    {{ $products->withQueryString()->links(Theme::getThemeNamespace('partials.pagination')) }}
@endif
