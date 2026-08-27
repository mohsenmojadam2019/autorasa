@if (Cart::instance('cart')->isNotEmpty() && Cart::instance('cart')->products()->count())
    <div id="checkoutwarning" class="text-danger">

    </div>
    <div class="cartmini__checkout">
        <div class="d-flex flex-column gap-2 cartmini__checkout-title mb-30">
            <div>
                <h4 style="color: #212121;">{{ __('Subtotal:') }}</h4>
                <span style="color: #212121;">{{ format_price(Cart::instance('cart')->rawSubTotal()) }}</span>
            </div>
            @if (EcommerceHelper::isTaxEnabled())
                <div>
                    <h4 style="color: #212121;">{{ __('Tax:') }}</h4>
                    <span style="color: #212121;">{{ format_price(Cart::instance('cart')->rawTax()) }}</span>
                </div>
                <div>
                    <h4 style="color: #212121;">{{ __('Total:') }}</h4>
                    <span style="color: #212121;">{{ format_price(Cart::instance('cart')->rawSubTotal() + Cart::instance('cart')->rawTax()) }}</span>
                </div>
            @endif
        </div>

        <div class="cartmini__checkout-btn">
            @if (session('tracked_start_checkout'))
{{--                <a  id="checkout-link" class="mb-10 tp-btn w-100">--}}
{{--                    {{ __('Checkout') }}--}}
{{--                </a>--}}
            @endif
                @php
                    $qoutaProducts=0;
                    foreach (Cart::instance('cart')->products() as $productItem){
                        if ($productItem->has_qouta>0)
                            $qoutaProducts+=$productItem->cartItem->qty;
                    }

                @endphp
{{--                <button class="btn btn-link" id="checkout-button">--}}
{{--                    {{ $qoutaProducts }}--}}
{{--                </button>--}}

            <a href="{{ route('public.cart') }}" class="tp-cart-checkout-btn w-100 my-button" >
                {{ __('View Cart') }}
            </a>

{{--            @dd($qoutaProducts)--}}
{{--                href="{{ route('public.checkout.information', session('tracked_start_checkout')) }}"--}}
        </div>
    </div>
    <script>
        {{--document.getElementById('checkout-button').addEventListener('click', function() {--}}
        {{--    @if (session('tracked_start_checkout'))--}}
        {{--        window.location.href = "{{ route('public.checkout.information', session('tracked_start_checkout')) }}";--}}
        {{--    @endif--}}
        {{--});--}}
        {{--document.getElementById('checkout-link').addEventListener('click', function() {--}}
        {{--    var trackedStartCheckout = "{{ session('tracked_start_checkout') }}";--}}
        {{--    var maxQouta = "{{ max_qouta() }}";--}}
        {{--    var remainQouta = "{{ remain_qouta(\auth()->guard('customer')->id()) }}";--}}
        {{--    var qoutaProducts = "{{ $qoutaProducts }}";--}}

        {{--    if (trackedStartCheckout && remainQouta >= qoutaProducts) {--}}
        {{--        window.location.href = "{{ route('public.checkout.information', session('tracked_start_checkout')) }}";--}}
        {{--    } else if (trackedStartCheckout) {--}}
        {{--        document.getElementById('checkoutwarning').innerText = "سهمیه سالانه باقیمانده استفاده از لاستیک های دولتی برای شما " + remainQouta+" است. لطفا تعداد سفارش لاستیک های سهمیه ای را کاهش دهید.";--}}
        {{--    }--}}
        {{--});--}}
    </script>
    <style>
        .my-button {
            border-radius: 12px;
            background-color: #314088 !important;
        }

        .my-button:hover {
            background-color: #212121 !important;
        }
    </style>
@endif

