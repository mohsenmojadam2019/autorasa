@php
    Theme::layout('full-width');
@endphp


<style>
    body {
        font-family: 'IRANSansXVF', sans-serif;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper input {
        padding-left: 40px;
    }

    .input-wrapper #edit-icon {
        position: absolute;
        top: 65%;
        left: 15px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .custom-input-style {
        width: 100%;
        height: 56px;
        border-radius: 12px;
        border: 1px solid #ced4da;
        padding: 10px;
        font-size: 16px;
        background-color: #fff;
    }

    .form-label,
    .form-control,
    button {
        font-family: 'IRANSansXVF', sans-serif;
    }

    button {
        font-weight: 600;
    }

    /* استایل مدال */
    #loginModal {
        position: fixed;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -30%);
        background: white;
        padding: 20px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.5s ease;
    }

    #loginModal.show {
        opacity: 1;
        visibility: visible;
    }

    /* دکمه ثبت آدرس برای موبایل */
    #confirm-btn {
        width: 100%;
        max-width: 343px;
        height: 40px;
        border-radius: 12px !important;
        background: #314088;
        padding: 10px;
    }

    @media (min-width: 768px) {
        #address-form {
            max-width: 600px;
        }
    }

    @media (max-width: 767.98px) {
        .text-center h3 {
            font-size: 20px;
        }

        .custom-input-style {
            font-size: 14px;
        }

        #confirm-btn {
            max-width: 100%;
        }
    }
</style>

<section class="tp-cart-area pb-120">
    <div class="container">
        <div class="text-center mt-5">
            <svg width="65" height="94" viewBox="0 0 65 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M32.5 93.8486C50.4493 93.8486 65 89.874 65 84.9712C65 80.0683 50.4493 76.0938 32.5 76.0938C14.5507 76.0938 0 80.0683 0 84.9712C0 89.874 14.5507 93.8486 32.5 93.8486Z" fill="#B85E47"/>
                <path d="M56.3301 55.5116C50.3815 64.3031 32.5004 86.2795 32.5004 86.2795C32.5004 86.2795 14.6194 64.3031 8.67081 55.5116C-3.03949 38.2011 -1.45388 21.1432 10.6251 9.0592C16.6645 3.01973 24.5825 0 32.5004 0C40.4184 0 48.3313 3.01973 54.3758 9.0592C66.4548 21.1381 68.0404 38.1961 56.3301 55.5116Z" fill="#C9D9E0"/>
                <path d="M32.5 50.4375C42.7798 50.4375 51.1133 42.104 51.1133 31.8242C51.1133 21.5444 42.7798 13.2109 32.5 13.2109C22.2202 13.2109 13.8867 21.5444 13.8867 31.8242C13.8867 42.104 22.2202 50.4375 32.5 50.4375Z" fill="white"/>
                <path d="M32.5016 24V31.5016M32.5016 31.5016V39M32.5016 31.5016H25M32.5016 31.5016H40" stroke="#404040" stroke-width="4" stroke-miterlimit="10" stroke-linecap="round"/>
            </svg>
            <div style="font-weight:400 ; font-size:14px ; color:#212529;">
            لطفا برای ادامه آدرس پستی خود را انتخاب کنید.
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <form id="address-form"
                  action="{{ route('public.checkout.services', ['token' => request()->route('token')]) }}"
                  method="GET" class="col-12 col-md-6" style="direction: rtl;">
                @csrf

                <div class="mb-3 input-wrapper">
                    <label for="full_address" class="form-label">آدرس کامل</label>
                    <input type="text" id="full_address" name="full_address"
                           class="form-control custom-input-style"
                           value="" readonly>
                    <span id="edit-icon" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="#555" viewBox="0 0 24 24">
                            <path
                                d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/>
                        </svg>
                    </span>
                </div>

                <div class="text-center">
                    <button type="submit" id="confirm-btn" class="btn btn-primary mt-4">
                        ثبت آدرس
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>


<!-- مدال لاگین -->
<div id="loginModal">
    <p style="margin: 0; font-size: 18px; text-align: center;">لطفاً ابتدا وارد شوید...</p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fullAddressField = document.getElementById('full_address');
        const editIcon = document.getElementById('edit-icon');
        const loginModal = document.getElementById('loginModal');

        const province = localStorage.getItem('selectedProvince');
        const city = localStorage.getItem('selectedCity');
        const area = localStorage.getItem('selectedArea');
        const address = localStorage.getItem('selectedAddress');

        // console.log('Province:', province);
        // console.log('City:', city);
        // console.log('Area:', area);
        // console.log('Address:', address);

        if (province && city && area && address) {
            fullAddressField.value = `${province} - ${city} - ${area} - ${address}`;
        } else {
            console.log('Some address details are missing');
        }

        editIcon.addEventListener('click', function () {
            const isGuestCheckoutEnabled = {{ EcommerceHelper::isEnabledGuestCheckout() ? 'true' : 'false' }};
            const isAuthenticated = {{ auth('customer')->check() ? 'true' : 'false' }};
            const token = "{{ request()->route('token') }}";

            if (!isGuestCheckoutEnabled && !isAuthenticated) {
                loginModal.classList.add('show');
                setTimeout(function () {
                    loginModal.classList.remove('show');
                    window.location.href = "{{ route('customer.login') }}";
                }, 2500); // 2.5 ثانیه فرصت نشون داده میشه
            } else {
                window.location.href = "{{ route('public.checkout.address', ['token' => request()->route('token')]) }}";

                {{--if (token) {--}}
                {{--    window.location.href = "{{ url('checkout') }}/" + token + "/address/show";--}}
                {{--} else {--}}
                {{--    console.error('Token not found.');--}}
                {{--}--}}
            }
        });
    });
</script>
