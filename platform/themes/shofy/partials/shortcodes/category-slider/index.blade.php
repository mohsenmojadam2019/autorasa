@php
    $items = [
        ['title' => $shortcode->title_tire],
        ['title' => $shortcode->title_batry],
        ['title' => $shortcode->title_roghan],
        ['title' => $shortcode->title_bime],
    ];
@endphp

<section class="pt-80">
    <div class="container">
        <div class="d-flex overflow-auto flex-nowrap gap-3 mb-30" style="width: 480px; height: 48px;">
            @foreach($items as $item)
                <div class="d-flex align-items-center gap-2 text-dark p-3 flex-shrink-0"
                     style=" border: 1px solid #C7C7C7; background-color: #C9D9E0;border-radius: 10px">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 25C19.6274 25 25 19.6274 25 13C25 6.37258 19.6274 1 13 1C6.37258 1 1 6.37258 1 13C1 19.6274 6.37258 25 13 25Z"
                            stroke="#404040" stroke-linecap="round" stroke-linejoin="round"/>
                        <path
                            d="M13.0003 20.4371C17.1083 20.4371 20.4385 17.1069 20.4385 12.9988C20.4385 8.89077 17.1083 5.56055 13.0003 5.56055C8.89224 5.56055 5.56201 8.89077 5.56201 12.9988C5.56201 17.1069 8.89224 20.4371 13.0003 20.4371Z"
                            stroke="#404040" stroke-linecap="round" stroke-linejoin="round"/>
                        <path
                            d="M12.9999 14.5922C13.7783 14.5922 14.4093 13.9612 14.4093 13.1828C14.4093 12.4044 13.7783 11.7734 12.9999 11.7734C12.2216 11.7734 11.5906 12.4044 11.5906 13.1828C11.5906 13.9612 12.2216 14.5922 12.9999 14.5922Z"
                            stroke="#404040" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14.4561 12.8926L19.9964 14.2727" stroke="#404040" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M11.9868 11.5957L10.3387 6.12906" stroke="#404040" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M13.824 11.6836L14.9918 6.09464" stroke="#404040" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M13.7747 14.4023L17.9836 18.3204" stroke="#404040" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M11.5127 12.8926L5.97234 14.2727" stroke="#404040" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M12.1941 14.4023L7.98513 18.3204" stroke="#404040" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    <h4 class="m-0">{{ $item['title'] }}</h4>
                </div>
            @endforeach
        </div>
    </div>
</section>
