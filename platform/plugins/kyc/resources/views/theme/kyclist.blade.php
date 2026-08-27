@php
    use Botble\Ecommerce\Models\FitmentGroup;
    use Botble\Ecommerce\Enums\ProductFitmentTypeEnum;

    Theme::layout('full-width');

    $fitmentGroup = FitmentGroup::where('type', ProductFitmentTypeEnum::CAR)
        ->with('fitmentAttributes')
        ->first();

    $cars = [];
@endphp

<section class="tp-cart-area pb-120">
    <div class="app-content container center-layout mt-2">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a style="color:#314088 !important;" href="{{ route('customer.overview') }}">خانه</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a style="color:#314088 !important;" href="{{ route('public.kyc.showkycs') }}">سبد خرید</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a style="color:#314088 !important;" href="{{ route('public.kyc.showkycs') }}">خدمات</a>
                                </li>
                                <li class="breadcrumb-item active">تکمیل اطلاعات</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="vertical-tabs">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-content collapse show">
                                <form id="kyc-form" enctype="multipart/form-data">
                                    @csrf
                                    @foreach($kyc->groupfields as $key => $groupfield)
                                        <div class="card m-4 p-4">
                                            <div class="card-body">
                                                <p style="font-size: 16px; font-weight: 400;">{{ $groupfield->group_field_name }}</p>
                                                <fieldset>
                                                    @foreach($groupfield->fields as $field)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    @if($field->field_type == 'file')
                                                                        <div class="form-group col-md-6">
                                                                            <label>{{ $field->field_name }}</label>
                                                                            <div class="form-control d-flex flex-column align-items-center justify-content-center text-center"
                                                                                 id="file-alternate-{{ $field->id }}"
                                                                                 title="لطفا {{ $field->field_name }} را بارگزاری کنید."
                                                                                 style="@if(!empty($field->submissions)) background-image: url('{{ RvMedia::getImageUrl($field->submissions->value) }}'); @endif max-height: 300px; min-height: 150px; cursor: pointer; margin-bottom: 10px; background-color:#F8F9FA; border-radius: 12px !important;"
                                                                                 onclick="uploadkycfile({{ $field->id }})">

                                                                                <div class="d-flex flex-column align-items-center justify-content-center">
                                                                                    <x-core::icon name="ti ti-plus" style="font-size: 36px;color:#314088;" />
                                                                                    <p id="file-alternate-add-{{ $field->id }}" class="mt-2 mb-0" style="color:#314088;">برای بارگزاری {{ $field->field_name }} کلیک کنید.</p>
                                                                                </div>
                                                                            </div>

                                                                            <input type="file"
                                                                                   class="d-none"
                                                                                   id="file-upload-{{ $field->id }}"
                                                                                   alternate="file-alternate-{{ $field->id }}"
                                                                                   title="لطفا {{ $field->field_name }} را بارگزاری کنید."
                                                                                   class="form-control"
                                                                                   field_id="{{ $field->id }}"
                                                                                   name="fields[{{ $field->id }}]"
                                                                                   @if($field->is_required && empty($field->submissions)) required @endif
                                                                                   onchange="previewImage(event, {{ $field->id }})"
                                                                                   accept=".jpg, .jpeg, .png, .heic, .heif" />
                                                                        </div>
                                                                    @elseif($field->field_type == 'car')

                                                                        <div class="form-group col-md-6">
                                                                            <div class="form-control d-flex align-items-center justify-content-center gap-2 btn "
                                                                                 style="border-radius: 12px !important; height: 50px; cursor: pointer;"
                                                                                 data-bs-toggle="modal"
                                                                                 data-bs-target="#Modal_{{ $fitmentGroup->id }}">

                                                                                <input type="text" id="carinput" hidden name="fields[{{ $field->id }}]" value="{{ $field->submissions ? $field->submissions->value : '' }}">

                                                                                <span id="carbtn" class="d-flex align-items-center gap-2">
            @if($field->submissions)
                                                                                        <x-core::icon name="ti ti-edit" style="font-size: 20px;" />
                                                                                        @if($field->submissions->value)
                                                                                            @php
                                                                                                $values = collect(json_decode($field->submissions->value, true))->pluck('value')->implode(' ');
                                                                                            @endphp
                                                                                            <span>{{ $values }}</span>
                                                                                        @endif
                                                                                    @else
                                                                                        {{--                                                                                        <x-core::icon name="ti ti-plus" style="font-size: 20px;color:#314088;" />--}}
                                                                                        <div style="position: relative; width: 20px; height: 20px; font-size: 14px; font-weight: 700;">
    <!-- دایره SVG -->
    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="9" cy="9" r="9" fill="#314088" />
    </svg>

                                                                                            <!-- آیکون در مرکز -->
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <x-core::icon name="ti ti-plus" style="font-size: 12px; color: #fff;" />
    </div>
