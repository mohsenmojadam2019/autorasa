<section class="mb-60">
    <div class="container p-relative pt-80 pb-20">
        @if ($shortcode->title || $shortcode->description)
            <div class="tp-section-title-wrapper mb-40">
                @if ($shortcode->title)
                    <p class="section-title tp-section-title" style="font-size: 24px; font-weight: 700; line-height: 100%;">
                        {!! BaseHelper::clean($shortcode->title) !!}
                    </p>
                @endif

                @if ($shortcode->description)
                    <p class="text-muted fs-6 mt-2">{!! BaseHelper::clean($shortcode->description) !!}</p>
                @endif
            </div>
        @endif

        @if ($shortcode->style === 'list')
            <div class="tp-faq-wrapper">
                <div class="accordion" id="accordion-faqs">
                    @foreach($faqs as $faq)
                        <div class="accordion-item">
                            <p style="font-size: 18px; font-weight: 700; line-height: 100%; color: #404040;" class="accordion-header" id="heading{{ $faq->getKey() }}">
                                <button @class(['accordion-button text-heading-5', 'collapsed' => ! ($loop->first && $shortcode->expand_first_time)]) type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->getKey() }}" aria-expanded="false" aria-controls="collapse{{ $faq->getKey() }}">
                                    {!! BaseHelper::clean($faq->question) !!}
                                </button>
                            </p>
                            <div style="background-color: #FFFFFF !important; " @class(['accordion-collapse collapse', 'show' => $loop->first && $shortcode->expand_first_time]) id="collapse{{ $faq->getKey() }}" aria-labelledby="heading{{ $faq->getKey() }}" data-bs-parent="#accordion-faqs">
                                <div class="accordion-body" style="font-size: 14px; font-weight: 400; line-height: 100%; color: #404040;">
                                    @php
                                        $answer = str_replace('background-color:rgb(236,236,236);', 'background-color:white;', $faq->answer);
                                    @endphp
                                    {!! BaseHelper::clean($answer) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="tp-faq-wrapper row gy-4">
                @foreach ($categories as $category)
                    <div class="col-md-6">
                        <div class="tp-faq-item">
                            <h4 class="tp-faq-title">{{ $category->name }}</h4>

                            <div class="accordion" id="{{ $category->slug }}-faqs">
                                @foreach($category->faqs as $faq)
                                    <div class="accordion-item">
                                        <h5 class="accordion-header" id="heading{{ $faq->getKey() }}">
                                            <button @class(['accordion-button text-heading-5', 'collapsed' => ! ($loop->first && $shortcode->expand_first_time)]) type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->getKey() }}" aria-expanded="false" aria-controls="collapse{{ $faq->getKey() }}">
                                                {!! BaseHelper::clean($faq->question) !!}
                                            </button>
                                        </h5>
                                        <div @class(['accordion-collapse collapse', 'show' => $loop->first && $shortcode->expand_first_time]) id="collapse{{ $faq->getKey() }}" aria-labelledby="heading{{ $faq->getKey() }}" data-bs-parent="#accordion-faqs">
                                            <div class="accordion-body">
                                                {!! BaseHelper::clean($faq->answer) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
