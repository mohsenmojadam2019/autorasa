<div class="d-flex w-100 gap-2">
    <input
        class="form-control coupon-code"
        name="coupon_code"
        type="text"
        value="{{ old('coupon_code') }}"
        placeholder="{{ __('Enter coupon code...') }}"
    >
    <button
        class="apply-coupon-code btn btn-primary d-flex align-items-center gap-2"
        data-url="{{ route('public.coupon.apply') }}"
        type="button"
    >
        {{ __('Apply') }}
    </button>
</div>

<div class="coupon-error-msg mt-1">
    <span class="text-danger"></span>
</div>
