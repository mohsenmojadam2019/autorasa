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
        width: 100%;
        height: 56px;
        border-radius: 12px;
        border: 1px solid #ced4da;
        padding: 10px;
        font-size: 16px;
        appearance: none;
        background-color: #fff;
    }

    .custom-select-style,
    .form-label,
    .form-control,
    button {
        font-family: 'IRANSansXVF', sans-serif;
    }

    h3 {
        font-weight: 400;
        font-size: 16px;
        line-height: 150%;
    }

    button {
        font-weight: 600;
    }

    .service-item {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 16px;
        border-radius: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .service-item:hover {
        background-color: #e2e6ea;
    }

    @media (max-width: 576px) {
        .modal-dialog {
            max-width: 100%;
            margin: 0;
        }

        .modal-content {
            border-radius: 0;
            height: 100vh;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 1rem;
        }
    }
</style>


<section class="tp-cart-area pb-120">

    <div class="container">
        <div class="text-center mt-5">
            <p>
                استان: <span id="show-province" class="fw-bold text-primary"></span> |
                شهر: <span id="show-city" class="fw-bold text-primary"></span>
            </p>
        </div>

        <div class="row justify-content-center mt-4">
            <section style="display: flex; justify-content: center; align-items: flex-start; height: 100px;">
                <h3 style="font-size: 14px; font-weight: 400; color: #404040;">
                    لطفا یکی از مراکز شهر خود را انتخاب کنید.
                </h3>
            </section>
            <form action="{{ route('submitBooking', ['token' => request()->route('token')]) }}"
                  method="POST" class="container-fluid" style="direction: rtl;">
                @csrf
                <input type="hidden" id="selected-day" name="booking_day">
                <input type="hidden" id="selected-hour" name="booking_time">

                <div class="row">
                    <div class="col-12 col-md-6 mb-4">
                        <label for="province" class="form-label">استان</label>
                        <select id="province" name="province_id" class="form-control custom-select-style w-100" required>
                            <option value="">انتخاب استان</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label for="city" class="form-label">شهر</label>
                        <select id="city" name="city_id" class="form-control custom-select-style w-100" required>
                            <option value="">ابتدا استان را انتخاب کنید</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-4">
                        <div id="service-centers-box"
                             style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 8px;">

                        </div>
                    </div>
                </div>

                {{-- دکمه ثبت نهایی (در صورت نیاز فعال شود) --}}
                {{--    <div class="row">--}}
                {{--        <div class="col-12 text-center">--}}
                {{--            <button type="submit" class="btn btn-primary mt-3 px-5 py-2" style="border-radius: 12px;">--}}
                {{--                تایید--}}
                {{--            </button>--}}
                {{--        </div>--}}
                {{--    </div>--}}
            </form>

        </div>
{{--        <div class="row justify-content-center mt-4">--}}
{{--            <div id="service-centers-box" class="col-12 col-md-10 col-lg-8"--}}
{{--                 style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 8px;"--}}
{{--            >--}}
{{--                <!-- مراکز خدمات اینجا نمایش داده می‌شوند -->--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="direction: rtl;">
                    <div class="modal-header position-relative">
                        <h5 class="modal-title w-100 text-center" id="reserveModalLabel" style="font-weight: 700; font-size: 16px;">
                            انتخاب زمان مراجعه
                        </h5>
                        <button type="button" class="btn-close position-absolute start-0 top-50 translate-middle-y ms-2"
                                data-bs-dismiss="modal" aria-label="بستن"></button>
                    </div>


                    <h5 class="modal-title text-center m-1" id="centerTitle" style="font-weight: 700;font-size: 16px;">انتخاب زمان مراجعه</h5>
                    <div class="modal-body" id="reserveModalBody">
                        <h5 class="form-label-title mb-2" style="font-weight: 400;font-size: 16px;">انتخاب روز</h5>
                        <div class="mb-3 text-center form-group">
                            <input type="number" hidden name="service_center_id">
                            <select name="booking_date" id="weekday" class="form-control w-100 custom-select-style"  required>
{{--                                <option value="">انتخاب کنید</option>--}}
                            </select>
                        </div>

                        <!-- انتخاب ساعت -->
                        <div class="mb-3 form-group">
                            <h5 class="form-label-title mb-2" style="font-weight: 400;font-size: 16px;">انتخاب ساعت</h5>
                            <select name="booking_time" id="hour" class="form-control w-100 custom-select-style" required>
                                <option value="">انتخاب کنید</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
{{--                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>--}}
                        <button type="button" class="btn" style="width:100%; border-radius:12px !important; background-color:#314088;color:#FFFFFF;" id="reservebtn">ثبت رزرو</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const timeSlotsMap = new Map();
    document.addEventListener('DOMContentLoaded', function () {
        $('#reservebtn').click(function () {
            const selectedDay = $('#weekday').val();
            const selectedHour = $('#hour').val();
            const selectedOption = $('#weekday option:selected'); // گرفتن گزینه انتخاب‌شده
            const selectedDate = selectedOption.data('date');
            const serviceCenterId=$('[name="service_center_id"]').val();
            // بررسی اینکه روز و ساعت انتخاب شده است
            if (!selectedDay || !selectedHour) {
                alert('لطفا روز و ساعت را انتخاب کنید.');
                return;
            }

            // ذخیره روز و ساعت در localStorage
            localStorage.setItem('selectedDay', selectedDay);
            localStorage.setItem('selectedHour', selectedHour);
            console.log(55,selectedDate);

            // نمایش داده‌ها در فرم اصلی
            $('#selected-day').val(selectedDay);
            $('#selected-hour').val(selectedHour);

            // بستن مدال
            $('#reserveModal').modal('hide');

            // بروزرسانی فرم با اطلاعات ذخیره شده
            const showDay = localStorage.getItem('selectedDay');
            const showHour = localStorage.getItem('selectedHour');

            // بررسی و نمایش انتخاب‌ها در فرم
            if (showDay && showHour) {
                $('#show-province').text(showDay);
                $('#show-city').text(showHour);
            } else {
                console.error('اطلاعات ذخیره‌شده پیدا نشد.');
            }

            // ارسال داده‌ها با AJAX به سرور
            $.ajax({
                url: '{{ route('public.checkout.submit-booking-autoservice', ['token' => request()->route("token")]) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // مهم: ارسال CSRF token
                    day: selectedDay,
                    booking_time: selectedHour,
                    booking_date:selectedDate,
                    service_center_id:serviceCenterId
                },
                success: function (response) {
@php
    $token = request()->route('token');
@endphp
                    window.location.href = "{{ route('public.kyc.list',['redirect'=>'public.checkout.information','token' => $token]) }}";
                    // console.log('رزرو با موفقیت انجام شد:', response);
                    // alert('رزرو شما با موفقیت ثبت شد.');
                },
                error: function (xhr, status, error) {
                    console.error('خطا در ثبت رزرو:', xhr.responseText || error);
                    alert('خطایی در ثبت رزرو رخ داد. لطفا مجدداً تلاش کنید.');
                }
            });

            console.log('رزرو ثبت شد:', { selectedDay,selectedDate, selectedHour });
        });
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const showProvince = document.getElementById('show-province');
        const showCity = document.getElementById('show-city');
        const serviceBox = document.getElementById('service-centers-box');
        const weekDaySelect = document.getElementById('weekday');

        function setLoading(select, loading = true) {
            select.innerHTML = loading
                ? '<option value="">در حال بارگذاری...</option>'
                : '<option value="">انتخاب شهر</option>';
        }

        function saveSelection(key, value) {
            value ? localStorage.setItem(key, value) : localStorage.removeItem(key);
        }

        function fetchProvinces() {
            fetch('{{ route('public.cart.provinces') }}')
                .then(res => res.json())
                .then(provinces => {
                    provinces.forEach(p => {
                        provinceSelect.appendChild(new Option(p.name, p.id));
                    });

                    const savedProvinceId = localStorage.getItem('selectedProvinceId');
                    if (savedProvinceId) {
                        provinceSelect.value = savedProvinceId;
                        showProvince.textContent = localStorage.getItem('selectedProvince') || '';
                        loadCities(savedProvinceId);
                    }
                });
        }

        function loadCities(provinceId) {
            if (!provinceId) {
                citySelect.innerHTML = '<option value="">ابتدا استان را انتخاب کنید</option>';
                return;
            }

            setLoading(citySelect);

            fetch(`/cart/cities/${provinceId}`)
                .then(res => res.json())
                .then(cities => {
                    citySelect.innerHTML = '<option value="">انتخاب شهر</option>';
                    cities.forEach(city => {
                        citySelect.appendChild(new Option(city.name, city.id));
                    });

                    const savedCityId = localStorage.getItem('selectedCityId');
                    if (savedCityId) {
                        citySelect.value = savedCityId;
                        showCity.textContent = localStorage.getItem('selectedCity') || '';
                        loadServiceCenters(savedCityId);
                    }
                });
        }

        function loadServiceCenters(cityId) {
            serviceBox.innerHTML = 'در حال بارگذاری مراکز خدمات...';
            fetch(`/cart/service-centers/${cityId}`)
                .then(res => res.json())
                .then(response => {

                    if (!response.data.autoservices.length) {
                        serviceBox.innerHTML = '<p>موردی یافت نشد.</p>';
                        return;
                    }

                    let html = '<ul class="list-group">';

                    response.data.autoservices.forEach((center, index) => {
console.log('####',center);
                        const imageUrl = center.pic ? `/storage/${center.pic}` : '/default-image.jpg';
                        const centerStr = encodeURIComponent(JSON.stringify(center)); // Encode the object
                        // const centerStr = encodeURIComponent(JSON.stringify(center)); // Encode the object
                        // html += `
                        //         <li class="list-group-item" onclick="showReserveModal(decodeURIComponent('${centerStr}'))" style="cursor: pointer;">
                        //

                        html += `
                        <div style="cursor: pointer;" onclick="showReserveModal(decodeURIComponent('${centerStr}'))">
                            <div class="card-body overflow-hidden">
                                <div class="row">
                                    <div class="col-3">
                                        <img src="${center.img_url}" alt="${center.title}" class="img-fluid rounded">
                                    </div>
                                    <div class="col-9">
                                        <h5 class="card-title" style="color:#212121; font-size:18px; font-weight:700;">${center.title}</h5>
                                        <p class="card-text text-muted" style="color:#636363; font-size:14px;">
                                            <i class="fas fa-map-marker-alt"></i> ${center.address}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                    html += '</ul>';
                    serviceBox.innerHTML = html;
                })
                .catch(err => {
                    console.error(err);
                    serviceBox.innerHTML = '<p class="text-danger">خطا در دریافت مراکز خدمات.</p>';
                });
        }



        provinceSelect.addEventListener('change', function () {
            const provinceId = this.value;
            const provinceName = this.options[this.selectedIndex].text;

            saveSelection('selectedProvince', provinceName);
            saveSelection('selectedProvinceId', provinceId);
            showProvince.textContent = provinceName;

            loadCities(provinceId);
            saveSelection('selectedCity', '');
            saveSelection('selectedCityId', '');
            showCity.textContent = '';
            serviceBox.innerHTML = '';
        });

        citySelect.addEventListener('change', function () {
            const cityId = this.value;
            const cityName = this.options[this.selectedIndex].text;

            saveSelection('selectedCity', cityName);
            saveSelection('selectedCityId', cityId);
            showCity.textContent = cityName;

            loadServiceCenters(cityId);
        });
        weekDaySelect.addEventListener('change', function () {
            const selectedDay = $(this).val();
            const timeSlots = timeSlotsMap.get(selectedDay);
            showTimeslot(timeSlots);
        });

        fetchProvinces();
    });

    function showReserveModal(centerStr) {
        var center;
        try {
            center = JSON.parse(centerStr);
        } catch (e) {
            console.error('Invalid JSON for center:', centerStr);
            return;
        }

        $('[name="service_center_id"]').val(center.id);
        $('#reserveModal').modal('show');
        $('#centerTitle').text(center.title); // یا با template literal: $('#centerTitle').text(`${center.title}`);
        showDates(center.dates, center.working_hours);
    }


    // function showDates(dates) {
    //     if (!Array.isArray(dates)) {
    //         console.error('dates is not an array:', dates);
    //         return;
    //     }
    //
    //     const today = new Date(); // تاریخ امروز
    //     const todayDay = today.getDay(); // روز هفته امروز (0 تا 6)
    //     const weekDays = ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'];
    //
    //     // تبدیل تاریخ امروز به شمسی
    //     function convertToShamsi(date) {
    //         const persianDate = new Intl.DateTimeFormat('fa-IR').format(date);
    //         return persianDate;
    //     }
    //
    //     let html = '';
    //     const resultDates = [];
    //     const timeSlotsMap = new Map(); // ذخیره ساعت‌ها برای هر روز
    //
    //     // برای هر روز دریافتی، تاریخ آن را محاسبه می‌کنیم
    //     dates.forEach(date => {
    //         const dayIndex = weekDays.indexOf(date.day);
    //
    //         if (dayIndex !== -1) {
    //             let diffDays = dayIndex - todayDay;
    //             if (diffDays < 0) {
    //                 diffDays += 7; // اگر روز مورد نظر قبل از امروز است، به هفته بعد می‌رود
    //             }
    //
    //             // محاسبه تاریخ روز مورد نظر
    //             const targetDate = new Date(today);
    //             targetDate.setDate(today.getDate() + diffDays); // اضافه کردن روزهای تفاوت به تاریخ امروز
    //
    //             // بررسی اینکه آیا تاریخ محاسبه شده در بازه یک هفته‌ای از امروز است یا خیر
    //             if (targetDate <= new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000)) {
    //                 resultDates.push({
    //                     day: date.day,
    //                     date: convertToShamsi(targetDate),
    //                     timeSlots: date.time_slots // ذخیره ساعت‌ها برای هر روز
    //                 });
    //                 timeSlotsMap.set(date.day, date.time_slots); // ذخیره ساعت‌ها در نقشه
    //             }
    //         }
    //     });
    //
    //     // نمایش روزها در منوی انتخاب
    //     resultDates.forEach(date => {
    //         html += `<option value="${date.day}">${date.day} - تاریخ: ${date.date}</option>`;
    //     });
    //
    //     $('#weekday').html(html);
    //
    //     // اضافه کردن رویداد برای تغییر روز و نمایش ساعت‌ها
    //     $('#weekday').on('change', function () {
    //         const selectedDay = $(this).val(); // روز انتخابی
    //         const timeSlots = timeSlotsMap.get(selectedDay); // دریافت ساعت‌های مربوط به روز انتخابی
    //
    //         let timeSlotHtml = '';
    //         if (timeSlots && timeSlots.length > 0) {
    //             timeSlots.forEach(slot => {
    //                 timeSlotHtml += `<option value="${slot}">${slot}</option>`;
    //             });
    //             $('#timeSlot').html(timeSlotHtml); // نمایش ساعت‌ها در منوی انتخاب ساعت
    //         } else {
    //             $('#timeSlot').html('<option>هیچ ساعتی برای این روز موجود نیست</option>');
    //         }
    //     });
    // }


    function showDates(dates, workinghours) {
        if (!Array.isArray(dates)) {
            console.error('dates is not an array:', dates);
            return;
        }


        let html = '<option value="">انتخاب روز</option>'; // گزینه پیش‌فرض

        dates.forEach(date => {
            const wh = workinghours.find(w => w.day === date.day);

            if (wh) {
                timeSlotsMap.set(date.day, wh.time_slots);
            } else {
                timeSlotsMap.set(date.day, []);
            }

            html += `<option data-date="${date.date}" value="${date.day}">${date.day} (${date.jalali_date})</option>`;
        });

        $('#weekday').html(html);
    }


    function showTimeslot(timeSlots) {
        if (!Array.isArray(timeSlots)) {
            console.error('timeSlots is not an array:', timeSlots);
            return;
        }

        let html = '';

        if (timeSlots.length === 0) {
            html = '<option value="">مرکز در این روز تعطیل است</option>';
        } else {
            html = '<option value="">انتخاب ساعت</option>'; // گزینه پیش‌فرض
            timeSlots.forEach(timeSlot => {
                html += `<option value="${intToTime(timeSlot.start_time)}">${intToTime(timeSlot.start_time)} تا ${intToTime(timeSlot.end_time)}</option>`;
            });
        }

        $('#hour').html(html);
    }

    function intToTime(hour) {
        if (typeof hour !== 'number' || hour < 1 || hour > 24) {
            console.error('Invalid hour:', hour);
            return '00:00:00';
        }

        const padded = hour.toString().padStart(2, '0');
        return `${padded}:00`;
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-jalaali/0.9.1/moment-jalaali.js"></script>
