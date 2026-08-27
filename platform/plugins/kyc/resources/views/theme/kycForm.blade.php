@extends(EcommerceHelper::viewPath('customers.master'))

@section('title', SeoHelper::getTitle())
@section('content')
    <div class="container mt-4">
        <form method="post" action="{{ route('public.kyc.storekyc') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $field->kyc_entry_id }}" name="kyc_entry_id" style="border-radius: 12px !important;">
            <input type="hidden" value="{{ $field->id }}" name="kyc_field_id" style="border-radius: 12px !important;">

            @php
                $submission = $field->submissions; // Get the first submission safely
            @endphp

            @if($field->field_type == 'file')
                <div class="row">
                    <label>{{ $field->field_name }}</label>
                <div class="form-group col-md-6">
                    <div id="file-alternate-{{ $field->id }}"
                         title="لطفا {{$field->field_name}} را بارگزاری کنید."
                         style="width: 150px;height: 150px; border: 2px dashed #ccc; display: flex;align-items: center; justify-content: center; cursor: pointer;margin-bottom: 10px; background-color:#F8F9FA;"
                         onclick="uploadkycfile({{ $field->id }})">
                        <div class="fa"></div>
                        <br>
                        <p>فایل را بارگزاری کنید.</p>
                    </div>
                    <input type="file" class="d-none"
                           id="file-upload-{{ $field->id }}"
                           alternate="file-alternate-{{ $field->id }}"
                           title="لطفا {{$field->field_name}} را بارگزاری کنید."
                           class="form-control"
                           field_id="{{ $field->id }}"
                           name="value"
                           style="border-radius: 12px !important;"
                           @if($field->is_required and empty($field->submissions))  {{'required'}} @endif onchange="previewImage(event, {{ $field->id }})"
                           accept=".jpg, .jpeg, .png, .heic, .heif"/>
                </div>
                <div class="file-preview col-md-6"
                     id="file-preview-{{ $field->id }}">
                    @if(!empty($submission))
                        <img
                            src="{{ $submission?RvMedia::getImageUrl($submission->value):'' }}"
                            alt="{{ __('Preview') }}"
                            class="img-thumbnail" width="150"
                            height="150">
                    @endif
                </div>
                </div>
{{--                <input type="file" name="value">--}}
{{--                @if ($submission)--}}
{{--                    <p class="mt-2">Uploaded file:--}}
{{--                        <a href="{{ \Botble\Media\Facades\RvMedia::url($submission->value) }}" target="_blank">View</a>--}}
{{--                    </p>--}}
{{--                    @dd(1)--}}
{{--                @endif--}}
            @else
                <input type="{{ $field->field_type }}" name="value"
                       value="{{ optional($submission)->value ?? '' }}" style="border-radius: 12px !important;">
            @endif

            <button type="submit" class="btn btn-primary mt-3" style="border-radius: 12px !important;">
                ثبت
            </button>
        </form>
        <script>
            function uploadkycfile(fieldId) {
                const fileInput = document.getElementById(`file-upload-${fieldId}`);
                fileInput.click();
            }
            function previewImage(event, fieldId) {
                const fileInput = event.target;
                const filePreview = document.getElementById(`file-preview-${fieldId}`);
                // const finalFilePreview = document.getElementById(`final-file-preview-${fieldId}`);

                // Clear any existing preview
                filePreview.innerHTML = '';
                // Check if a file is selected and it's an image
                if (fileInput.files && fileInput.files[0] && fileInput.files[0].type.startsWith('image')) {
                    const reader = new FileReader();

                    // Create image element for the preview
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Preview';
                        img.classList.add('img-thumbnail');
                        img.width = 160;  // Set the size for the preview image
                        img.height = 160;

                        // Append the image preview to the div
                        filePreview.appendChild(img);
                    };

                    // Read the selected file
                    reader.readAsDataURL(fileInput.files[0]);

                }
            }
        </script>
    </div>
@endsection
