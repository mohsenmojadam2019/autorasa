@php
    use Botble\Ecommerce\Facades\EcommerceHelper;
    $dataForFilter = EcommerceHelper::dataForFilter($category ?? null);
//    dd($dataForFilter);

    [$categories, $brands,
    $dimensions,
     $tags, $rand, $categoriesRequest, $urlCurrent, $categoryId, $maxFilterPrice] = $dataForFilter;
@endphp

<div class="bb-shop-sidebar">
    <form action="{{ URL::current() }}" data-action="{{ route('public.products') }}" method="GET"
          class="bb-product-form-filter">
        @include(EcommerceHelper::viewPath('includes.filters.filter-hidden-fields'))

        {!! apply_filters('theme_ecommerce_products_filter_before', null, $dataForFilter) !!}

        @include(EcommerceHelper::viewPath('includes.filters.price'))

        @include(EcommerceHelper::viewPath('includes.filters.categories'))

        @if (EcommerceHelper::isEnabledFilterProductsByBrands())
            @include(EcommerceHelper::viewPath('includes.filters.brands'))
        @endif

        @if (EcommerceHelper::isEnabledFilterProductsByTags())
            @include(EcommerceHelper::viewPath('includes.filters.tags'))
        @endif

        @if (EcommerceHelper::isEnabledFilterProductsByAttributes())
            @include(EcommerceHelper::viewPath('includes.filters.attributes'))
        @endif
        {{--dimension--}}
        @if (EcommerceHelper::isEnabledFilterProductsByDimensions())
            @include(EcommerceHelper::viewPath('includes.filters.dimensions'))
        @endif



        {!! apply_filters('theme_ecommerce_products_filter_after', null, $dataForFilter) !!}
    </form>
</div>
