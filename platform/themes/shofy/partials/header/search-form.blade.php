{{--<x-plugins-ecommerce::fronts.ajax-search class="tp-header-search">--}}
{{--    <div class="tp-header-search-wrapper d-flex align-items-center" style="border:0px !important;">--}}
{{--        <div class="tp-header-search-box" >--}}
{{--            <x-plugins-ecommerce::fronts.ajax-search.input style="border:1px solid !important; border-color:#314088 !important;" />--}}
{{--        </div>--}}
{{--        <div class="tp-header-search-btn">--}}
{{--            <button type="submit" title="{{ __('Search') }}">--}}
{{--                <x-core::icon name="ti ti-search" />--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</x-plugins-ecommerce::fronts.ajax-search>--}}

<style>
    .tp-header-search-btn .tp-search-btn {
        --tp-btn-color: var(--tp-common-white);
        width: 60px !important;
        height: 46px !important;
        line-height: 46px !important;
        background-color: var(--tp-theme-primary) !important;
        color: var(--tp-btn-color) !important;
        border-radius: 16px !important;
        border: none !important;
        padding: 0 !important;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

</style>
<x-plugins-ecommerce::fronts.ajax-search class="tp-header-search">
    <div class="tp-header-search-wrapper d-flex align-items-center" style="border:0px !important;">
        <div class="tp-header-search-box">
            <x-plugins-ecommerce::fronts.ajax-search.input style="border:1px solid !important; border-color:#314088 !important;" />
        </div>
        <div class="tp-header-search-btn">
            <button type="submit" class="tp-search-btn" title="{{ __('Search') }}">
                <x-core::icon name="ti ti-search" />
            </button>
        </div>
    </div>
</x-plugins-ecommerce::fronts.ajax-search>
