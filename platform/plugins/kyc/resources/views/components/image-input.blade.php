{{--@if($submission)--}}
{{--    <div>--}}
{{--        <img src="{{ RvMedia::getImageUrl($submission->value) }}" alt="{{ $field->field_name }}" id="{{ $field->field_name }}-preview" class="{{ $options['attr']['class'] }}" />--}}
{{--    </div>--}}
{{--@endif--}}
<div class="bb-customer-profile-avatar-overlay">
    <label for="document-{{ $field->id }}-{{ $customer->id }}">{{ $field->field_name }}</label>
    <input type="file"
           id="document-{{ $field->id }}-{{ $customer->id }}"
           name="file"
           class="{{ $options['attr']['class'] }}"
           data-url="{{ route('public.kyc.temp', session('tracked_start_checkout')) }}"
           data-field-id="{{ $field->id }}"
    />
</div>

{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $("#document-{{ $field->id }}-{{ $customer->id }}").on('change', function (event) {--}}
{{--            const fileInput = $(this);--}}
{{--            const fieldId = fileInput.data('field-id');--}}
{{--            const uploadUrl = fileInput.data('url');--}}
{{--            const customerId = '{{ auth('customer')->user()->id }}';--}}

{{--            const formData = new FormData();--}}
{{--            formData.append('image', fileInput[0].files[0]);--}}
{{--            formData.append('field_id', fieldId);--}}
{{--            formData.append('customer_id', customerId);--}}

{{--            $.ajax({--}}
{{--                url: uploadUrl,--}}
{{--                type: 'POST',--}}
{{--                data: formData,--}}
{{--                contentType: false,--}}
{{--                processData: false,--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
{{--                },--}}
{{--                success: function (response) {--}}
{{--                    if (response.status === 'success') {--}}
{{--                        alert(response.message);--}}
{{--                        // Update the image preview--}}
{{--                        $(`#${fileInput.attr('id')}-preview`).attr('src', response.url);--}}
{{--                    } else {--}}
{{--                        alert(response.message || 'An error occurred.');--}}
{{--                    }--}}
{{--                },--}}
{{--                error: function (xhr) {--}}
{{--                    console.error('Upload failed:', xhr.responseText);--}}
{{--                    alert('An error occurred while uploading the image.');--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
