@extends('plugins/campaign::theme.master')

@section('title', SeoHelper::getTitle())

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-center text-center pb-5">
            @php
                $logo = theme_option('logo');
                $logoLight = theme_option('logo_light');
                    $height = theme_option('logo_height', 35);
                    $attributes = [
                    'style' => sprintf('height: %s', is_numeric($height) ? "{$height}px" : $height),
                    'loading' => false,
                ];
            @endphp
            {{ RvMedia::image($logoLight ?: $logo, theme_option('site_title'), attributes: ['class' => 'logo-light', ...$attributes]) }}
        </div>
                <form class="shadow-sm" style="border:1px solid #bbb !important; padding: 2rem 5rem 2rem 5rem;margin:0 5rem 11rem 5rem;border-radius:16px !important;" method="post" action="{{route('campaigns.reserve')}}">
                    
                    <h3 class="d-flex justify-content-center text-center pb-5 mb-0">رزرو نوبت</h3>
                    <h5 class="d-flex justify-content-center text-center pb-5 mb-3">جهت رزرو نوبت در مرکز مورد نظر، اطلاعات تکمیلی زیر را وارد نمایید.</h5>
                    @csrf

                    <div class="mb-3">
                        <label for="fullname" class="form-label">نام و نام خانوادگی</label>
                        <input type="text" style="border-radius:1rem !important;" class="form-control" id="fullname" name="fullname" placeholder="نام و نام خانوادگی خود را وارد کنید" required>
                        <input type="text" hidden value="{{$id}}" name="agency_id" required>

                    </div>

                    <div class="mb-3">
                        <label for="mobile" class="form-label">شماره موبایل</label>
                        <input type="tel" style="border-radius:1rem !important;" class="form-control rtl" id="mobile" name="mobile" placeholder="09XXXXXXXXX" required>
                    </div>

                    <div class="mb-3">
                        <label for="carmodel" class="form-label">مدل خودرو</label>
                        <input type="text" style="border-radius:1rem !important;" class="form-control" id="carmodel" name="carmodel" placeholder="مدل خودرو را وارد کنید" required>
                    </div>
                    @php

                    @endphp
                    <div class="mb-3">
                        <label for="date" class="form-label">تاریخ</label>
                        <select style="border-radius:1rem !important;" class="form-control" id="date" name="date" required>
                            @foreach($weekDays as $weekDay)
                                <option value="{{$weekDay}}">
                                    {{$weekDay}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="border-radious:1rem !important;" class="mb-3">
                        <label for="time" class="form-label">زمان</label>
                        <select class="form-control" id="time" name="time" required>
                            @foreach($timeSlots as $timeSlot)
                                <option value="{{$timeSlot}}">
                                    {{ $timeSlot }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-center text-center flex-column align-items-center">
                        
                       <button type="submit" class="btn custom-width" style="background-color: #0a53be; color:white; border-radius:3rem;">رزرو نوبت</button> 
                        <a class="btn btn-link" style="width: 60% !important; border-radius:2rem !important;"">بازگشت</a>
                    </div>

                </form>
    </div>
@endsection

