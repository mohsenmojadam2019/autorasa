{{--<div class="card shadow-sm border-0 w-75 mx-auto my-3 p-3">--}}
{{--    <div class="card-body text-center">--}}
{{--        <img src="{{ \Botble\Media\Facades\RvMedia::url($profileImage) }} ?? asset('storage/default-avatar.png') }}" alt="Profile Image" class="rounded-circle mb-3 border border-2 p-1" width="120" height="120">--}}
{{--        <img src="{{ \Botble\Media\Facades\RvMedia::url($profileImage) ?? asset('storage/default-avatar.png') }}" alt="Profile Image" class="rounded-circle mb-3 border border-2 p-1" width="120" height="120">--}}

{{--        <h5 class="card-title mb-2">{{ $fullName ?? 'John Doe' }}</h5>--}}
{{--        <p class="text-muted mb-3">{{ $phoneNumber ?? '+123 456 7890' }}</p>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="card shadow-sm border-0 w-75 mx-auto my-3 p-3">
    <div class="card-body text-center">
        @php
            $imageUrl = isset($profileImage) && $profileImage
                ? \Botble\Media\Facades\RvMedia::url($profileImage)
                : asset('storage/default-avatar.png');
        @endphp

        <img src="{{ $imageUrl }}" alt="Profile Image" class="rounded-circle mb-3 border border-2 p-1" width="120" height="120">

        <h5 class="card-title mb-2">{{ $fullName ?? 'John Doe' }}</h5>
        <p class="text-muted mb-3">{{ $phoneNumber ?? '+123 456 7890' }}</p>
    </div>
</div>

