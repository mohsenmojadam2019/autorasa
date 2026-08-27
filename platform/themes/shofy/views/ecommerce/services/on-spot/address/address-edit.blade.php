@php
    Theme::layout('full-width');
@endphp

<section class="tp-cart-area pb-120">
    <div class="container">
        <div class="text-center mt-5">
            <h3>ویرایش آدرس</h3>
            <p>استان <span id="show-province" class="fw-bold text-primary"></span> | شهر: <span id="show-city" class="fw-bold text-primary"></span></p>
        </div>


        <div class="row justify-content-center mt-4">
            <form action="{{ route('address.update', ['token' => $token]) }}" method="POST" class="col-md-6" style="direction: rtl;">

                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="address" class="form-label text-start">آدرس پستی</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $userAddress->address) }}" required>
                </div>

                <div class="mb-3">
                    <label for="zip_code" class="form-label text-start">کد پستی</label>
                    <input type="text" name="zip_code" id="zip_code" class="form-control"
                           value="{{ old('zip_code', $userAddress->zip_code) }}"
                           maxlength="10" pattern="\d{10}" title="کد پستی باید دقیقاً ۱۰ رقم باشد" required>
                </div>

                <div class="mb-3">
                    <label for="order_notes" class="form-label text-start">توضیحات سفارش (اختیاری)</label>
                    <textarea name="order_notes" id="order_notes" class="form-control rounded" rows="3">{{ old('order_notes', $userAddress->order_notes) }}</textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn px-5" style="background-color: #B5B5B5; color: #fff; border: none;">
                        ویرایش آدرس
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('show-province').textContent = localStorage.getItem('selectedProvince') || '-';
        document.getElementById('show-city').textContent = localStorage.getItem('selectedCity') || '-';
    });
</script>
