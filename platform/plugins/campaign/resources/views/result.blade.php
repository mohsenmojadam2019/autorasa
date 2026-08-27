
@extends('plugins/campaign::theme.master')

@section('title', SeoHelper::getTitle())
@section('content')
    <div class="container mt-4 " >
        <div class="d-flex justify-content-center text-center pb-5">
            {{ RvMedia::image(theme_option('logo_light') ?: theme_option('logo'), theme_option('site_title'), attributes: ['class' => 'logo-light', 'style' => 'height: ' . theme_option('logo_height', 35) . 'px', 'loading' => false]) }}
        </div>
        <div class="card" style="border-radius: 15px !important;">
            @if($status=='success')
            <div class="card-header p-4 justify-content-center text-center" style="border-radius: 15px !important;">
                <h2>
                    رزرو موفق
                </h2>
                <h6 >
                    نوبت شما با موفقیت ثبت شد.
                </h6>
                <h6 >
                    در زمان مراجعه به مرکز، کد رزرو را به همراه داشته باشید.
                </h6>
            </div>
            <div class="position-relative d-flex flex-column align-items-center justify-content-center text-center">
                <!-- SVG Positioned at the Top Center -->
                <div class="position-absolute start-50 translate-middle" style="top: -40px;">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="38.5" fill="#20C997" stroke="#79DFC1" stroke-width="3"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M60.1396 27.3134L37.2114 55.9816L19.2002 40.9705L22.5985 36.8925L36.4468 48.4309L55.9979 24L60.1396 27.3134V27.3134Z"
                              fill="white"/>
                    </svg>
                </div>

                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center border border-2 border-gray-500 rounded-3"
                     style="width: 325px; margin: auto; border-radius: 1rem !important; padding-top: 50px;">
                    <h5 class="card-title" style="color:black !important;">{{ $reserve->operator->title }}</h5>
                    <p class="card-text text-muted mb-1 text-gray-900-fg">{{ $reserve->operator->city }} {{ $reserve->operator->address }}</p>
                    <p class="card-text text-muted text-black-50 bg-gray-500">{{$reserve->time}} {{$reserve->date }}</p>


                    <div class="d-flex align-items-center gap-2">
                        <label class="fw-bold m-2">کد رزرو:</label>
                        <input type="text" value="{{$reserve->reserve_code}}" id="resereve_code"
                               class="form-control text-center"
                               style="width: 120px; cursor: pointer; border-radius: 1rem !important; background-color: white;" disabled>
                    </div>

                    <!-- Bootstrap Alert for Messages -->
                    <div id="copyAlert" class="alert text-center mt-2 d-none"  role="alert"></div>

                    <a class="btn w-100" style="border-radius: 1rem !important;color:white; background-color:#314088 !important;" href="{{ route('public.index') }}">بازگشت به اتوراسا</a>
                </div>
            </div>
            @elseif($status=='error')
                <div class="card-header p-4 justify-content-center text-center" style="border-radius: 15px !important;">
                    <h2 class="text-danger">
                        خطایی رخ داد!
                    </h2>
                    <h6 >
                        {{$message}}
                    </h6>
                </div>
                <div class="position-relative d-flex flex-column align-items-center justify-content-center text-center">
                    <!-- SVG Positioned at the Top Center -->
                    <div class="position-absolute start-50 translate-middle" style="top: -40px;">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="38.5" fill="#DC3545" stroke="#F1AEB5" stroke-width="3"/>
                            <path d="M53.6004 53.6L26.4004 26.4M53.6004 26.4L26.4004 53.6" stroke="white" stroke-width="5" stroke-linecap="round"/>
                        </svg>

                    </div>

                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center border border-2 border-gray-500 rounded-3"
                         style="width: 325px; margin: auto; border-radius: 1rem !important; padding-top: 50px;">
                        <h5 class="card-title" style="color:black !important;">
                            در صورت نیاز به راهنمایی با پشتیبانی اتو راسا تماس بگیرید.
                        </h5>
                        <p class="card-text text-muted mb-1 text-gray-900-fg" >
                            <b>
                                تلفن:  ۸۸۹۴۳۲۹۲ - ۰۲۱
                            </b>
                        </p>

                        <a class="btn w-100" style="border-radius: 1rem !important;color:white; background-color:#314088 !important;" href="{{ route('campaigns.show',1) }}">تلاش مجدد</a>
                    </div>
                </div>
            @endif
        </div>
{{--        @endif--}}
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const reserveCodeInput = document.getElementById("resereve_code");
            const copyAlert = document.getElementById("copyAlert");

            reserveCodeInput.addEventListener("click", function () {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    // Modern browsers
                    navigator.clipboard.writeText(reserveCodeInput.value).then(() => {
                        showMessage("کد رزرو در کلیپ‌بورد کپی شد!", "success");
                    }).catch(err => showMessage("خطا در کپی کد رزرو!", "danger"));
                } else {
                    // Fallback for older browsers
                    reserveCodeInput.select();
                    reserveCodeInput.setSelectionRange(0, 99999);

                    try {
                        const successful = document.execCommand("copy");
                        if (successful) {
                            showMessage("کد رزرو در کلیپ‌بورد کپی شد!", "success");
                        } else {
                            showMessage("متاسفانه مرورگر شما از قابلیت کپی پشتیبانی نمی‌کند.", "warning");
                        }
                    } catch (err) {
                        showMessage("خطا در کپی کد رزرو!", "danger");
                    }
                }
            });

            function showMessage(message, type) {
                copyAlert.textContent = message;
                copyAlert.className = `alert alert-${type} text-center mt-2`; // Change color
                copyAlert.classList.remove("d-none");

                setTimeout(() => {
                    copyAlert.classList.add("d-none");
                }, 3000); // Hide after 3 seconds
            }
        });
    </script>

@endsection
