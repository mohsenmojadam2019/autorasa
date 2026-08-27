@php
    Theme::layout('full-width');
    $token = request()->route('token');
@endphp

<section class="tp-cart-area pb-120">
    <div class="container">
        <div class="container text-center mt-5">
            <p style="font-weight: 400; font-size: 14px; color: #212529;">
                نوع خدمات مورد نیاز خود را مشخص کنید.
            </p>
<style>
    a {
        text-decoration: none;
        color: inherit;
    }
    .option-box {
        border: 1px solid #C7C7C7;
        border-radius: 16px;
        height: 80px;
        text-decoration: none;
        color: inherit;
        padding-left: 16px;
        transition: background 0.3s ease;
    }

    .option-box:hover {
        background-color: #f5f5f5;
    }

    .option-box.disabled {
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
    }

</style>
            <div class="row justify-content-center mt-4">
                {{-- Option 1: ارسال سریع --}}
                <div class="col-md-4 mb-3">
                    <a href="{{ route('public.kyc.list', ['redirect' => 'public.checkout.information', 'order_type' => 'post', 'token' => $token]) }}"
                       class="d-flex align-items-center option-box ps-3">
                        <svg width="65" height="51" viewBox="0 0 65 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 27.5644L1 25.7383" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M1.00121 22.027V14.0369L22.3593 2L43.8672 13.9476V37.9146L22.7757 49.4124L1.00121 37.5173V31.3457" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M22.9141 26.0859V49.0223" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M1.00121 13.9453L22.8441 26.0312L43.457 14.3269" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M30.9797 6.73986C30.6801 6.59005 30.3254 6.60022 30.0348 6.76695L9.94583 18.2946C9.63514 18.4729 9.44354 18.8038 9.44354 19.162V25.5795C9.44354 25.7808 9.55512 25.9663 9.73122 26.0608L13.1903 27.9128C13.553 28.1071 13.9906 27.8428 13.9906 27.4315V21.7283C13.9906 21.3681 14.1843 21.0358 14.4977 20.8583L33.4194 10.1377C34.0529 9.7788 34.1027 8.88481 33.513 8.45775L31.5662 7.04794C31.5221 7.01603 31.4755 6.98777 31.4269 6.96344L30.9797 6.73986Z" fill="#B85E47" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M43.8645 17.5879H60.1016" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M43.9125 24.8262L53.043 24.8262" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M43.9117 33.957L55.7812 33.957" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M55.7843 24.8262L58.5234 24.8262" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M59.4536 33.8242H64" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                        </svg> &nbsp;&nbsp;
                        ارسال سریع
                    </a>
                </div>

                {{-- Option 2: نصب در مرکز خدمات --}}
                <div class="col-md-4 mb-3">
                    <a href="{{ route('public.checkout.service-center.index', ['token' => $token]) }}"
                       class="d-flex align-items-center option-box ps-3">
                        <svg width="40" height="44" viewBox="0 0 40 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M39 41.5H35L34.5 10.5L39 13V41.5Z" fill="#D7E2E7"/>
                            <path d="M28.5 32.5L25.5 27H15.5L13 32.5H28.5Z" fill="#D7E2E7"/>
                            <path d="M11.3125 32.8438H29.6875" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M27.7188 40.7188H25.75C25.576 40.7188 25.409 40.6496 25.286 40.5265C25.1629 40.4035 25.0938 40.2365 25.0938 40.0625V38.0938H15.9062V40.0625C15.9062 40.2365 15.8371 40.4035 15.714 40.5265C15.591 40.6496 15.424 40.7188 15.25 40.7188H13.2812C13.1072 40.7188 12.9403 40.6496 12.8172 40.5265C12.6941 40.4035 12.625 40.2365 12.625 40.0625V32.8438L15.0768 27.3272C15.1283 27.2112 15.2124 27.1127 15.3189 27.0435C15.4253 26.9743 15.5495 26.9375 15.6765 26.9375H25.3235C25.4505 26.9375 25.5747 26.9743 25.6811 27.0435C25.7876 27.1127 25.8717 27.2112 25.9232 27.3272L28.375 32.8438V40.0625C28.375 40.2365 28.3059 40.4035 28.1828 40.5265C28.0597 40.6496 27.8928 40.7188 27.7188 40.7188Z" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M39 40.8837V13.1634L20.037 2L1 12.5815V40.8837" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M5 41V20C5 19.4477 5.44772 19 6 19H34C34.5523 19 35 19.4477 35 20V41" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M23 10H17C16.4477 10 16 10.4477 16 11V14C16 14.5523 16.4477 15 17 15H23C23.5523 15 24 14.5523 24 14V11C24 10.4477 23.5523 10 23 10Z" fill="#B85E47" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                        </svg>
                        &nbsp;&nbsp;
                        نصب در مرکز خدمات
                    </a>
                </div>

                {{-- Option 3: غیرفعال --}}
                <div class="col-md-4 mb-3">
                    <a href="javascript:void(0);" class="d-flex align-items-center option-box disabled ps-3">
                        <svg width="55" height="40" viewBox="0 0 55 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M47 31V2.5C47 1.94772 47.4477 1.5 48 1.5H52.5C53.0523 1.5 53.5 1.94772 53.5 2.5V31C53.5 31.5523 53.0523 32 52.5 32H48C47.4477 32 47 31.5523 47 31Z" fill="#D7E2E7"/>
                            <path d="M51.2837 1H21.1378C20.085 1 19.2302 1.85483 19.2302 2.90765V32.2897H51.2837C52.3366 32.2897 53.1914 31.4349 53.1914 30.382V2.90765C53.1914 1.85483 52.3366 1 51.2837 1Z" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M1.54541 23.8852V30.0174C1.54541 31.2721 2.56208 32.2906 3.81863 32.2906H19.2305V11.375H9.14376C8.38602 11.375 7.6892 11.7938 7.33508 12.464L1.7853 22.9256C1.62918 23.2207 1.54732 23.562 1.54732 23.897L1.54541 23.8852Z" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M13.7218 15.6133H5.66654L1.97676 24.2643H13.7218C14.4129 24.2643 14.9727 23.7046 14.9727 23.0135V16.8641C14.9727 16.173 14.4129 15.6133 13.7218 15.6133Z" fill="#C9D9E0" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M8.87416 38.941C5.89006 38.941 3.47097 36.5219 3.47097 33.5379C3.47097 30.5538 5.89006 28.1348 8.87416 28.1348C11.8583 28.1348 14.2773 30.5538 14.2773 33.5379C14.2773 36.5219 11.8583 38.941 8.87416 38.941Z" fill="#B85E47" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M8.87249 35.4034C7.84204 35.4034 7.00669 34.5681 7.00669 33.5376C7.00669 32.5072 7.84204 31.6719 8.87249 31.6719C9.90294 31.6719 10.7383 32.5072 10.7383 33.5376C10.7383 34.5681 9.90294 35.4034 8.87249 35.4034Z" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M41.6163 38.941C38.6322 38.941 36.2132 36.5219 36.2132 33.5379C36.2132 30.5538 38.6322 28.1348 41.6163 28.1348C44.6004 28.1348 47.0195 30.5538 47.0195 33.5379C47.0195 36.5219 44.6004 38.941 41.6163 38.941Z" fill="#B85E47" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M41.6147 35.4034C40.5842 35.4034 39.7489 34.5681 39.7489 33.5376C39.7489 32.5072 40.5842 31.6719 41.6147 31.6719C42.6451 31.6719 43.4805 32.5072 43.4805 33.5376C43.4805 34.5681 42.6451 35.4034 41.6147 35.4034Z" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M53.6172 39L1.00181 39" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M52.6992 28.4844H49.2208C48.9486 28.4844 48.7277 28.2636 48.7277 27.9913V24.3759C48.7277 24.1037 48.9486 23.8828 49.2208 23.8828H52.6992" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M24.937 7.08984H39.1094" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M24.9354 11.375H34.8203" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M41.9498 7.08984H43.4805" stroke="#404040" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
                        </svg>
                        &nbsp;&nbsp;
                        نصب در محل
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
