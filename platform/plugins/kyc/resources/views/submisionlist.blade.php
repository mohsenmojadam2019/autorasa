@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
@include('plugins/kyc::partials.user-card',['profileImage' => $modelable->avatar, 'fullName' => $modelable->name, 'phoneNumber' => $modelable->phone])
@foreach ($submissions as $submission)
{{--    @dd($submission->id)--}}
    @include('plugins/kyc::partials.kyc-card', [
        'id'=>$submission->id,
        'value' => $submission->value,
        'title' => $submission->field->field_name,
        'status' => $submission->status,
        'type'=>$submission->field->field_type
    ])
@endforeach
@endsection
