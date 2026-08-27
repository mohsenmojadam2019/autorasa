@php
    use Botble\Shortcode\Facades\Shortcode;

    Theme::asset()->remove('contact-css');
    Theme::asset()->container('footer')->remove('contact-public-js');

    $contactInfo = Shortcode::fields()->getTabsData(['icon', 'content'], $shortcode);
@endphp

<section class="tp-contact-area pb-100">
    <div class="container">
        <div class="tp-contact-inner">
            <div class="row">
                <!-- فرم تماس: موبایل پایین، دسکتاپ راست -->
                @if ($shortcode->show_contact_form)
                    <div class="col-xl-9 col-lg-8 order-1 order-lg-0">
                        <div class="tp-contact-wrapper">
                            @if ($title = $shortcode->title)
                                <h3 class="tp-contact-title">{{ $title }}</h3>
                            @endif

                            <div class="tp-contact-form">
                                {!! $form->renderForm() !!}
                            </div>
                        </div>
                    </div>
            @endif

            <!-- اطلاعات تماس: موبایل بالا، دسکتاپ چپ -->
                <div class="col-xl-3 col-lg-4 order-0 order-lg-1">
                    <div class="tp-contact-info-wrapper">
                        @foreach ($contactInfo as $info)
                            @continue(empty($info['icon']) || empty($info['content']))

                            <div class="tp-contact-info-item mt-200">
                                <div class="tp-contact-info-icon">
                                    <span>
                                        {{ RvMedia::image($info['icon'], $info['content']) }}
                                    </span>
                                </div>
                                <div class="tp-contact-info-content">
                                    <p>{!! BaseHelper::clean($info['content']) !!}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



