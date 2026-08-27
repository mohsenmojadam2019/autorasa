@php
    $dataForFilter = EcommerceHelper::dataForFilter($category ?? null);
    [$categories, $brands,
    $dimensions,
     $tags, $rand, $categoriesRequest, $urlCurrent, $categoryId, $maxFilterPrice] = $dataForFilter;

    $brands = $brands->whereIn('id', request()->input('brands', []));
    $dimensions = $dimensions->whereIn('id', request()->input('dimensions', []));
    $tags = $tags->whereIn('id', request()->input('tags', []));
    $categories = $categories->whereIn('id', request()->input('categories', []));

    $attributeSets = app(\Botble\Ecommerce\Supports\RenderProductAttributeSetsOnSearchPageSupport::class)->getAttributeSets();
@endphp

@if($brands->isNotEmpty()
 || $dimensions->isNotEmpty()
||$tags->isNotEmpty() || request()->input('attributes', []))
    <div class="bb-product-filter-result">
        <style>
            @media (min-width: 768px) {
                #filterToggleBtn {
                    display: none;
                }
            }
        </style>

        <button id="filterToggleBtn"  data-bb-toggle="toggle-filter-sidebar" class="custom-filter-button" style="border: 1px #0b0b0b; width: 90px;height: 40px;position: relative;border-radius: 4px;background-color: white;cursor: pointer;">
            فیلتر
        </button>


        @foreach($brands as $brand)
            <a href="{{ request()->fullUrlWithQuery([...request()->except('brands'), 'brands' => array_diff(request()->input('brands', []), [$brand->id])]) }}"
               class="bb-product-filter-clear">
                <x-core::icon name="ti ti-x"/>
                {{ $brand->name }}
            </a>
        @endforeach
{{--dimensions--}}
        @foreach($dimensions as $dimension)
            <a href="{{ request()->fullUrlWithQuery([...request()->except('dimensions'), 'dimensions' => array_diff(request()->input('dimensions', []), [$dimension->id])]) }}"
               class="bb-product-filter-clear">
                <x-core::icon name="ti ti-x"/>
                {{ $dimension->name }}
            </a>
        @endforeach


        @foreach($tags as $tag)
            <a href="{{ request()->fullUrlWithQuery([...request()->except('tags'), 'tags' => array_diff(request()->input('tags', []), [$tag->id])]) }}"
               class="bb-product-filter-clear">
                <x-core::icon name="ti ti-x"/>
                {{ $tag->name }}
            </a>
        @endforeach

        @foreach($attributeSets as $attributeSet)
            @foreach((array) request()->input('attributes', []) as $slug => $values)
                @continue($slug !== $attributeSet->slug || ! is_array($values) || empty($values))
                @foreach($values as $value)
                    @php
                        $attribute = $attributeSet->attributes->where('id', $value)->first();
                    @endphp

                    @if($attribute)
                        <a href="{{ request()->fullUrlWithQuery([...request()->except('attributes'), "attributes[{$slug}]" => array_diff(request()->input("attributes.{$slug}", []), [$value])]) }}"
                           class="bb-product-filter-clear">
                            <x-core::icon name="ti ti-x"/>
                            <span>{{ $attributeSet->title }}:</span> {{ $attribute->title }}
                        </a>
                    @endif
                @endforeach
            @endforeach
        @endforeach

        <a href="{{ request()->url() }}" class="bb-product-filter-clear-all">
            <x-core::icon name="ti ti-x"/>
            {{ __('Clear all') }}
        </a>
    </div>
@endif
