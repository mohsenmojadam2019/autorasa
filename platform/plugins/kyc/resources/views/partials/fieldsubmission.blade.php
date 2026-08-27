<div class="card shadow-sm border-0 w-100 mb-4">
    <div class="card-body">
        <h5 class="card-title mb-3">{{ $field->field_name ?? trans('plugins/kyc::kyc.document') }}</h5>
        @if($field->field_type == 'file')
{{--            @dd($field)--}}
            <div class="mb-4">

{{--                <img src="{{ $field->submissions? url($field->submissions->value):'' }}"--}}
                <img src="{{ $field->submissions?RvMedia::getImageUrl($field->submissions->value,'thumb'):'' }}"
                     alt="{{ trans('plugins/kyc::kyc.uploaded_document') }}"
                     class="img-fluid mb-4 rounded border border-2 p-1" style="max-height: 250px;">
            </div>
        @else
            <p class="text-muted mb-3">{{ optional($field->submissions)->value ?? 'تکمیل نشده' }}</p>
        @endif

        @php
            $submission = $field->submissions; // Get the first submission
        @endphp

        <p class="text-muted">{{ trans('plugins/kyc::kyc.status') }}:</p>
        <div class="d-flex justify-content-between align-items-center">
    <span class="text-start" style="background-color:
    {{ isset($submission) && $submission->status == 'approved' ? '#28a745' :
    (isset($submission) && $submission->status == 'rejected' ? '#dc3545' : '#ffc107') }};
        color: white; padding: 0.2em 0.6em; border-radius: 0.25rem; border-radius: 12px !important;">
        {{ isset($submission) ? ucfirst(trans('plugins/kyc::kyc.' . ($submission->status ?? 'pending'))) : 'تکمیل نشده' }}
    </span>
            @if(!isset($submission) or $submission->status!='approved')
                <span class="text-end">
        <a href="{{route('public.kyc.showfield',['id'=>$field->id])}}" class="btn btn-primary btn-sm" style="border-radius: 12px !important;">
            <i class="fa fa-edit"></i> {{ $submission ?trans('plugins/kyc::kyc.edit'):"تکمیل فرم" }}
        </a>
    </span>
            @endif
        </div>
    </div>
</div>
