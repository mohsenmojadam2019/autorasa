@php
    $title ??= $shortcode->title;
    $subtitle ??= $shortcode->subtitle;
@endphp

@if($title || $subtitle)
    <div @class(['tp-section-title-wrapper', $class ?? null])>
        @if($subtitle)
            <span class="tp-section-title-pre">
                {!! BaseHelper::clean($subtitle) !!}
            </span>
        @endif
        @if($title)
            <p class="section-title tp-section-title" style="font-weight: 700; font-size: 18px; color:#212121; ">
                @include(Theme::getThemeNamespace('partials.section-title-inner'))
            </p>
        @endif
    </div>
@endif
