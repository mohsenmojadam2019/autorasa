@php
    SeoHelper::setTitle(__('Item not found') . ' - ' . theme_option('site_title'));
    Theme::fireEventGlobalAssets();
@endphp

@extends(Theme::getThemeNamespace('layouts.base'))

@section('content')
    <section class="tp-error-area pt-110 pb-110">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="text-center tp-error-content">
                        <div class="tp-error-thumb">
                            <img src="{{ theme_option('410_page_image') ? RvMedia::getImageUrl(theme_option('410_page_image')) : Theme::asset()->url('images/410.jpg') }}" alt="{{ Theme::getSiteTitle() }}">
                        </div>

                        <h3 class="tp-error-title">{{ __('Oops! Item not found') }}</h3>
                        <p>{{ __("Whoops, this is embarrassing. Looks like the item has been deleted.") }}</p>

                        <a href="{{ BaseHelper::getHomepageUrl() }}" class="tp-error-btn">{{ __('Back to Home') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
