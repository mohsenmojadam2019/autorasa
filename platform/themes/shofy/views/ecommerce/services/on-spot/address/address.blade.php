@php
    Theme::layout('full-width');
@endphp
<head>
    <link href="https://cdn.fontcdn.ir/font/iransans/IRANSansXVF.css" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'IRANSansXVF', sans-serif;
    }

    .custom-select-style {
        width: 342px;
        height: 56px;
        border-radius: 12px;
        border: 1px solid #ced4da;
        padding: 10px;
        font-size: 16px;
        appearance: none;
        background-color: #fff;
    }

    .custom-select-style, .form-label, .form-control, button {
        font-family: 'IRANSansXVF', sans-serif;
    }

    h3 {
        font-family: 'IRANSansXVF', sans-serif;
        font-weight: 400;
        font-size: 16px;
        line-height: 150%;
    }

    button {
        font-family: 'IRANSansXVF', sans-serif;
        font-weight: 600;
    }
</style>


<section class="tp-cart-area pb-120">
    <div class="container">
        <div class="text-center mt-5">
            <p>
                استان: <span id="show-province" class="fw-bold text-primary"></span> |
                شهر: <span id="show-city" class="fw-bold text-primary"></span> |
                منطقه: <span id="show-area" class="fw-bold text-primary"></span>
            </p>
        </div>

        <div class="row justify-content-center mt-4">
            <section style="display: flex; justify-content: center; align-items: flex-start; height: 100px;">
                <h3 style="color:#404040; font-weight: 400; font-size: 16px; line-height: 150%; letter-spacing: 0%; text-align: right; vertical-align: middle;">
                    جهت ادامه خرید لطفا ابتدا آدرس خود را کامل کنید.
                </h3>
            </section>
            <form action="{{ route('public.checkout.submit.address', ['token' => request()->route('token')]) }}"
                  method="POST" style="direction: rtl;">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="province" class="form-label">استان</label>
                        <select id="province" name="province_id" class="form-select custom-select-style w-100" required>
                            <option value="">انتخاب استان</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="city" class="form-label">شهر</label>
                        <select id="city" name="city_id" class="form-select custom-select-style w-100" required>
                            <option value="">ابتدا استان را انتخاب کنید</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="area" class="form-label">منطقه</label>
                        <select id="area" name="area" class="form-select custom-select-style w-100" required>
                            <option value="">انتخاب منطقه</option>
                            @for($i = 1; $i <= 22; $i++)
                                <option value="{{ $i }}">منطقه {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="zip_code" class="form-label">کد پستی</label>
                        <input
                            name="zip_code"
                            id="zip_code"
                            class="form-control custom-select-style w-100"
                            maxlength="10"
                            pattern="\d{10}"
                            placeholder="کد پستی را وارد کنید"
                            required
                            style="font-size: 18px; border-radius: 8px;" />
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">آدرس پستی</label>
                        <textarea name="address" id="address" class="form-control custom-select-style w-100"
                                  placeholder="مثال: خیابان ولیعصر، کوچه ۳، پلاک ۱۲۳" rows="4" required></textarea>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit"
                                class="btn btn-primary"
                                style="width: 100%; max-width: 343px; height: 40px; border-radius: 12px !important; padding: 8px 40px; background: #314088;">
                            تایید
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const areaSelect = document.getElementById('area');
        const addressInput = document.getElementById('address');
        const zipCodeInput = document.getElementById('zip_code');
        const showProvince = document.getElementById('show-province');
        const showCity = document.getElementById('show-city');
        const showArea = document.getElementById('show-area');

        function setLoading(select, loading = true) {
            select.innerHTML = loading
                ? '<option value="">در حال بارگذاری...</option>'
                : '<option value="">انتخاب شهر</option>';
        }

        function saveSelection(key, value) {
            if (value) {
                localStorage.setItem(key, value);
            } else {
                localStorage.removeItem(key);
            }
        }

        function fetchProvinces() {
            fetch('{{ route('public.cart.provinces') }}')
                .then(response => response.json())
                .then(provinces => {
                    provinces.forEach(province => {
                        const option = new Option(province.name, province.id);
                        provinceSelect.appendChild(option);
                    });

                    const savedProvinceId = localStorage.getItem('selectedProvinceId');
                    if (savedProvinceId) {
                        provinceSelect.value = savedProvinceId;
                        showProvince.textContent = localStorage.getItem('selectedProvince') || '';
                        loadCities(savedProvinceId);
                    }
                })
                .catch(error => console.error('خطا در بارگذاری استان‌ها:', error));
        }

        function loadCities(provinceId) {
            if (!provinceId) {
                citySelect.innerHTML = '<option value="">ابتدا استان را انتخاب کنید</option>';
                return;
            }

            setLoading(citySelect);

            fetch(`/cart/cities/${provinceId}`)
                .then(response => response.json())
                .then(cities => {
                    citySelect.innerHTML = '<option value="">انتخاب شهر</option>';
                    cities.forEach(city => {
                        const option = new Option(city.name, city.id);
                        citySelect.appendChild(option);
                    });

                    const savedCityId = localStorage.getItem('selectedCityId');
                    if (savedCityId) {
                        citySelect.value = savedCityId;
                        showCity.textContent = localStorage.getItem('selectedCity') || '';
                    }
                })
                .catch(error => console.error('خطا در بارگذاری شهرها:', error));
        }

        provinceSelect.addEventListener('change', function () {
            const selectedProvinceName = this.options[this.selectedIndex].text;
            const selectedProvinceId = this.value;

            saveSelection('selectedProvince', selectedProvinceName);
            saveSelection('selectedProvinceId', selectedProvinceId);
            showProvince.textContent = selectedProvinceName;

            loadCities(selectedProvinceId);

            saveSelection('selectedCity', '');
            saveSelection('selectedCityId', '');
            showCity.textContent = '';
        });

        citySelect.addEventListener('change', function () {
            const selectedCityName = this.options[this.selectedIndex].text;
            const selectedCityId = this.value;

            saveSelection('selectedCity', selectedCityName);
            saveSelection('selectedCityId', selectedCityId);
            showCity.textContent = selectedCityName;
        });

        // ذخیره منطقه
        areaSelect.addEventListener('change', function () {
            const selectedArea = this.options[this.selectedIndex].text;
            const selectedAreaId = this.value;

            saveSelection('selectedArea', selectedArea);
            saveSelection('selectedAreaId', selectedAreaId);
            showArea.textContent = selectedArea;
        });
        zipCodeInput.addEventListener('input', function () {
            saveSelection('selectedZipCode', this.value);
        });
        // ذخیره آدرس و کد پستی در localStorage
        addressInput.addEventListener('input', function () {
            saveSelection('selectedAddress', this.value);
        });



        // بارگذاری اولیه از localStorage
        fetchProvinces();

        const savedArea = localStorage.getItem('selectedArea');
        if (savedArea) {
            areaSelect.value = localStorage.getItem('selectedAreaId'); // انتخاب منطقه ذخیره‌شده در localStorage
            showArea.textContent = savedArea;
        }

        const savedAddress = localStorage.getItem('selectedAddress');
        if (savedAddress) {
            addressInput.value = savedAddress; // نمایش آدرس ذخیره‌شده
        }

        const savedZipCode = localStorage.getItem('selectedZipCode');
        if (savedZipCode) {
            zipCodeInput.value = savedZipCode; // نمایش کد پستی ذخیره‌شده
        }
    });

</script>
