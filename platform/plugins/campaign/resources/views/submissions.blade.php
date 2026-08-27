@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    <table class="table table-striped table-bordered text-center">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>موبایل</th>
            <th>مدل خودرو</th>
            <th>تاریخ</th>
            <th>ساعت</th>
            <th>کد رزرو</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($operator->reserveAgencies as $key => $submission)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $submission->fullname }}</td>
                <td>{{ $submission->mobile }}</td>
                <td>{{ $submission->carmodel }}</td>
                <td>{{ $submission->date }}</td>
                <td>{{ $submission->time }}</td>
                <td>{{ $submission->reserve_code }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-danger">هیچ رزروی یافت نشد.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection
