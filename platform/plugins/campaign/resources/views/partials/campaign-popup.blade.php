@php
    $title = theme_option('campaign_popup_title');
    $image = ($image = theme_option('campaign_popup_image')) ? RvMedia::getImageUrl($image) : null;
@endphp
<div
    class="modal fade campaign-popup"
    id="campaign-popup"
    tabindex="-1"
    aria-labelledby="campaignPopupModalLabel"
    aria-hidden="true"
    data-delay="{{ theme_option('campaign_popup_delay', 5) }}"
    title="{{ $title }}"
>
    <div class="modal-dialog rounded-4" dir="rtl">
        <div class="modal-content border-0">
            <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" style="right: 1rem !important;" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>

            @if ($image)
                <div class="d-md-none campaign-popup-image-wrapper">
                    <img src="{{ $image }}" alt="Campaign Image" class="img-fluid">
                </div>
            @endif

            <div class="campaign-popup-content text-center p-4">
                <div class="modal-header flex-column align-items-center border-0 p-0">
                    @if ($title = theme_option('campaign_popup_title'))
                        <h5 class="modal-title fs-2" id="campaignPopupModalLabel">{!! BaseHelper::clean($title) !!}</h5>
                    @endif
                    @if ($description = theme_option('campaign_popup_description'))
                        <p class="modal-text text-muted">{!! BaseHelper::clean($description) !!}</p>
                    @endif

                    <p class="capacity">
                        ظرفیت باقی‌مانده:@if ($capacity = theme_option('campaign_popup_capacity')){!! BaseHelper::clean($capacity) !!}@endif نفر
                    </p>
                </div>
                <div class="modal-body p-0">
                    <a class="btn btn-primary" href="{{route('campaigns.show','1')}}" style="width: 80%; border-radius: 2rem !important;">
                        @if ($btn_title = theme_option('campaign_popup_btn_title'))
                            {!! BaseHelper::clean($btn_title) !!}
                        @else
                            رزرو
                        @endif
                    </a>
                </div>
            </div>

            @if ($image)
                <div class="d-none d-md-block campaign-popup-bg">
                    <img src="{{ $image }}" alt="Campaign Image" class="img-fluid">
                </div>
            @endif
        </div>
    </div>
</div>
