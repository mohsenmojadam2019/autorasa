@extends(EcommerceHelper::viewPath('customers.master'))

@section('title', SeoHelper::getTitle())

@section('content')
    <div class="container mt-4">

            @foreach($fields as $field)
            <div class="container mt-4">
                @include('plugins/kyc::partials.fieldsubmission',[$field])
            </div>
            @endforeach
    </div>
@endsection