</div>


                                                                                        <span style="color:#314088; text-decoration: none !important; font-size: 14px; font-weight: 700;">افزودن خودرو</span>
                                                                                    @endif
        </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="modal fade" id="Modal_{{$fitmentGroup->id}}" tabindex="-1" aria-labelledby="modalLabel_{{$fitmentGroup->id}}" aria-hidden="true" >
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content text-dark" style="height: 600px;">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body text-center">
                                                                                        <div class="row">
                                                                                            <div class="col-12 " id="modal_content{{$fitmentGroup->id}}">
                                                                                                <div class="stepper-wrapper" id="ProgressBar{{$fitmentGroup->id}}">
                                                                                                    @foreach($fitmentGroup->fitmentAttributes as $key=>$attribute)
                                                                                                        {{--                                    @dd($attribute->children)--}}
                                                                                                        <div class="stepper-item @if($key==0)completed active @endif" id="stepper-item-{{$fitmentGroup->id}}-{{$key+1}}">
                                                                                                            <div class="step-name">{{$attribute->name}}</div>
                                                                                                            <div class="step-counter"></div>
                                                                                                        </div>
                                                                                                    @endforeach
                                                                                                </div>
                                                                                                <div id="step-{{$fitmentGroup->id}}-1" class="step active size-container">
                                                                                                    {!! $fitmentGroup->fitmentAttributes[0]->icon?$fitmentGroup->fitmentAttributes[0]->icon:'' !!}

                                                                                                    @foreach($fitmentGroup->fitmentAttributes[0]->options as $key=>$option)
                                                                                                        {{--                                    @dd($item->fitmentAttributes[0]->options[2]->children)--}}
                                                                                                        <div class="rounded-4 border-grey-blue  responsive-margin-x m-4 @if($option->children->isEmpty()) disabled @endif" style="@if($option->children->isEmpty()) background-color:#e3e3e3; @endif border: 1px solid #C7C7C7;" onclick="addFilter('modal_content{{$fitmentGroup->id}}','{{$option->id}}','2','{{$fitmentGroup->id}}','{{$option->attribute_id}}')">
                                                                                                            {!! $option->icon?$option->icon:'' !!} &nbsp;&nbsp;&nbsp;
                                                                                                            {{$option->value}}
                                                                                                        </div>
                                                                                                    @endforeach
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        {{--                                                                        <div class="modal fade"--}}
                                                                        {{--                                                                             id="Modal_{{ $fitmentGroup->id }}"--}}
                                                                        {{--                                                                             tabindex="-1"--}}
                                                                        {{--                                                                             aria-labelledby="modalLabel_{{ $fitmentGroup->id }}"--}}
                                                                        {{--                                                                             aria-hidden="true">--}}
                                                                        {{--                                                                            <div class="modal-dialog">--}}
                                                                        {{--                                                                                <div class="modal-content text-dark" style="height: 600px;">--}}
                                                                        {{--                                                                                    <div class="modal-header">--}}
                                                                        {{--                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
                                                                        {{--                                                                                    </div>--}}
                                                                        {{--                                                                                    <div class="modal-body text-center">--}}
                                                                        {{--                                                                                        <div class="row">--}}
                                                                        {{--                                                                                            <div class="col-12" id="modal_content{{ $fitmentGroup->id }}">--}}
                                                                        {{--                                                                                                <div class="stepper-wrapper" id="ProgressBar{{ $fitmentGroup->id }}">--}}
                                                                        {{--                                                                                                    @foreach($fitmentGroup->fitmentAttributes as $key => $attribute)--}}
                                                                        {{--                                                                                                        <div class="stepper-item @if($key == 0) completed active @endif"--}}
                                                                        {{--                                                                                                             id="stepper-item-{{ $fitmentGroup->id }}-{{ $key + 1 }}">--}}
                                                                        {{--                                                                                                            <div class="step-name">{{ $attribute->name }}</div>--}}
                                                                        {{--                                                                                                            <div class="step-counter">{{ $key + 1 }}</div>--}}
                                                                        {{--                                                                                                        </div>--}}
                                                                        {{--                                                                                                    @endforeach--}}
                                                                        {{--                                                                                                </div>--}}

                                                                        {{--                                                                                                <div id="step-{{ $fitmentGroup->id }}-1" class="step active size-container">--}}
                                                                        {{--                                                                                                    {!! $fitmentGroup->fitmentAttributes[0]->icon ?? '' !!}--}}
                                                                        {{--                                                                                                    @foreach($fitmentGroup->fitmentAttributes[0]->options as $option)--}}
                                                                        {{--                                                                                                        <div class="rounded-3 border-grey-blue m-1"--}}
                                                                        {{--                                                                                                             onclick="addFilter('modal_content{{ $fitmentGroup->id }}','{{ $option->id }}','2','{{ $fitmentGroup->id }}','{{ $option->attribute_id }}','{{ $option->value }}')">--}}
                                                                        {{--                                                                                                            {!! $option->icon ?? '' !!}--}}
                                                                        {{--                                                                                                            {{ $option->value }}--}}
                                                                        {{--                                                                                                        </div>--}}
                                                                        {{--                                                                                                    @endforeach--}}
                                                                        {{--                                                                                                </div>--}}
                                                                        {{--                                                                                            </div>--}}
                                                                        {{--                                                                                        </div>--}}
                                                                        {{--                                                                                    </div>--}}
                                                                        {{--                                                                                </div>--}}
                                                                        {{--                                                                            </div>--}}
                                                                        {{--                                                                        </div>--}}

                                                                    @else
                                                                        <div class="form-group col-md-6">
                                                                            <label>{{ $field->field_name }}</label>
                                                                            <input type="text"
                                                                                   title="لطفا {{ $field->field_name }} را وارد کنید."
                                                                                   @if($field->field_type=='nationalcode')
                                                                                   onchange="nationalCode()"
                                                                                   @elseif($field->field_type=='vin')
                                                                                   onchange="vin()"
                                                                                   @endif
                                                                                   class="form-control"
                                                                                   field_id="{{ $field->id }}"
                                                                                   name="fields[{{ $field->id }}]"
                                                                                   value="{{ $field->submissions->value ?? '' }}"
                                                                                   @if($field->is_required) required @endif />
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </fieldset>
                                            </div>
                                        </div>
                                    @endforeach
                                    <br>
                                    {{--                                    <button class="btn btn-primary m-4" type="submit" onclick="submitKYC()" style="width: 338px;height: 40px;  left: 26px;  border-radius: 12px !important;">ثبت اطلاعات</button>--}}
                                    <button id="submit-btn" class="btn btn-primary m-4" type="button" onclick="submitKYC()" style="width: 338px; height: 40px; left: 26px; border-radius: 12px !important;">
                                        <span class="btn-text">ثبت اطلاعات</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>


                                    <div id="resultBox" class="invalid-feedback d-block">

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div id="smartErrorModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#f44336" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M7.938 2.016a.13.13 0 0 1 .125 0l6.857 11.856c.048.083.053.186.014.272a.246.246 0 0 1-.225.141H1.291a.247.247 0 0 1-.225-.141.25.25 0 0 1 .014-.272L7.937 2.016zm.813-.41a1.13 1.13 0 0 0-1.002 0L.892 13.46C.386 14.3.976 15.5 1.792 15.5h12.416c.816 0 1.406-1.2.9-2.04L8.75 1.605zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </div>
                    <h5 class="mb-2 fw-bold">فایل خیلی بزرگه</h5>
                    <p class="text-muted small mb-3">لطفاً فایلی با حجم کمتر از 10 مگابایت انتخاب کن.</p>
                    <button type="button" class="btn btn-outline-danger btn-sm px-4" data-bs-dismiss="modal">باشه</button>
                </div>
            </div>
        </div>
    </div>


</section>

<style>
    .size-container div {
        border: 1px solid #C7C7C7;
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
        top: 35px;
        left: -50%;
        z-index: 2;
    }

    .stepper-item::after {
        position: absolute;
        content: "";
        border-bottom: 2px solid #ccc;
        width: 100%;
        top: 35px;
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
    }

    .stepper-item.active {
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
        top: 35px;
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

</style>
<script>
    var filters={};
    let currentStep = 1;
    let steps = 1;

    function addFilter(elementId,parentId,index,fitmentGroupId,attribute_id,optionValue) {
        filters[attribute_id] = {
            id: parentId,
            value: optionValue
        };

        const data = {
            id: parentId,
        };

        const actionMethod = 'GET'; // Or 'POST', depending on your route

        $.ajax({
            type: actionMethod,
            url: "{{ route('public.fitment.option.children') }}",
            data: data,
            success: (res) => {
                if (res.data && res.data.length > 0) {
                    if(res.data[0].attribute.children)
                        steps+=1;
                    renderFitmentStep(res.data[0].attribute.id,res.data, elementId,fitmentGroupId);
                    nextStep(fitmentGroupId);
                }else{
                    submitSearch("Modal_{{$fitmentGroup->id}}" );
                }
            },
            error: (res) => {
                console.error(res);
            },
        });
    }
    function renderFitmentStep(attribute_id,options, modalContentId = 0,fitmentGroupId) {
        const stepId = `step-${fitmentGroupId}-${currentStep+1}`;
        if ($(`#${stepId}`).length) {
            $(`#${stepId}`).remove();
        }
        var html='';
        html+=`<div id="${stepId}" class="step d-none">`;
        // console.log(options);
        html += options[0]?.attribute?.icon ?? '';

        options.forEach((option, key) => {
            if (key % 3 === 0)
                html += `<div class="row row-cols-3 g-2 size-container">`;

            html += `<div class="rounded-3 col py-1"  onclick="addFilter('${modalContentId}','${option.id}','${currentStep+2}','${fitmentGroupId}','${attribute_id}','${option.value}')">${option.value}</div>`;

            if ((key + 1) % 3 === 0 || key ===options.length - 1)
                html += `</div>`;
        });
        html += `<button type="button" class="btn btn-link type-prev-step" onclick="prevStep('${fitmentGroupId}')">
مرحله قبلی
</button>`;
        html += `</div>`;

        $('#'+modalContentId).append(html);

    }
    function nextStep(fitmentGroupId) {
        if (currentStep == steps) {
            submitSearch(); // or any other logic when steps end
            return;
        }

        // Update stepper classes
        document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep}`).classList.remove('active');
        document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep}`).classList.add('completed');
        document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep + 1}`).classList.add('active');

        // Hide current step content and show next
        document.getElementById(`step-${fitmentGroupId}-${currentStep}`).classList.remove('active');
        document.getElementById(`step-${fitmentGroupId}-${currentStep}`).classList.add('d-none');
        document.getElementById(`step-${fitmentGroupId}-${currentStep + 1}`).classList.remove('d-none');
        document.getElementById(`step-${fitmentGroupId}-${currentStep + 1}`).classList.add('active');

        currentStep++;
    }
    function prevStep(fitmentGroupId) {
        if (currentStep > 1) {
            document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep}`).classList.remove('active');
            // document.getElementById('size_stepper-item_'+(currentWidthStep)).classList.remove('completed');
            document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep-1}`).classList.add('active');
            document.getElementById(`stepper-item-${fitmentGroupId}-${currentStep-1}`).classList.remove('completed');
            document.getElementById(`step-${fitmentGroupId}-${currentStep}`).classList.remove('active');
            document.getElementById(`step-${fitmentGroupId}-${currentStep}`).classList.add('d-none');
            document.getElementById(`step-${fitmentGroupId}-${currentStep-1}`).classList.remove('d-none');
            document.getElementById(`step-${fitmentGroupId}-${currentStep-1}`).classList.add('active');
            currentStep--;
        }
    }

    function submitSearch() {
        const values = Object.values(filters).map(f => f.value).join(' ');
        $('#carbtn').html(`<x-core::icon name="ti ti-edit" /> ` + values);
        $('#carinput').val(JSON.stringify(filters));
        $('#Modal_{{$fitmentGroup->id}}').modal('hide'); // ✅ Proper way to close modal
        console.log(filters);
    }
    function previewImage(event, fieldId) {
        const fileInput = event.target;
        const filePreview = document.getElementById(`file-alternate-${fieldId}`);
        // const finalFilePreview = document.getElementById(`final-file-preview-${fieldId}`);

        // Clear previous previews
        filePreview.innerHTML = '';
        // finalFilePreview.innerHTML = '';
        filePreview.removeAttribute('style'); // Reset any prior background styles

        const file = fileInput.files?.[0];

        if (file && file.type.startsWith('image')) {
            const reader1 = new FileReader();
            // const reader2 = new FileReader();

            // Background image preview
            reader1.onload = function (e) {
                filePreview.style.backgroundImage = `url('${e.target.result}')`;
                filePreview.style.backgroundSize = "cover";
                filePreview.style.backgroundPosition = "center";
                filePreview.style.width = "100%";    // responsive layout
                filePreview.style.minWidth = "150px";
                filePreview.style.minHeight = "150px";
            };
            reader1.readAsDataURL(file);

        }
    }


    function uploadkycfile(fieldId) {
        const fileInput = document.getElementById(`file-upload-${fieldId}`);
        fileInput.click();
    }

    function submitKYC() {
        const submitBtn = document.getElementById("submit-btn");
        const btnText = submitBtn.querySelector(".btn-text");
        const spinner = submitBtn.querySelector(".spinner-border");

        // بررسی حجم فایل‌ها (بیش از 1MB)
        let oversized = false;
        $("input[type='file']").each(function () {
            if (this.files.length > 0) {
                if (this.files[0].size > 10240 * 1024) {
                    oversized = true;
                    return false;
                }
            }
        });

        if (oversized) {
            const errorModal = new bootstrap.Modal(document.getElementById('smartErrorModal'));
            errorModal.show();
            return;
        }

        // فعال کردن لودینگ
        submitBtn.disabled = true;
        btnText.classList.add("d-none");
        spinner.classList.remove("d-none");

        let formData = new FormData($("#kyc-form")[0]);

        $("input[type='file']").each(function () {
            if (this.files.length > 0) {
                formData.append($(this).attr("name"), this.files[0]);
            }
        });

        $.ajax({
            url: '{{ route('public.kyc.nextStep') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === "success") {
                    window.location.href = response.redirect_to;
                } else {
                    $("#resultBox").text(response.message);
                }
            },
            error: function(error) {
                $('#resultBox').text('خطایی رخ داده است.');
                console.error(error.message);
            },
            complete: function () {
                submitBtn.disabled = false;
                btnText.classList.remove("d-none");
                spinner.classList.add("d-none");
            }
        });
    }



    function nationalCode() {
        const input = event.target;
        const code = input.value.trim();

        // حذف پیام خطا قدیمی اگر وجود داشته باشد
        const oldError = input.nextElementSibling;
        if (oldError && oldError.classList.contains('text-danger')) {
            oldError.remove();
        }
        input.classList.remove('is-invalid');

        if (!/^\d{10}$/.test(code) || /^(\d)\1{9}$/.test(code)) {
            showNationalCodeError(input, "کد ملی باید ۱۰ رقم معتبر باشد.");
            return;
        }

        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(code.charAt(i)) * (10 - i);
        }

        const remainder = sum % 11;
        const checkDigit = parseInt(code.charAt(9));
        const isValid = (remainder < 2) ? (checkDigit === remainder) : (checkDigit === (11 - remainder));

        if (!isValid) {
            showNationalCodeError(input, "کد ملی معتبر نیست.");
        }
    }
    function vin() {
        const input = event.target;
        const value = input.value.trim();

        // حذف پیام خطا قدیمی اگر وجود داشته باشد
        const oldError = input.nextElementSibling;
        if (oldError && oldError.classList.contains('text-danger')) {
            oldError.remove();
        }
        input.classList.remove('is-invalid');

        // بررسی اینکه دقیقا ۶ رقم عددی باشد
        if (!/^\d{6}$/.test(value)) {
            input.classList.add('is-invalid');

            const error = document.createElement('div');
            error.className = 'text-danger mt-1';
            error.innerText = "شماره شاسی باید فقط شامل ۶ رقم عددی باشد.";

            input.parentNode.appendChild(error);

            input.value = "";
            input.focus();
        }
    }
    function showNationalCodeError(input, message) {
        input.value = "";
        input.focus();
        input.classList.add('is-invalid');

        const error = document.createElement('div');
        error.className = 'text-danger mt-1';
        error.innerText = message;

        input.parentNode.appendChild(error);
    }
</script>
