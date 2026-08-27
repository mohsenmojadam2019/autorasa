<section id="searchConteinerShortCode" class="pt-0 pt-md-1" >

    <div class="container pt-0 mt-0">
        @php
            // ابعاد تصویر دسکتاپ
            $desktopPath = RvMedia::getRealPath($shortcode->main_banner);
            [$desktopWidth, $desktopHeight] = getimagesize($desktopPath);

            // ابعاد تصویر موبایل
            $mobilePath = RvMedia::getRealPath($shortcode->mobile_banner);
            [$mobileWidth, $mobileHeight] = getimagesize($mobilePath);
        @endphp

        <picture>
            {{-- تصویر موبایل --}}
            <source
                media="(max-width: 768px)"
                srcset="{{ RvMedia::getImageUrl($shortcode->mobile_banner, 'banner') }}"
                width="{{ $mobileWidth }}"
                height="{{ $mobileHeight }}"
            >
            {{-- تصویر دسکتاپ --}}
            <source
                media="(min-width: 769px)"
                srcset="{{ RvMedia::getImageUrl($shortcode->main_banner, 'banner') }}"
                width="{{ $desktopWidth }}"
                height="{{ $desktopHeight }}"
            >

            {{-- fallback تصویر اصلی --}}
            <img
                src="{{ RvMedia::getImageUrl($shortcode->main_banner, 'banner') }}"
                alt="{{ $shortcode->alt_text ?? 'بنر فروش ویژه' }}"
                title="{{ $shortcode->alt_text ?? 'بنر فروش ویژه' }}"
                width="{{ $desktopWidth }}"
                height="{{ $desktopHeight }}"
                class="w-100 h-auto d-block"
                style="object-fit: cover;"
                loading="lazy"
            >
        </picture>

        <div class="d-flex overflow-auto flex-nowrap justify-content-center justify-content-md-start gap-3 mt-30 mt-md-4 mb-30" style=" height: 48px;">
            {{--            @php--}}
            {{--                $items = [--}}
            {{--                    ['title' => $shortcode->title_tire],--}}
            {{--                    ['title' => $shortcode->title_batry],--}}
            {{--                    ['title' => $shortcode->title_roghan],--}}
            {{--                    ['title' => $shortcode->title_bime],--}}
            {{--                ];--}}
            {{--            @endphp--}}
            {{--            @foreach($items as $item)--}}
            <div class="d-flex align-items-center justify-content-center gap-2 text-dark p-3 flex-shrink-0"
                 style=" border: 1px solid #C7C7C7; background-color: #314088;border-radius: 16px; width:100px; height:48px;">
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 25C19.6274 25 25 19.6274 25 13C25 6.37258 19.6274 1 13 1C6.37258 1 1 6.37258 1 13C1 19.6274 6.37258 25 13 25Z" stroke="#EDF2F5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.0003 20.439C17.1083 20.439 20.4385 17.1088 20.4385 13.0008C20.4385 8.89273 17.1083 5.5625 13.0003 5.5625C8.89224 5.5625 5.56201 8.89273 5.56201 13.0008C5.56201 17.1088 8.89224 20.439 13.0003 20.439Z" stroke="#EDF2F5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.9999 14.5922C13.7783 14.5922 14.4093 13.9612 14.4093 13.1828C14.4093 12.4044 13.7783 11.7734 12.9999 11.7734C12.2216 11.7734 11.5906 12.4044 11.5906 13.1828C11.5906 13.9612 12.2216 14.5922 12.9999 14.5922Z" stroke="#EDF2F5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.4561 12.8887L19.9964 14.2688" stroke="#EDF2F5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11.9868 11.5918L10.3387 6.12516" stroke="#EDF2F5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.8237 11.6816L14.9916 6.09268" stroke="#EDF2F5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.7744 14.4004L17.9834 18.3185" stroke="#EDF2F5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11.5127 12.8887L5.97234 14.2688" stroke="#EDF2F5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.1938 14.4004L7.98489 18.3185" stroke="#EDF2F5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                {{--                    <h4 class="m-0">{{ $item['title'] }}</h4>--}}
                <h4 class="m-0" style="color:#EDF2F5; font-size: 16px; font-weight: 500;">{{$shortcode->title_tire}}</h4>

            </div>
            <div class="d-flex align-items-center justify-content-center gap-2 text-dark p-3 flex-shrink-0"
                 style=" border: 1px solid #C7C7C7; background-color: #E3E3E3;border-radius: 16px; width:100px; height:48px;">
                <svg width="25" height="20" viewBox="0 0 25 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24.9439 2.74661C24.9134 2.52982 24.6356 2.15383 24.4188 2.15383H22.0477V0.565173C22.0477 0.389032 21.6649 0.0232008 21.4549 0.0401374C19.9984 0.107884 18.4334 -0.0682571 16.9904 0.0333628C16.7127 0.0536867 16.2384 0.243377 16.2384 0.565173V2.15722H8.87099V0.565173C8.87099 0.389032 8.48823 0.0232008 8.27821 0.0401374C6.7844 0.111271 5.18219 -0.0716444 3.70193 0.0333628C3.42417 0.0536867 2.94995 0.243377 2.94995 0.565173V2.15722H0.582204C0.365415 2.15722 0.0876542 2.52982 0.0571682 2.75C-0.017353 3.27842 -0.0207403 5.16516 0.0571682 5.69697C0.145239 6.31686 0.778669 6.32702 1.27999 6.28976V18.7111C1.27999 18.9245 1.73051 19.3005 1.9744 19.2429H23.1926C23.4568 19.3208 23.9446 18.9448 23.9446 18.7111V6.28637C24.3951 6.35073 24.8727 6.19152 24.9439 5.69359C25.0184 5.16516 25.0184 3.27504 24.9439 2.74661ZM17.1327 0.927617H21.1534V2.15722H17.1327V0.927617ZM3.84759 0.927617H7.98013V2.15722H3.84759V0.927617ZM24.0564 5.39211H21.4617C21.0721 5.39211 21.0721 6.28637 21.4617 6.28637H23.0537V18.3453H2.17086V6.28637H3.53934C3.92888 6.28637 3.92888 5.39211 3.53934 5.39211H0.944648V3.04808H24.0564V5.39211Z" fill="#9C9C9C"/>
                    <path d="M15.9496 9.0357L13.3989 9.37782L14.2525 5.95323C14.1916 5.41465 13.5446 5.15721 13.1686 5.57385L8.58553 11.2917C8.33826 11.6033 8.59908 12.1487 8.95814 12.2232H11.3157C11.082 13.3139 10.7805 14.3978 10.601 15.4953C10.6552 16.1593 11.4173 16.288 11.7696 15.746L16.4645 9.88931C16.5762 9.46251 16.3933 9.09329 15.9428 9.0357H15.9496ZM15.3805 10.0113L11.6511 14.6011C11.5901 14.5672 11.6409 14.452 11.6511 14.3978C11.7866 13.6188 12.0609 12.8261 12.1897 12.0403C12.2405 11.8167 11.8983 11.4068 11.7053 11.4068H9.55092L13.1517 6.94233L12.5013 9.5709C12.4708 9.7843 12.6605 10.123 12.8603 10.2043C13.2431 10.3601 14.7437 9.97738 15.262 9.94351C15.3365 9.93673 15.4042 9.89947 15.3839 10.0146L15.3805 10.0113Z" fill="#9C9C9C"/>
                </svg>

                {{--                    <h4 class="m-0">{{ $item['title'] }}</h4>--}}
                <h4 class="m-0" style="color:#9C9C9C; font-size: 14px; font-weight: 500;">باتری</h4>

            </div>
            <div class="d-flex align-items-center justify-content-center gap-2 text-dark p-3 flex-shrink-0"
                 style=" border: 1px solid #C7C7C7; background-color: #E3E3E3;border-radius: 16px;width:100px; height:48px;">
                <svg width="34" height="22" viewBox="0 0 34 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_2442_18634)">
                        <path d="M21.225 6.55762H17.5791V1.71875H21.225V6.55762V6.55762ZM18.7096 5.43231H20.0945V2.84407H18.7096V5.43231Z" fill="#9C9C9C"/>
                        <path d="M26.1708 14.1484C26.0578 14.1484 25.9165 14.1203 25.8034 14.0922C25.4077 13.9515 25.1816 13.5858 25.1816 13.1638V7.95917C25.1816 7.50905 25.4643 7.11518 25.8599 6.94639L29.3363 5.08961C29.9015 4.89268 30.5233 5.14587 30.7494 5.70853L30.7777 5.7648L31.4842 8.04357C31.6255 8.43743 31.5407 8.88756 31.2581 9.19703L26.9057 13.8108C26.7078 14.0359 26.4252 14.1484 26.1708 14.1484ZM29.7037 6.15866L26.2839 7.98731V12.798L30.4102 8.4093L30.382 8.38117L29.7037 6.15866Z" fill="#9C9C9C"/>
                        <path d="M21.9321 8.97688H19.869C19.5581 8.97688 19.3037 8.72369 19.3037 8.41422C19.3037 8.10476 19.5581 7.85156 19.869 7.85156H21.9321C22.243 7.85156 22.4974 8.10476 22.4974 8.41422C22.4974 8.72369 22.243 8.97688 21.9321 8.97688Z" fill="#9C9C9C"/>
                        <path d="M16.3357 8.97688H15.827C15.5161 8.97688 15.2617 8.72369 15.2617 8.41422C15.2617 8.10476 15.5161 7.85156 15.827 7.85156H16.3357C16.6466 7.85156 16.901 8.10476 16.901 8.41422C16.901 8.72369 16.6466 8.97688 16.3357 8.97688Z" fill="#9C9C9C"/>
                        <path d="M17.4946 3.23513H21.2818C21.9036 3.23513 22.4123 2.72874 22.4123 2.10981V1.68782C22.4123 1.06889 21.9036 0.5625 21.2818 0.5625H17.4946C16.8728 0.5625 16.3641 1.06889 16.3641 1.68782V2.13795C16.3923 2.72874 16.8728 3.23513 17.4946 3.23513Z" fill="#F1F1F1"/>
                        <path d="M21.2818 3.79795H17.4946C16.5619 3.79795 15.7988 3.03836 15.7988 2.10997V1.68798C15.7988 0.759591 16.5619 0 17.4946 0H21.2818C22.2145 0 22.9775 0.759591 22.9775 1.68798V2.13811C22.9775 3.03836 22.2145 3.79795 21.2818 3.79795ZM17.4946 1.12532C17.1837 1.12532 16.9293 1.37852 16.9293 1.68798V2.13811C16.9293 2.44757 17.1837 2.70077 17.4946 2.70077H21.2818C21.5927 2.70077 21.847 2.44757 21.847 2.13811V1.68798C21.847 1.37852 21.5927 1.12532 21.2818 1.12532H17.4946Z" fill="#9C9C9C"/>
                        <path d="M25.3804 18.0342H12.86C12.1817 18.0342 11.5599 17.6966 11.1925 17.162L3.67462 6.24643L2.93979 6.80909C2.54411 7.11856 2.03539 7.23109 1.52666 7.14669C1.01793 7.06229 0.593989 6.78096 0.311362 6.35896C-0.225628 5.54311 -0.0277897 4.47405 0.763565 3.88326L1.69623 3.17994C3.02458 2.22342 4.7486 2.16715 6.13347 3.03927L12.7187 7.17482C12.7187 6.3027 13.4252 5.62751 14.3014 5.62751H23.4585L29.5632 2.72981C30.072 2.50474 30.6372 2.47661 31.1742 2.67354C31.6829 2.87047 32.1069 3.29247 32.3047 3.79886L33.8592 7.73748C34.1418 8.44081 34.0005 9.2004 33.4917 9.76306L26.9065 17.3308C26.5109 17.781 25.9739 18.0342 25.3804 18.0342ZM3.70288 5.06485C3.75941 5.06485 3.81593 5.06485 3.87246 5.06485C4.15509 5.12111 4.38119 5.26178 4.55076 5.48684L12.1534 16.515C12.323 16.7682 12.6056 16.9088 12.8883 16.9088H25.4086C25.663 16.9088 25.9173 16.7963 26.0869 16.5994L32.7004 9.0316C32.9265 8.7784 32.983 8.44081 32.8417 8.15948L31.2873 4.22086C31.2025 3.99579 31.0329 3.827 30.8068 3.71446C30.5807 3.63006 30.3263 3.63006 30.1002 3.7426L23.7411 6.72469H14.3297C14.0753 6.72469 13.8774 6.92162 13.8774 7.17482C13.8774 7.59682 13.6513 7.96255 13.2839 8.15948C12.9165 8.35641 12.4926 8.32827 12.1252 8.13134L5.53996 3.99579C4.55076 3.37687 3.30721 3.43313 2.37454 4.10833L1.41361 4.78352C1.10272 5.00858 1.04619 5.40244 1.24403 5.71191C1.35708 5.8807 1.52666 5.9651 1.69623 6.02137C1.89407 6.0495 2.06365 6.02137 2.23322 5.8807L3.0811 5.26178C3.25068 5.14925 3.47678 5.06485 3.70288 5.06485Z" fill="#9C9C9C"/>
                        <path d="M3.92851 21.9997C1.75229 21.9997 0 20.2554 0 18.0892C0 16.6544 1.58271 14.3194 2.93932 12.6033C3.16542 12.2938 3.53283 12.125 3.92851 12.125C4.32419 12.125 4.66334 12.2938 4.91771 12.6033C6.24605 14.3194 7.85702 16.6263 7.85702 18.0892C7.85702 20.2554 6.07647 21.9997 3.92851 21.9997ZM3.92851 13.2503C3.90025 13.2503 3.87199 13.2503 3.84372 13.3066C2.14796 15.4447 1.15877 17.2452 1.15877 18.0892C1.15877 19.6084 2.40233 20.8744 3.95677 20.8744C5.51122 20.8744 6.75478 19.6365 6.75478 18.0892C6.75478 17.2452 5.73732 15.4447 4.06983 13.3066C3.98504 13.2785 3.95677 13.2503 3.92851 13.2503Z" fill="#9C9C9C"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_2442_18634">
                            <rect width="34" height="22" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>

                {{--                    <h4 class="m-0">{{ $item['title'] }}</h4>--}}
                <h4 class="m-0" style="color:#9C9C9C; font-size: 14px; font-weight: 500;">روغن</h4>

            </div>

            {{--            @endforeach--}}
        </div>
        <div class="row text-center text-md-start border border-1 border-gray-600 rounded-4 m-1 p-3 p-md-4" style="background-color:#FFFFFF !important; ">
            <div class="row mb-3 text-center pt-4">
                @php
                    $fitmentGroups = \Botble\Ecommerce\Models\FitmentGroup::with('fitmentAttributes')->get();
                    $fitmentGroupsIds = \Botble\Ecommerce\Models\FitmentGroup::pluck('id')->toArray();
                @endphp
                <div class="col-1 ">
                </div>
                @foreach($fitmentGroups as $key=>$item)
                    <div class="col-5">
                        <label class="custom-radio">
                            <input type="radio"
                                   id="fitmentgroup_{{$item->id}}"
                                   name="filter"
                                   value="fitmentgroup_{{$item->id}}"
                                   @if($key==0) checked @endif
                                   onchange="changeFilter('{{$item->id}}')">
                            <span class="radio-mark"></span>
                            <span class="ms-2" style="font-size: 16px; font-weight: 400;">{{$item->name}}</span>
                        </label>
                    </div>

                @endforeach
                <div class="col-1 ">
                </div>
            </div>
            @foreach($fitmentGroups as $key => $item)
                @php
                    $attrCount = $item->fitmentAttributes->count();
                    $colClass = $attrCount%4 === 1 ? 'row-cols-5' : 'row-cols-4';
                @endphp

                <div id="container_{{ $item->id }}" class="row text-center {{ $colClass }} g-2 @if($key != 0) d-none @endif responsive-padding-x">
                    @foreach($item->fitmentAttributes as $key => $attribute)
                        <div class="@if($key == 0)  col-12 pb-3 @else col-4 @endif col-sm-3">
                            <div class="rounded-3 text-center py-1 mx-md-2 @if($key == 0)  blink-border @endif"
                                 @if($key == 0)
                                 onclick="resetFilter({{$item->id}})"
                                 id="attribute_group_{{ $item->id }}"
                                 data-bs-toggle="modal"
                                 data-bs-target="#Modal_{{ $item->id }}"
                                 @else
                                 style=" background-color: #e3e3e3; border: 1px solid #CED4DA;"
                                @endif>
                                {{ $attribute->name }}
                            </div>
                        </div>

                    @endforeach
                </div>
            @endforeach

        </div>
    </div>
