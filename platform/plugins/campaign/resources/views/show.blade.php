@extends('plugins/campaign::theme.master')

@section('title', SeoHelper::getTitle())
@section('content')
    <div class="container mt-4" style="border-radius: 15px !important;" >
        <div class="d-flex justify-content-center text-center pb-5" style="border-radius: 15px !important;">
            {{--                            <img src="https://www.autorasa.com/storage/main/general/logo-autorasa-farsi-2.png" alt="Logo" style="height: 50px;">--}}
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
        <div class="card" style="border-radius: 15px !important;">

            <div class="card-header d-flex justify-content-center text-center " style="border-radius: 15px !important;">
                <div>
                    <p class="pb-2" style="font-size:24px;color:#212121; font-weight: 700; line-height: 37px;">
                        تنظیم رایگان باد تایر
                    </p>
                    <p style="font-size:18px;color:#404040; font-weight: 400; line-height: 28px;">
                        اتو سرویس مورد نظر خود را انتخاب کنید.
                    </p>
                </div>
            </div>

            <div class="card-body">
                <div>
                        @foreach($operators as $data)
                            @include('plugins/campaign::partials.agency-card',$data)
                        @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
