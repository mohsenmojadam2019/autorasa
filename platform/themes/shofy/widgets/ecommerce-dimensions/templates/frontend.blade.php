@if($dimensions->isNotEmpty())
    <section class="tp-dimension-area pb-40">
        @switch($config['style'])
            @case('slider')
                <div class="tp-dimension-slider p-relative">
                    <div class="tp-dimension-slider-active swiper-container">
                        <div class="swiper-wrapper">
                            @foreach($dimensions as $dimension)
                                <div class="tp-dimension-item swiper-slide text-center">
                                    <a href="{{ $dimension->url }}">
                                        {{ RvMedia::image($dimension->logo, $dimension->name, attributes: ['loading' => 'lazy']) }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tp-dimension-slider-arrow">
                        <button class="tp-dimension-slider-button-prev">
                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="tp-dimension-slider-button-next">
                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>

                @break

            @case('grid')
                <div class="tp-dimension-grid">
                    <div class="row">
                        @foreach($dimensions as $dimension)
                            <div class="col-lg-2 col-md-3 col-6">
                                <div class="tp-dimension-item text-center">
                                    <a href="{{ $dimension->url }}">
                                        {{ RvMedia::image($dimension->logo, $dimension->name, attributes: ['loading' => 'lazy']) }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @break
        @endswitch
    </section>
@endif
