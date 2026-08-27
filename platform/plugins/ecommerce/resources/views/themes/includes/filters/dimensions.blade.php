{{--@dd($dimensions)--}}
@if ($dimensions->isNotEmpty())
{{--    @dd(2)--}}
    <div class="bb-product-filter">
        <h4 class="bb-product-filter-title" style="font-size: 18px; color: #212121">{{ __('Dimensions') }}</h4>

        <div class="bb-product-filter-content">
            <ul class="bb-product-filter-items filter-checkbox">
                @foreach ($dimensions as $dimension)
                    <li class="bb-product-filter-item">
                        <input id="attribute-brand-{{ $dimension->id }}" type="checkbox" name="dimensions[]" value="{{ $dimension->id }}" @checked(in_array($dimension->id, (array)request()->input('dimensions', []))) />
                        <label for="attribute-brand-{{ $dimension->id }}">{{ $dimension->name }}</label>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
