<div class="card shadow-sm border-0 w-75 mx-auto my-3 p-3">
    <div class="card-body text-center">
        <h5 class="card-title mb-3">{{ $title ?? trans('plugins/kyc::kyc.document') }}</h5>
        @php


            @endphp
        @if($type=='file')
            <img src="{{ \Botble\Media\Facades\RvMedia::url($value) ?? asset('storage/default-document.png') }}" alt="{{ trans('plugins/kyc::kyc.uploaded_document') }}" class="img-fluid mb-4 rounded border border-2 p-1" style="max-height: 250px;">
        @elseif($type=='car')
        {{concatValuesFromJson($value)}}
{{--            <img src="{{ \Botble\Media\Facades\RvMedia::url($value) ?? asset('storage/default-document.png') }}" alt="{{ trans('plugins/kyc::kyc.uploaded_document') }}" class="img-fluid mb-4 rounded border border-2 p-1" style="max-height: 250px;">--}}
        @else
            <p class="text-muted mb-3">{{$value}}</p>
        @endif
        <p class="text-muted">{{ trans('plugins/kyc::kyc.status') }}: <span class="badge {{ $status == 'approved' ? 'badge-success' : ($status == 'rejected' ? 'badge-danger' : 'badge-warning') }}">
            {{ ucfirst(trans('plugins/kyc::kyc.' . ($status ?? 'pending'))) }}</span>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <!-- Accept Button -->
            <form action="{{ route('submissions.approve', $id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg">{{ trans('plugins/kyc::kyc.accept') }}</button>
            </form>

            <!-- Reject Button -->
            <form action="{{ route('submissions.reject', $id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg">{{ trans('plugins/kyc::kyc.reject') }}</button>
            </form>
        </div>
    </div>
</div>
