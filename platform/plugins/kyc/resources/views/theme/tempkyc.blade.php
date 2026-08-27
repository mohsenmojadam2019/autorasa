@extends('plugins/kyc::theme.master')

@section('title', __('KYC'))

@section('content')

    <div class="app-content container center-layout mt-2">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header col-md-6 col-12">
                    <div class="media width-250 float-start">
                        <div class="media-body media-right p-2">
                            {{--                            <img src="https://www.autorasa.com/storage/main/general/logo-autorasa-farsi-2.png" alt="Logo" style="height: 50px;">--}}
                            @php
                                $logo = theme_option('logo');
                                $logoLight = theme_option('logo_light');
                                    $height = theme_option('logo_height', 35);
                                    $attributes = [
                                    'style' => sprintf('height: %s', is_numeric($height) ? "{$height}px" : $height),
                                    'loading' => false,
                                ];
                            @endphp
                            {{ RvMedia::image($logoLight ?: $logo, theme_option('site_title'), attributes: ['class' => 'logo-light', ...$attributes]) }}
                        </div>
                    </div>
                </div>
                <div class="content-header col-md-6 col-12 mb-2">
                    <h3 class="content-header-title mb-0">
                        فرم احراز هویت
                    </h3>
                    <br>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb" style="font-family: Ravi !important;">
                                <li class="breadcrumb-item"><a style="color:#314088 !important;"
                                                               href="{{ route('customer.overview') }}">پنل کاربری</a>
                                </li>
                                <li class="breadcrumb-item"><a style="color:#314088 !important;"
                                                               href="{{ route('public.kyc.showkycs') }}">احراز هویت</a>
                                </li>
                                <li class="breadcrumb-item active">فرم احراز هویت</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Form wizard with number tabs section start -->
                <section id="vertical-tabs">
                    <div class="row">
                        <div class="col-12">
                            <div class="card" id="stepmenu">
                                <div class="card-header">
                                    <h4 class="card-title">فرم احراز هویت</h4>
                                    {{--                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-h font-medium-3"></i></a>--}}
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form id="kyc-form" enctype="multipart/form-data"
                                              class="vertical-tab-steps wizard-circle">
                                        @csrf
                                        <!-- Step 1 -->
                                            @foreach($kyc->groupfields as $key => $groupfield)
                                                <h6>{{$groupfield->group_field_name}}</h6>
                                                <fieldset>
                                                @foreach($groupfield->fields as $field)
                                                    <!-- Inside your form loop -->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    @if($field->field_type == 'file')
                                                                        <div class="form-group col-md-6">
                                                                            <label>{{ $field->field_name }}</label>
                                                                            <div id="file-alternate-{{ $field->id }}"
                                                                                 title="لطفا {{$field->field_name}} را بارگزاری کنید."
                                                                                 style=" @if(!empty($field->submissions)) background-image: url('{{ RvMedia::getImageUrl($field->submissions->value) }}'); @endif  max-width: 300px;max-height: 300px; min-height: 150px; min-width: 150px; border: 2px dashed #ccc; display: flex;align-items: center; justify-content: center; cursor: pointer;margin-bottom: 10px; background-color:#F8F9FA; border-radius: 12px !important;"
                                                                                 onclick="uploadkycfile({{ $field->id }})">
                                                                                <div class="fa"></div>
                                                                                <br>
                                                                                <p id="file-alternate-add-{{ $field->id }}" >برای بارگزاری فایل کلیک کنید.</p>
                                                                            </div>
                                                                            <input type="file" class="d-none"
                                                                                   id="file-upload-{{ $field->id }}"
                                                                                   alternate="file-alternate-{{ $field->id }}"
                                                                                   title="لطفا {{$field->field_name}} را بارگزاری کنید."
                                                                                   class="form-control"
                                                                                   field_id="{{ $field->id }}"
                                                                                   name="fields[{{ $field->id }}]"
                                                                                   @if($field->is_required and empty($field->submissions))  {{'required'}} @endif onchange="previewImage(event, {{ $field->id }})"
                                                                                   accept=".jpg, .jpeg, .png, .heic, .heif"/>
                                                                        </div>
{{--                                                                        <div class="file-preview p-2 col-md-6"--}}
{{--                                                                             id="file-preview-{{ $field->id }}">--}}
{{--                                                                            @if(!empty($field->submissions))--}}
{{--                                                                                <img--}}
{{--                                                                                    src="{{ $field->submissions?RvMedia::getImageUrl($field->submissions->value):'' }}"--}}
{{--                                                                                    alt="{{ __('Preview') }}"--}}
{{--                                                                                    class="img-thumbnail" width="200"--}}
{{--                                                                                    height="100"--}}
{{--                                                                                    style="border-radius: 12px !important;"--}}
{{--                                                                                >--}}
{{--                                                                            @endif--}}
{{--                                                                        </div>--}}
                                                                    @else
                                                                        <div class="form-group col-md-6">
                                                                            <label>{{ $field->field_name }}</label>
                                                                            <input type="{{ $field->field_type }}"
                                                                                   title="لطفا {{$field->field_name}} را وارد کنید."
                                                                                   class="form-control"
                                                                                   field_id="{{ $field->id }}"
                                                                                   name="fields[{{ $field->id }}]"
                                                                                   value="{{ $field->submissions->value ?? '' }}"
                                                                                   @if($field->is_required) required
                                                                                   @endif onchange="previewResult(event, {{ $field->id }})"/>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </fieldset>
                                            @endforeach
                                            <h6>نتایج نهایی</h6>
                                            <fieldset>
                                                <div class="row g-5">
                                                    @foreach($kyc->groupfields as $key => $groupfield)
                                                        <div class="col-12 col-md-6 " style="padding: 10px;">
                                                            <h6 class="text-center">
                                                                {{$groupfield->group_field_name}}
                                                            </h6>
                                                            <hr>
                                                            @foreach($groupfield->fields as $field)


                                                                @if($field->field_type == 'file')
                                                                    <div class="m-3"><b> {{$field->field_name}} </b>
                                                                    </div>
                                                                    <div class="file-preview p-2 col-md-6 m-3"
                                                                         id="final-file-preview-{{ $field->id }}">
                                                                        @if(!empty($field->submissions))
                                                                            <img
                                                                                style="border-radius: 12px !important;"
                                                                                src="{{RvMedia::getImageUrl($field->submissions->value) }}"
                                                                                alt="{{ __('Preview') }}"
                                                                                class="img-thumbnail" width="160"
                                                                                height="160">
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="m-3">
                                                                        <b> {{$field->field_name}} </b>
                                                                        <span id="final-input-preview-{{ $field->id }}">
                                                                        @if(!empty($field->submissions))
                                                                                {{$field->submissions->value}}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card d-none" id="stepmenusuccessresult">
                                <div class="card-header">
                                    <h4 class="card-title p-4 justify-content-center text-center"
                                        style="border-radius: 15px !important; color:#000000; font-size: 20px; line-height: 24px; font-weight: 700;">

                                        تایید ثبت اطلاعات
                                    </h4>
                                    <hr>
                                </div>
                                <div class="card-content" style="padding:5px 5px 200px 5px;">
                                    <div class="card-body p-1 justify-content-center text-center"
                                         style="border-radius: 15px !important;">
                                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="40" cy="40" r="38.5" fill="#20C997" stroke="#79DFC1"
                                                    stroke-width="3"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M60.1396 27.3134L37.2114 55.9816L19.2002 40.9705L22.5985 36.8925L36.4468 48.4309L55.9979 24L60.1396 27.3134V27.3134Z"
                                                  fill="white"/>
                                        </svg>
                                        <br>
                                        <div
                                            style="color:#000000; font-size: 16px; line-height: 24px; font-weight: 700; padding-top: 25px; padding-bottom: 25px;">
                                            اطلاعات شما ثبت شد و پس از بررسی تایید خواهد شد.
                                        </div>
                                        <p>شما تا  <span id="countdown" class="text-danger">5</span> ثانیه دیگر به صفحه پرداخت منتقل می شوید.</p>
                                        <a id="continueshopingbtn" href="" class="btn"
                                           style=" font-size: 16px;color:#FFFFFF; width: 165px; line-height: 24px; font-weight: 700; background-color: #33519A;">
                                           فاکتور خرید
                                        </a>
                                        <br>
                                        <br>
                                        <a href="{{ route('public.index') }}" class="btn btn-link"
                                           style="width: 165px; color:#33519A; font-size: 16px; line-height: 24px; font-weight: 700; ">
                                            رفتن به صفحه خانه
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card d-none" id="stepmenuerrorresult">
                                <div class="card-header">
                                    <h4 class="card-title p-4 justify-content-center text-center"
                                        style="border-radius: 15px !important; color:#000000; font-size: 20px; line-height: 24px; font-weight: 700;">

                                        خطا در ثبت اطلاعات
                                    </h4>
                                    <hr>
                                </div>
                                <div class="card-content" style="padding:5px 5px 200px 5px;">
                                    <div class="card-body p-1 justify-content-center text-center"
                                         style="border-radius: 15px !important;">
                                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="40" cy="40" r="38.5" fill="#DC3545" stroke="#F1AEB5"
                                                    stroke-width="3"/>
                                            <path d="M53.6004 53.6L26.4004 26.4M53.6004 26.4L26.4004 53.6"
                                                  stroke="white" stroke-width="5" stroke-linecap="round"/>
                                        </svg>
                                        <br>
                                        <div
                                            style="color:#000000; font-size: 16px; line-height: 24px; font-weight: 700; padding-top: 25px; padding-bottom: 25px;">
                                            متاسفانه خطایی رخ داد. لطفا مجددا تلاش کنید:
                                            خطای:
                                            <span class="alert-danger" id="errormessage">

                                            </span>
                                        </div>
                                        <a href="{{ route('public.kyc.list') }}" class="btn"
                                           style="color:#FFFFFF; font-size: 16px; line-height: 24px; font-weight: 700; background-color: #33519A; border-radius: 12px !important;">
                                            تلاش مجدد
                                        </a>
                                        <a href="{{ route('public.index') }}"  class="btn"
                                           style="color:#FFFFFF; font-size: 16px; line-height: 24px; font-weight: 700; background-color: #33519A;">
                                            رفتن به صفحه خانه
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Form wizard with number tabs section end -->
            </div>
        </div>
    </div>

@endsection

@push('footer')

    <script>

        function previewResult(event, fieldId) {
            const input = event.target;
            const preview = document.getElementById(`final-input-preview-${fieldId}`);

            console.log(input.value); // Use input.value to get the value of the input
            preview.innerText = input.value; // Update the preview with the input value
        }

        function previewImage(event, fieldId) {
            const fileInput = event.target;
            const filePreview = document.getElementById(`file-alternate-${fieldId}`);
            const finalFilePreview = document.getElementById(`final-file-preview-${fieldId}`);

            // Clear any existing preview
            filePreview.innerHTML = '';
            finalFilePreview.innerHTML = '';

            // Check if a file is selected and it's an image
            if (fileInput.files && fileInput.files[0] && fileInput.files[0].type.startsWith('image')) {
                const reader = new FileReader();

                // Create image element for the preview
                reader.onload = function (e) {
                    // const img = document.createElement('img');
                    // img.src = e.target.result;
                    // img.alt = 'Preview';
                    // img.classList.add('img-thumbnail');
                    // img.width = 160;  // Set the size for the preview image
                    // img.height = 160;
                    //
                    // // Append the image preview to the div
                    // filePreview.appendChild(img);
                    filePreview.style.backgroundImage = `url('${e.target.result}')`;
                    filePreview.style.backgroundSize = "cover";  // Ensure it covers the div
                    filePreview.style.backgroundPosition = "center"; // Center the image
                    filePreview.style.maxWidth = "300px";  // Set preview div size
                    filePreview.style.minWidth = "150px";  // Set preview div size
                    filePreview.style.maxHeight = "300px";
                    filePreview.style.minHeight = "150px";
                };

                // Read the selected file
                reader.readAsDataURL(fileInput.files[0]);
                const reader2 = new FileReader();

                reader2.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.classList.add('img-thumbnail');
                    img.width = 160;  // Set the size for the preview image
                    img.height = 160;

                    // Append the image preview to the div
                    finalFilePreview.appendChild(img);
                };

                // Read the selected file
                reader2.readAsDataURL(fileInput.files[0]);
            }
        }

        function uploadkycfile(fieldId) {
            const fileInput = document.getElementById(`file-upload-${fieldId}`);
            fileInput.click();
        }

        $(document).ready(function () {
            $(".vertical-tab-steps").steps({
                headerTag: "h6",
                bodyTag: "fieldset",
                transitionEffect: "fade",
                stepsOrientation: "vertical",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: 'ارسال اطلاعات',
                    next: 'بعدی',
                    previous: 'قبلی'
                },
                // Triggered before moving to the next step
                onStepChanging: function (event, currentIndex, newIndex) {
                    console.log("Changing step from:", currentIndex + 1, "to", newIndex + 1);

                    // Validate input fields before proceeding
                    let isValid = validateStepFields(currentIndex);
                    return isValid; // Return true to allow the step change, false to prevent it
                },

                // Final submission on the last step
                onFinished: async function (event) {  // Mark function as async
                    let formData = new FormData($("#kyc-form")[0]);

                    // Manually append files for the last step
                    $(".wizard-circle fieldset:last input[type='file']").each(function () {
                        if (this.files.length > 0) {
                            formData.append($(this).attr("name"), this.files[0]);
                        }
                    });
                    try {
                        let response = await sendAjax(formData);  // Await the AJAX call
                        if (response.status === "success") {
                            $('#stepmenu').addClass('d-none');
                            $('#stepmenusuccessresult').removeClass('d-none');
                            $('#continueshopingbtn').attr('href', response.redirect_to); // Correct way to set href
                            console.error('here');
                            var countdownTime = 5; // Set initial time to 5 seconds

                            // Update the countdown every second
                            var countdownInterval = setInterval(function() {
                                countdownTime--;
                                $('#countdown').text(countdownTime); // Update the countdown text on the page

                                if (countdownTime <= 0) {
                                    clearInterval(countdownInterval); // Stop the countdown when it reaches 0
                                    window.location.href = response.redirect_to; // Redirect after countdown finishes
                                }
                            }, 1000);
                            // setTimeout(function () {
                            //     window.location.href = response.redirect_to; // Redirect after 5 seconds
                            // }, 5000);
                        } else {
                            $('#stepmenu').addClass('d-none');
                            $('#stepmenuerrorresult').removeClass('d-none');
                            $('#errormessage').text(response.message);
                            console.error('here2');
                        }

                    } catch (error) {
                        console.error('here3');
                        console.error("Error:", error);
                        $('#stepmenu').addClass('d-none');
                        $('#stepmenuerrorresult').removeClass('d-none');
                        $('#errormessage').text(response.message);

                    }
                }
            });

            // Function to validate form fields per step
            function validateStepFields(stepIndex) {
                let isValid = true;

                // Select the current step's fields
                $(`.wizard-circle fieldset:eq(${stepIndex}) input`).each(function () {
                    if ($(this).prop('required') && $(this).val().trim() === '') {
                        isValid = false;
                        if ($(this).prop('type') == 'file') {
                            $('#' + $(this).attr('alternate')).addClass("invalidalternatefile");
                        } else {
                            $(this).addClass("is-invalid"); // Add Bootstrap error styling
                        }
                    } else {
                        if ($(this).prop('type') == 'file') {
                            $('#' + $(this).attr('alternate')).removeClass("invalidalternatefile");
                        } else {
                            $(this).removeClass("is-invalid");
                        }
                    }
                });

                return isValid;
            }

            function sendAjax(formData) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: "{{ route('public.kyc.nextStep') }}", // Adjust route as needed
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function (response) {
                            resolve(response); // Resolve the promise with response
                        },
                        error: function (xhr) {
                            reject(xhr); // Reject the promise on error
                        }
                    });
                });
            }
        });

    </script>
@endpush
