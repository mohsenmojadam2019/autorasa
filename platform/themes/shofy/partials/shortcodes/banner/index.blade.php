<section id="bannerConteinerShortCode" class="py-3">
    <div class="container" style="overflow: hidden;">
        <picture>
            <source
                media="(max-width: 768px)"
                srcset="{{ RvMedia::getImageUrl($shortcode->mobile_banner, 'banner') }}"
            >
            <source
                media="(min-width: 769px)"
                srcset="{{ RvMedia::getImageUrl($shortcode->main_banner, 'banner') }}"
            >
            <img
                src="{{ RvMedia::getImageUrl($shortcode->main_banner, 'banner') }}"
                alt="Banner"
                class="w-100 h-auto d-block"
                style="object-fit: cover;"
                loading="lazy"
            >
        </picture>
    </div>
</section>

<style>
    @media (max-width: 768px) {
        #bannerConteinerShortCode picture img {
            background-color: transparent !important;
            width: 100%;
            height: auto;
            object-fit: cover;
        }
    }
    #bannerConteinerShortCode {
        position: relative;
        padding: 20px 0;
        overflow: hidden;
        z-index: 1; /* بالاتر از پس‌زمینه، پایین‌تر از محتوا */
    }

    #bannerConteinerShortCode::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50%; /* فقط نیمه پایین رو پوشش بده */
        background-image: url('/Banner-Pattern.png');
        /*background-size: 789.64px 414.64px;*/
        background-position: left bottom;
        /*background-repeat: no-repeat;*/
        z-index: -1;
    }



</style>
