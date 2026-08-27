{{--@php--}}
{{--    try {--}}
{{--        // Get the date one year ago--}}
{{--        $oneYearAgo = now()->subYear();--}}

{{--        // Fetch total quantity of products from the past year--}}
{{--        $totalQty = \Botble\Ecommerce\Models\OrderProduct::whereHas('order', function ($query) use ($oneYearAgo) {--}}
{{--            $query->where('user_id', auth()->guard('customer')->id())--}}
{{--                  ->where('ec_orders.created_at', '>=', $oneYearAgo); // Filter orders from last year till now--}}
{{--        })->sum('qty');--}}

{{--        // Ensure the total quantity doesn't return an invalid value--}}
{{--        $totalQty = is_numeric($totalQty) ? $totalQty : 0;--}}

{{--    } catch (\Exception $e) {--}}
{{--        // Log the error for debugging purposes--}}
{{--        Log::error('Error calculating total quantity for customer: ' . $e->getMessage());--}}

{{--        // Default to zero if there's an error--}}
{{--        $totalQty = 0;--}}
{{--    }--}}

{{--    // Calculate max quantity with fallbacks--}}
{{--    $maxQty = $product->maximum_order_quantity ? $product->maximum_order_quantity - $totalQty : ($product->with_storehouse_management ? $product->quantity : 1000);--}}

{{--    // Ensure maxQty is a positive number, fallback to 1 if it's less than or equal to 0--}}

{{--    // Disable input if maxQty is less than or equal to 0--}}
{{--    $isMaxQtyValid = $maxQty > 0;--}}
{{--@endphp--}}

<div class="tp-product-quantity mt-10 mb-10 d-flex align-items-center">
    @php
        $value = $cartItem->qty ?: 1;
        if (auth()->guard('customer')->check()) {
            $value = $product->has_qouta>0?remain_qouta(\auth()->guard('customer')->id()):($product->maximum_order_quantity>0?$product->maximum_order_quantity:1000);
            $cartItem->qty = $cartItem->qty > $value ? $value : $cartItem->qty;
        }
        $minimumquntity=$product->minimum_order_quantity;
        $maximumquntity=$product->maximum_order_quantity;
        if (($product->has_qouta>0) and (\auth()->guard('customer')->check()) )
            $maximumquntity=remain_qouta(\auth()->guard('customer')->id());

    @endphp
{{--@dd(1,$product->categories->contains('id', 106));--}}
    <select
        class="form-select form-select-lg me-2 cart-item-select" style="border-radius: 8px; width: 80px;height: 40px; display: inline"
        name="items[{{ $key }}][values][qty]"
        data-bb-toggle="update-cart"
    >
        @for ($i = 1; $i <= $maximumquntity; $i++)
            <option value="{{ $i }}" {{ $cartItem->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
    <span class="text-danger " style="min-width: 180px;">
        @if($product->has_qouta)

        @endif
    </span>
</div>

