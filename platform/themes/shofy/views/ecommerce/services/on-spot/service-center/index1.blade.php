@php
    Theme::layout('full-width');
    $token = request()->route('token');
@endphp

@push('styles')
    <style>
        .custom-button {
            width: 338px;
            height: 40px;
            border-radius: 12px;
            background-color: #314088;
            color: white;
            border: none;
            font-size: 16px;
        }

        .custom-button:hover {
            background-color: #2a3e6a;
        }

        select.form-control {
            font-size: medium;
            background-color: transparent;
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
            appearance: none;
        }

        select.form-control:focus {
            outline: none;
            border-color: #314088;
        }

        select.form-control:disabled {
            background-color: #f0f0f0;
            border-color: #d3d3d3;
            cursor: not-allowed;
        }
    </style>
@endpush

<section class="tp-cart-area pb-120">
    <div class="container">
        <h2>انتخاب مرکز خدمات</h2>
        <form id="service-form" action="{{ route('public.checkout.service-center.submit', ['token' => $token]) }}" method="POST">
            @csrf
            <div class="row">
                <!-- استان -->
                <div class="col-12 col-md-4 form-group">
                    <label for="province-select">استان</label>
                    <select id="province-select" name="province_id" class="form-control">
                        <option value="">استان را انتخاب کنید</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- شهر -->
                <div class="col-12 col-md-4 form-group">
                    <label for="city-select">شهر</label>
                    <select id="city-select" name="city_id" class="form-control">
                        <option value="">شهر را انتخاب کنید</option>
                    </select>
                </div>

                <!-- منطقه -->
                <div class="col-12 col-md-4 form-group">
                    <label for="area-select">منطقه</label>
                    <select id="area-select" name="area" class="form-control">
                        <option value="">منطقه را انتخاب کنید</option>
                    </select>
                </div>
            </div>

            <!-- مراکز خدمات -->
            <div class="form-group">
                <label>مرکز خدمات</label>
                <div id="service-centers-container" class="row"></div>
            </div>

            <!-- فیلدهای مخفی برای اطلاعات انتخاب‌شده -->
            <input type="hidden" name="selected_center_id" id="selected_center_id">
            <input type="hidden" name="selected_working_day" id="selected_working_day">
            <input type="hidden" name="selected_working_hour" id="selected_working_hour">

            <!-- دکمه تایید -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary custom-button">تایید</button>
            </div>
        </form>
    </div>
</section>

<!-- مدال ساعت کاری -->
<div id="working-hours-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">انتخاب ساعت کاری</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <label for="working-days">روزهای کاری</label>
                <select id="working-days" class="form-control"></select>

                <label for="working-hours">ساعات کاری</label>
                <select id="working-hours" class="form-control"></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                <button type="button" class="btn btn-primary" id="save-working-hours">ذخیره</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            var token = '{{ $token }}';
            var selectedCenterId = null;

            $('#province-select').change(function () {
                $.get(`/checkout/${token}/service-center/cities/${$(this).val()}`, function (data) {
                    $('#city-select').empty().append('<option value="">شهر را انتخاب کنید</option>');
                    $.each(data.cities, (i, city) => {
                        $('#city-select').append(`<option value="${city.id}">${city.name}</option>`);
                    });
                });
            });

            $('#city-select').change(function () {
                $.get(`/checkout/${token}/service-center/areas/${$(this).val()}`, function (data) {
                    $('#area-select').empty().append('<option value="">منطقه را انتخاب کنید</option>');
                    $.each(data.areas, (i, area) => {
                        $('#area-select').append(`<option value="${area.id}">${area.name}</option>`);
                    });
                });
            });

            $('#area-select').change(function () {
                $.get(`/checkout/${token}/service-center/filter`, { area_id: $(this).val() }, function (data) {
                    let container = $('#service-centers-container');
                    container.empty();
                    if (data.service_centers.length > 0) {
                        data.service_centers.forEach(center => {
                            container.append(`
                            <div class="col-md-4">
                                <div class="card mb-3 service-center-card" data-id="${center.id}">
                                    <div class="card-body">
                                        <h5 class="card-title">${center.name}</h5>
                                        <p>آدرس: ${center.address ?? '---'}</p>
                                        <button type="button" class="btn btn-info btn-block select-working-hours-btn" data-id="${center.id}">
                                            انتخاب روز و ساعت
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `);
                        });
                    } else {
                        container.html('<p class="text-danger">هیچ مرکز خدماتی یافت نشد.</p>');
                    }
                });
            });

            // انتخاب مرکز و باز کردن مدال
            $(document).on('click', '.select-working-hours-btn', function () {
                selectedCenterId = $(this).data('id');
                $('#selected_center_id').val(selectedCenterId);
                $.get(`/checkout/${token}/service-center/working-hours/${selectedCenterId}`, function (data) {
                    $('#working-days').empty().append('<option value="">انتخاب روز کاری</option>');
                    $.each(data.working_days, (i, day) => {
                        $('#working-days').append(`<option value="${day}">${day}</option>`);
                    });

                    $('#working-days').off('change').on('change', function () {
                        const selectedDay = $(this).val();
                        $('#working-hours').empty().append('<option value="">انتخاب ساعت کاری</option>');
                        if (selectedDay) {
                            data.working_hours[selectedDay]?.forEach(hour => {
                                $('#working-hours').append(`<option value="${hour.id}">${hour.start_time} - ${hour.end_time}</option>`);
                            });
                        }
                    });

                    $('#working-hours-modal').modal('show');
                });
            });

            $('#save-working-hours').click(function () {
                const day = $('#working-days').val();
                const hour = $('#working-hours').val();
                if (day && hour && selectedCenterId) {
                    $('#selected_working_day').val(day);
                    $('#selected_working_hour').val(hour);
                    $('#selected_center_id').val(selectedCenterId);

                    localStorage.setItem('selected_day', day);
                    localStorage.setItem('selected_hour', hour);
                    localStorage.setItem('selected_center_id', selectedCenterId);

                    $('#working-hours-modal').modal('hide');
                } else {
                    alert('لطفاً مرکز خدمات، روز و ساعت را انتخاب کنید.');
                }
            });
        });
    </script>
@endpush
