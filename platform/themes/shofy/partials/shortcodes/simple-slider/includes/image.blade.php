@php
    $desktopImage = $slider->getMetaData('desktop_image', true) ?: $slider->image;
    $laptopLargeImage = $slider->getMetaData('laptop_large_image', true) ?: $slider->image;
    $laptopImage = $slider->getMetaData('laptop_image', true) ?: $slider->image;
    $tabletImage = $slider->getMetaData('tablet_image', true) ?: $slider->image;
    $mobileImage = $slider->getMetaData('mobile_image', true) ?: $tabletImage;
@endphp

@if($slider->link)
    <a href="{{ url($slider->link) }}">
@endif
    <picture>
        <source
            srcset="{{ RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) }}"
            media="(min-width: 1921px)"
        />
        <source
            srcset="{{ RvMedia::getImageUrl($desktopImage, null, false, RvMedia::getDefaultImage()) }}"
            media="(min-width: 1441px) and (max-width: 1920.98px)"
        />
        <source
            srcset="{{ RvMedia::getImageUrl($laptopLargeImage, null, false, RvMedia::getDefaultImage()) }}"
            media="(min-width: 1025px) and (max-width: 1440.98px)"
        />
        <source
            srcset="{{ RvMedia::getImageUrl($laptopImage, null, false, RvMedia::getDefaultImage()) }}"
            media="(min-width: 769px) and (max-width: 1024.98px)"
        />
        <source
            srcset="{{ RvMedia::getImageUrl($tabletImage, null, false, RvMedia::getDefaultImage()) }}"
            media="(min-width: 481px) and (max-width: 768.98px)"
        />
        <source
            srcset="{{ RvMedia::getImageUrl($mobileImage, null, false, RvMedia::getDefaultImage()) }}"
            media="(max-width: 480.98px)"
        />
        {{ RvMedia::image($slider->image, $slider->title, attributes: $sliderAttributes ?? ['loading' => 'eager']) }}
    </picture>
@if($slider->link)
    </a>
@endif

@php
    unset($sliderAttributes);
@endphp
