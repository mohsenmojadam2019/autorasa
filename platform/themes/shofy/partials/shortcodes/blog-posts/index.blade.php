<section class="tp-blog-area pt-5 pt-md-15 pb-5 pb-md-15">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-between mb-10 gx-0">
            <div class="col-6 col-md-6 col-xl-4 d-flex align-items-center px-3">
                <div class="w-100" style="font-size: 16px; line-height: 1.4;">
                    {!! Theme::partial('section-title', compact('shortcode')) !!}
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-8 d-flex justify-content-end align-items-center px-3">
                @if(($buttonLabel = $shortcode->button_label) && ($buttonUrl = $shortcode->button_url ?: get_blog_page_url()))
                    <div class="tp-blog-more-wrapper m-0 p-0">
                        <div class="tp-blog-more text-end m-0 p-0" style="background-color: #f9f9f9 !important; font-size: 16px; line-height: 1.4;">
                            <a href="{{ $buttonUrl }}" style="text-decoration: none; color:#314089;">
                                {!! BaseHelper::clean($buttonLabel) !!}
                                <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 6.99976L1 6.99976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9.9502 0.975414L16.0002 6.99941L9.9502 13.0244" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
{{--                            <span class="tp-blog-more-border"></span>--}}
                        </div>
                    </div>
                @endif
            </div>
        </div>



        <div class="row">
            <div class="col-xl-12">
                <div class="tp-blog-main-slider">
                    <div class="tp-blog-main-slider-active swiper-container">
                        <div class="swiper-wrapper">
                            @foreach($posts as $post)
                                <div class="tp-blog-item mb-30 swiper-slide">
                                    <div class="tp-blog-thumb p-relative fix">
                                        <a href="{{ $post->url }}">
                                            {{ RvMedia::image($post->image, $post->name) }}
                                        </a>
                                        <div class="tp-blog-meta tp-blog-meta-date">
                                            <span>{{ Theme::formatDate($post->created_at) }}</span>
                                        </div>
                                    </div>
                                    <div class="tp-blog-content">
                                        <h3 class="tp-blog-title text-truncate">
                                            <a href="{{ $post->url }}" title="{{ $post->name }}">
                                                {!! BaseHelper::clean($post->name) !!}
                                            </a>
                                        </h3>

                                        @if($post->firstCategory)
                                            <div class="tp-blog-tag">
                                                <span><x-core::icon name="ti ti-tag" /></span>
                                                <a href="{{ $post->firstCategory->url }}">{{ $post->firstCategory->name }}</a>
                                            </div>
                                        @endif

                                        <p>{{ Str::words($post->description, 20) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
