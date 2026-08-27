@php
    Theme::layout('full-width');
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
        top: 55%;
        left: 15px;
        transform: translateY(-50%);
        cursor: pointer;
    }

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

    select:focus, input:focus {
        border-color: #314088;
        outline: none;
        box-shadow: 0 0 5px rgba(49, 64, 136, 0.5);
    }

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

    #confirm-btn:hover {
        background-color: #222f6b;
    }

    .add-address-btn {
        display: inline-block;
        color: #314088;
        text-decoration: underline;
        font-size: 14px;
        line-height: 24px;
        text-align: center;
        background: none;
        border: none;
        padding: 0;
        margin: 0;
        transition: 0.3s;
    }

    .add-address-btn:hover {
        color: #222f6b;
        text-decoration: underline;
    }


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
        <div class="row justify-content-center mt-5">
            <form id="car-form"
                  action="javascript:void(0);"
                  method="POST"
                  class="col-md-6"
                  style="direction: rtl;">
                @csrf

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0" style="font-weight: normal;">خودروها</h5>
                    @php
                        $kycCarField=\Botble\Kyc\Models\KYCField::where('field_type','car')->first();
                        $carRow=$kycCarField?\Botble\Kyc\Models\KYCSubmission::where('modelable_id',auth('customer')->id())->where('kyc_field_id',$kycCarField->id)->first():null;
                        $carName=$carRow?$carRow->value:null;
                        $carValues = is_string($carName) ? json_decode($carName, true) : $carName;
                        $carString = $carValues ? collect($carValues)->pluck('value')->implode(' ') : '';
                    @endphp
                    {{--                    @dd($carString)--}}
                    <a
                        {{--                        href="{{ route('public.address.create') }}"--}}
                        class="add-address-btn">افزودن آدرس جدید</a>
                </div>

                <div class="mb-3 input-wrapper text-center">
                    <input type="text" id="car_name" name="car_name" class="form-control custom-input-style"
                           value="{{ $carString }}" readonly>

                    <span id="edit-icon" onclick="window.location.href='{{ route('public.kyc.list') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#555" viewBox="0 0 24 24">
                            <path
                                d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/>
                        </svg>
                    </span>
                </div>
                {{--@dd(session('tracked_start_checkout'))--}}
                <div class="text-center mt-4">

                    <button type="button" id="confirm-btn"
                            onclick="window.location.href='{{ route('public.checkout.information', session('tracked_start_checkout')) }}'">
                        تأیید
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>