</section>
@foreach($fitmentGroups as $index => $item)
    <div class="modal fade" id="Modal_{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel_{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-dark" style="height: 600px;">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="col-12" id="modal_content{{ $item->id }}">
                            {{-- Stepper --}}
                            <div class="stepper-wrapper" id="ProgressBar{{ $item->id }}">
                                @foreach($item->fitmentAttributes as $key => $attribute)
                                    <div class="stepper-item @if($key == 0) completed active @endif"
                                         id="stepper-item-{{ $item->id }}-{{ $key + 1 }}">
                                        <div class="step-name">{{ $attribute->name }}</div>
                                        <div class="step-counter"></div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- First Step --}}
                            <div id="step-{{ $item->id }}-1" class="step active size-container">
                                {!! $item->fitmentAttributes[0]->icon ?? '' !!}

                                @foreach($item->fitmentAttributes[0]->options as $key => $option)
                                    <div class="rounded-4 border-grey-blue responsive-margin-x m-4
                                         @if($option->children->isEmpty()) disabled @endif"
                                         role="button"
                                         style="cursor: pointer;
                                         @if($option->children->isEmpty()) background-color:#e3e3e3; @endif
                                             border: 1px solid #C7C7C7;"
                                         onclick="addFilter(
                                            'modal_content{{ $item->id }}',
                                            '{{ $option->id }}',
                                            '2',
                                            '{{ $item->id }}',
                                            '{{ $option->attribute_id }}',
                                            event)">
                                        {!! $option->icon ?? '' !!} &nbsp;&nbsp;&nbsp;
                                        {{ $option->value }}
                                    </div>
                                @endforeach
                            </div>
                            {{-- مراحل بعدی به صورت داینامیک در JS اضافه می‌شوند --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{--<div id="loading" class="d-none text-center my-3">در حال بارگذاری...</div>--}}

<script defer>
    var filters = {};
    let currentStep = 1;
    let steps = 1;
{{--    let isLoading = false;--}}
    let fitmentGroupIds = @json($fitmentGroupsIds);

    function addFilter(elementId, parentId, index, fitmentGroupId, attribute_id, event) {
console.log('ddd', window.location.href);
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

{{--    if (isLoading) return;--}}
    {{--    isLoading = true;--}}
    $('#loading').removeClass('d-none');

    filters[attribute_id] = parentId;

    $.ajax({
        type: 'GET',
        url: "{{ route('public.fitment.option.children') }}",
        data: { id: parentId },
        success: (res) => {
            if (res.data && res.data.length > 0) {
                if (res.data[0].attribute.children) steps += 1;

                renderFitmentStep(res.data[0].attribute.id, res.data, elementId, fitmentGroupId);
                nextStep(fitmentGroupId);
            } else {
                submitSearch();
            }
        },
        error: (err) => {
            console.error("AJAX Error:", err);
        },
        complete: () => {
{{--            isLoading = false;--}}
    $('#loading').addClass('d-none');
}
});
}


function renderFitmentStep(attribute_id, options, modalContentId = 0, fitmentGroupId) {
const stepId = `step-${fitmentGroupId}-${currentStep + 1}`;

// حذف مرحله قبلی (در صورت وجود) برای جلوگیری از اضافه شدن بی‌رویه
if ($(`#${stepId}`).length) {
$(`#${stepId}`).remove();
}

let html = `<div id="${stepId}" class="step d-none">`;
html += options[0]?.attribute?.icon ?? '';

options.forEach((option, key) => {
if (key % 3 === 0) html += `<div class="row row-cols-3 my-2 g-2 size-container">`;

html += `
    <div class="col">
        <div class="rounded-3 py-2 text-center border"
             style="cursor: pointer;"
             onclick="addFilter('${modalContentId}','${option.id}','${currentStep + 2}','${fitmentGroupId}','${attribute_id}', event)">
            ${option.value}
        </div>
    </div>`;

if ((key + 1) % 3 === 0 || key === options.length - 1)
    html += `</div>`;
});

html += `
<div class="fitment-footer mt-3">
    <button type="button" class="btn type-prev-step w-100" style="color: #314088 !important;" onclick="prevStep('${fitmentGroupId}')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M9 4.5L16.5 12L9 19.5" stroke="#314088" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        مرحله قبل
    </button>
</div>
</div>`;

$('#' + modalContentId).append(html);
}


function nextStep(fitmentGroupId) {
if (currentStep === steps) {
    submitSearch();
    return;
}

$(`#stepper-item-${fitmentGroupId}-${currentStep}`).removeClass('active').addClass('completed');
$(`#stepper-item-${fitmentGroupId}-${currentStep + 1}`).addClass('active');

$(`#step-${fitmentGroupId}-${currentStep}`).removeClass('active').addClass('d-none');
$(`#step-${fitmentGroupId}-${currentStep + 1}`).removeClass('d-none').addClass('active');

currentStep++;
}

function prevStep(fitmentGroupId) {
if (currentStep > 1) {
    $(`#stepper-item-${fitmentGroupId}-${currentStep}`).removeClass('active');
    $(`#stepper-item-${fitmentGroupId}-${currentStep - 1}`).removeClass('completed').addClass('active');

    $(`#step-${fitmentGroupId}-${currentStep}`).removeClass('active').addClass('d-none');
    $(`#step-${fitmentGroupId}-${currentStep - 1}`).removeClass('d-none').addClass('active');

    currentStep--;
}
}

function changeFilter(id) {
resetFilter(id);
$('[id^="container_"]').addClass('d-none');
$('#container_' + id).removeClass('d-none');
}

function resetFilter() {
fitmentGroupIds.forEach(item => {
    for (let i = 2; i <= 5; i++) {
        $('#step-' + item + '-' + i).remove();
        $('#stepper-item-' + item + '-' + i).removeClass('active completed');
    }

    $('#step-' + item + '-1').removeClass('d-none').addClass('active');
    $('#stepper-item-' + item + '-1').addClass('active');
});

currentStep = 1;
steps = 1;
filters = {};
}

function submitSearch() {
const url = "{{ route('public.products') }}";
        const params = new URLSearchParams({ fitments: JSON.stringify(filters) });

        window.location.href = url + '?' + params.toString();
    }
</script>

<style>
    .modal-header {
        position: relative;
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-header .btn-close {
        position: absolute;
        right: 1rem;
        top: 75%;
        transform: translateY(-50%);
    }

    #searchConteinerShortCode {
        width: 100%;
        margin: 0 auto;
    }
    .responsive-padding-x {
        padding-left: 8px;
        padding-right: 8px;
        padding-bottom: 16px;
    }

    @media (min-width: 992px) { /* lg breakpoint in Bootstrap */
        .responsive-padding-x {
            padding-left: 80px;
            padding-right: 80px;
            padding-bottom: 40px;
        }
    }
    .responsive-margin-x {
        display: flex;
        align-items: center;      /* وسط‌چینی عمودی */
        justify-content: center;  /* وسط‌چینی افقی */
        height: 60px !important;
        margin-left: 8px;
        margin-right: 8px;
        margin-bottom: 4px;
    }

    @media (min-width: 992px) {
        .responsive-margin-x {
            margin-left: 80px;
            margin-right: 80px;
        }
    }

    /*@media (min-width: 576px) {*/
    /*    #searchConteinerShortCode {*/
    /*        width: 60%;*/
    /*    }*/
    /*}*/

    @keyframes blink {
        0% {
            opacity: 1;
            box-shadow: 0 0 8px #314088;
        }
        50% {
            opacity: 0.5;
            box-shadow: 0 0 12px #314088;
        }
        100% {
            opacity: 1;
            box-shadow: 0 0 18px #314088;
        }
    }

    .blink-border {
        animation: blink 3s infinite;
        border: 2px solid #314088 !important;
        border-radius: 8px; /* اختیاری */
    }


    .size-container div {
        /*border: 1px solid #C7C7C7;*/
        text-align: center;
        /*margin-top: 1px;*/
        /*margin-bottom: 5px;*/
    }
    .prev-step{
        text-align: center;
    }
    .stepper-wrapper {
        font-family: Arial;
        margin-top: 50px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    @media (max-width: 768px) {
        font-size: 12px;
    }
    }

    .stepper-item::before {
        position: absolute;
        content: "";
        border-bottom: 2px solid #ccc;
        width: 100%;
        top: 70%;
        transform: translateY(-70%);
        left: -50%;
        z-index: 2;
    }

    .stepper-item::after {
        position: absolute;
        content: "";
        border-bottom: 2px solid #ccc;
        width: 100%;
        top: 70%;
        transform: translateY(-70%);
        left: 50%;
        z-index: 2;
    }

    .stepper-item .step-counter {
        position: relative;
        z-index: 5;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #ccc;
        margin-bottom: 6px;
        color: white;
        font-size: 12px;
    }

    .stepper-item.active {
        font-weight: bold;
        color: #9D503C;
        /*border: #9D503C 1px solid;*/
    }

    .stepper-item.active .step-counter {
        background: #fff !important;
        border: 2px solid #9D503C;
        color: #9D503C;
        font-weight: bold;
    }


    .stepper-item.completed .step-counter {
        background-color: #9D503C;
    }

    .stepper-item.completed::after {
        position: absolute;
        content: "";
        border-bottom: 2px solid #9D503C;
        width: 100%;
        top: 70%;
        transform: translateY(-70%);
        left: 50%;
        z-index: 3;
    }

    /*.stepper-item:first-child::before {*/
    /*    content: none;*/
    /*}*/
    /*.stepper-item:last-child::after {*/
    /*    content: none;*/
    /*}*/
    .stepper-item:first-child::after,
    .stepper-item:last-child::before {
        content: none;
    }
    #searchConteinerShortCode {
        position: relative;
        padding: 20px 0;
        z-index: 1;
        overflow: hidden;
    }

    /* فقط نیمه بالای بخش، بک‌گراند داره */
    #searchConteinerShortCode::before {
        content: "";
        position: absolute;
        top: 10%; /* فاصله از بالا */
        left: 0;
        width: 100%;
        height: 80%; /* از ۱۰٪ تا ۹۰٪ (یعنی بین بالا و پایین ۱۰٪ فاصله هست) */
        background-image: url('/Pattern.png');
        background-size: cover; /* یا contain یا اندازه دلخواه */
        background-position: center top;
        background-repeat: no-repeat;
        z-index: -1;
    }


    .custom-radio {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
        position: relative;
    }

    .custom-radio input[type="radio"] {
        display: none;
    }

    .radio-mark {
        width: 16px;
        height: 16px;
        border: 2px solid #ccc;
        border-radius: 50%;
        position: relative;
        display: inline-block;
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    .radio-mark::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 8px;
        height: 8px;
        background-color: #314088; /* رنگ قرمز */
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        transition: transform 0.2s ease;
    }

    /* وقتی radio انتخاب شده باشه */
    .custom-radio input[type="radio"]:checked + .radio-mark::after {
        transform: translate(-50%, -50%) scale(1);
    }

    .fitment-footer {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        padding: 0 15px;
    }
</style>


