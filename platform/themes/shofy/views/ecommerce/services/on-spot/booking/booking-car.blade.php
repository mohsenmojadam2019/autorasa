@php
    Theme::layout('full-width');
    use Carbon\Carbon;
    use Morilog\Jalali\Jalalian;
@endphp


<style>
    body {
        font-family: 'IRANSansXVF', sans-serif;
    }

    .input-wrapper {
        position: relative;
        width: 100%;
    }

    .input-wrapper input {
        padding-left: 40px;
        width: 100%;
    }

    .input-wrapper #edit-icon {
        position: absolute;
        top: 70%;
        left: 15px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    /* استایل input */
    .custom-input-style {
        width: 100%;
        height: 56px;
        border-radius: 12px;
        border: 1px solid #B8B8B8;
        padding: 10px;
        font-size: 16px;
        background-color: #fff;
        transition: 0.3s;
    }

    /* استایل select */
    .custom-select-style {
        width: 100%;
        height: 56px;
        border-radius: 12px;
        border: 1px solid #B8B8B8;
        padding: 10px 40px 10px 10px;
        font-size: 16px;
        background-color: #fff;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg fill="%23666" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px;
        text-align: center;
        transition: 0.3s;
    }

    /* استایل فوکوس input و select */
    select:focus, input:focus {
        border-color: #314088;
        outline: none;
        box-shadow: 0 0 5px rgba(49, 64, 136, 0.5);
    }

    /* دکمه */
    #confirm-btn {
        font-family: 'IRANSansXVF', sans-serif;
        font-weight: 600;
        width: 100%;
        height: 40px;
        border-radius: 12px !important;
        background: #314088;
        padding: 10px;
        font-size: 16px;
        color: #fff;
        border: none;
        transition: 0.3s;
    }

    /* افکت هاور دکمه ثبت آدرس */
    #confirm-btn:hover {
        background-color: #222f6b;
    }

    /* موبایل ریسپانسیو */
    @media (max-width: 576px) {
        .custom-input-style,
        .custom-select-style,
        button {
            width: 100%;
        }
    }
</style>


<section class="tp-cart-area pb-120">
    <div class="container">
        <div class="text-center mt-5">
            <h3>رزرو نوبت</h3>
        </div>


        <div class="row justify-content-center mt-4">
            <form id="address-form"
                  action="{{ route('public.checkout.submit-booking-car', ['token' => request()->route('token')]) }}"
                  method="POST" class="col-md-6" style="direction: rtl;">
                @csrf

                <!-- آدرس کامل -->
                <div class="mb-3 input-wrapper text-center">
{{--                    <label for="full_address" class="form-label">آدرس کامل</label>--}}
                    <input type="text" id="full_address" name="full_address" class="form-control custom-input-style" value="" readonly>

                    <span id="edit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#555" viewBox="0 0 24 24">
                            <path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/>
                        </svg>
                    </span>
                </div>

                <!-- انتخاب روز -->
                <div class="mb-3 text-center">
                    <h5 class="form-label-title mb-2">انتخاب روز</h5>
                    <select name="booking_date" id="weekday" class="form-select custom-select-style" required>
                        <option value="">انتخاب کنید</option>
                        @foreach(range(1, 7) as $i)
                            @php
                                $date = Carbon::now()->addDays($i);
                                $jalali = Jalalian::fromCarbon($date);
                                $label = $jalali->format('%A - Y/m/d');
                            @endphp
                            <option value="{{ $jalali->toCarbon()->toDateString() }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- انتخاب ساعت -->
                <div class="mb-3 text-center">
                    <h5 class="form-label-title mb-2">انتخاب ساعت</h5>
                    <select name="booking_time" id="hour" class="form-select custom-select-style" required>
                        <option value="">انتخاب کنید</option>
                        @foreach(range(8, 17) as $hour)
                            <option value="{{ $hour }}">{{ $hour }}:00</option>
                        @endforeach
                    </select>
                </div>

                <!-- دکمه ثبت -->
                <div class="text-center mt-4">
                    <button type="submit" id="confirm-btn" class="btn btn-primary mt-5">
                        ثبت رزرو
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fullAddressField = document.getElementById('full_address');
        const editIcon = document.getElementById('edit-icon');
        const confirmBtn = document.getElementById('confirm-btn');
        const weekdaySelect = document.getElementById('weekday');
        const hourSelect = document.getElementById('hour');

        const province = localStorage.getItem('selectedProvince');
        const city = localStorage.getItem('selectedCity');
        const area = localStorage.getItem('selectedArea');
        const address = localStorage.getItem('selectedAddress');

        if (province && city && area && address) {
            fullAddressField.value = `${province} - ${city} - ${area} - ${address}`;
        }

        // اگر روز و ساعت قبلا ذخیره شده باشه، نمایش بدیم
        const savedWeekday = localStorage.getItem('selectedWeekday');
        const savedHour = localStorage.getItem('selectedHour');

        if (savedWeekday) {
            weekdaySelect.value = savedWeekday;
        }

        if (savedHour) {
            hourSelect.value = savedHour;
        }

        // هنگام تغییر انتخاب روز یا ساعت، آنها را ذخیره می‌کنیم
        weekdaySelect.addEventListener('change', function() {
            localStorage.setItem('selectedWeekday', weekdaySelect.value);
        });

        hourSelect.addEventListener('change', function() {
            localStorage.setItem('selectedHour', hourSelect.value);
        });

        editIcon.addEventListener('click', function () {
            window.location.href = "{{ route('public.checkout.select-car', session('tracked_start_checkout')) }}";
        });
    });
</script>
