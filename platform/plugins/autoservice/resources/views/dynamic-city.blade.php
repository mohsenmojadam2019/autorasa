@if($model)
{{--    @dd($model->timeslots)--}}
    <!-- Time Slots Table -->
    <x-core::table>
        <x-core::table.header>
            <x-core::table.header.cell>
                {{ trans('plugins/autoservice::autoservice.start_time') }}
            </x-core::table.header.cell>
            <x-core::table.header.cell>
                {{ trans('plugins/autoservice::autoservice.end_time') }}
            </x-core::table.header.cell>
            <x-core::table.header.cell />
        </x-core::table.header>
        <x-core::table.body>
            @foreach($model->timeslots as $timeslot)
                <x-core::table.body.row>
                    <x-core::table.body.cell>
                        <input
                            type="text"
                            class="form-control start-time-input"
                            value="{{ $timeslot->start_time }}"
                            disabled
                        />
                    </x-core::table.body.cell>

                    <x-core::table.body.cell>
                        <input
                            type="text"
                            class="form-control end-time-input"
                            value="{{ $timeslot->end_time }}"
                            disabled
                        />
                    </x-core::table.body.cell>

                    <x-core::table.body.cell style="width: 14%">
                        <x-core::button type="button" class="edit-timeslot" data-id="{{ $timeslot->id }}" :icon-only="true" icon="ti ti-edit" />
                        <x-core::button type="button" class="delete-timeslot" data-id="{{ $timeslot->id }}" :icon-only="true" icon="ti ti-trash" />
                    </x-core::table.body.cell>
                </x-core::table.body.row>
        @endforeach

        <!-- New Timeslot Form -->
            <x-core::table.body.row>
                <x-core::table.body.cell>
                    <input
                        type="number"
                        class="form-control"
                        name="new_timeslot_start_time" id="new_timeslot_start_time"
                    />
                </x-core::table.body.cell>

                <x-core::table.body.cell>
                    <input
                        type="number"
                        class="form-control"
                        name="new_timeslot_end_time" id="new_timeslot_end_time"
                    />
                </x-core::table.body.cell>

                <x-core::table.body.cell style="width: 14%">
                    <x-core::button type="button" icon="ti ti-plus" class="add-timeslot-entry" />
                </x-core::table.body.cell>
            </x-core::table.body.row>
        </x-core::table.body>
    </x-core::table>

    <!-- Working Hours Table -->
    <x-core::table>
        <x-core::table.header>
            <x-core::table.header.cell>
                {{ trans('plugins/autoservice::autoservice.weekdays') }}
            </x-core::table.header.cell>
            <x-core::table.header.cell>
                {{ trans('plugins/autoservice::autoservice.timeslots') }}
            </x-core::table.header.cell>
            <x-core::table.header.cell />
        </x-core::table.header>
        <x-core::table.body>
{{--            @php--}}
{{--                $workingHours=['شنبه','یکشنبه','دوشنبه','سه شنبه','چهارشنبه','پنجشنبه','جمعه'];--}}
{{--                @endphp--}}
            @foreach($model->workingHours as $workingHour)
                <x-core::table.body.row>
                    <x-core::table.body.cell>
                        <input
                            type="text"
                            class="form-control working-hour-day"
                            value="{{ $workingHour->day }}"
                            disabled
                        />
                    </x-core::table.body.cell>

                    <x-core::table.body.cell>
{{--                        @dd($model->workingHours[3]->timeSlots)--}}
                        @foreach($model->timeslots as $slot)
                            <div class="form-check form-check-inline">
                                <input
                                    class="form-check-input working-hour-slot"
                                    type="checkbox"
                                    name="new_time_slots[]"
                                    value="{{ $slot->id }}"
                                    id="slot-{{ $slot->id }}"
                                    {{ $workingHour->timeSlots->contains('id', $slot->id) ? 'checked' : '' }}
                                />
                                <label class="form-check-label" for="slot-{{ $slot->id }}">
                                    {{ $slot->start_time }} - {{ $slot->end_time }}
                                </label>
                            </div>
                        @endforeach
                    </x-core::table.body.cell>

                    <x-core::table.body.cell style="width: 14%">
                        <x-core::button type="button" class="edit-working-hour" data-id="{{ $workingHour->id }}" :icon-only="true" icon="ti ti-plus" />
{{--                        <x-core::button type="button" class="delete-working-hour" data-id="{{ $workingHour->id }}" :icon-only="true" icon="ti ti-trash" />--}}
                    </x-core::table.body.cell>
                </x-core::table.body.row>
        @endforeach

        <!-- New Working Hour Form -->
{{--            <x-core::table.body.row>--}}
{{--                <x-core::table.body.cell>--}}
{{--                    <select class="form-control" name="new_working_day" id="new-working-day">--}}
{{--                        <option value="شنبه">شنبه</option>--}}
{{--                        <option value="یکشنبه">یکشنبه</option>--}}
{{--                        <option value="دوشنبه">دوشنبه</option>--}}
{{--                        <option value="سه‌شنبه">سه‌شنبه</option>--}}
{{--                        <option value="چهارشنبه">چهارشنبه</option>--}}
{{--                        <option value="پنج‌شنبه">پنج‌شنبه</option>--}}
{{--                        <option value="جمعه">جمعه</option>--}}
{{--                    </select>--}}
{{--                </x-core::table.body.cell>--}}

{{--                <x-core::table.body.cell>--}}
{{--                    @php--}}
{{--                        $timeslots = \Botble\Autoservice\Models\AutoserviceTimeslot::where('service_center_id', $model->id)->get();--}}
{{--                    @endphp--}}
{{--                    @dd($timeslots)--}}
{{--                    @foreach($model->timeslots as $slot)--}}
{{--                        <div class="form-check form-check-inline">--}}
{{--                            <input--}}
{{--                                class="form-check-input"--}}
{{--                                type="checkbox"--}}
{{--                                name="new_time_slots[]"--}}
{{--                                value="{{ $slot->id }}"--}}
{{--                                id="slot-{{ $slot->id }}"--}}
{{--                            />--}}
{{--                            <label class="form-check-label" for="slot-{{ $slot->id }}">--}}
{{--                                {{ $slot->start_time }} - {{ $slot->end_time }}--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </x-core::table.body.cell>--}}

{{--                <x-core::table.body.cell style="width: 7%">--}}
{{--                    <x-core::button type="button" icon="ti ti-plus" class="add-schedule-entry" />--}}
{{--                </x-core::table.body.cell>--}}
{{--            </x-core::table.body.row>--}}
        </x-core::table.body>
    </x-core::table>
@endif

<script>
    $(document).ready(function () {
        // Adding a new timeslot
        $('.add-timeslot-entry').on('click', function () {
            const startTime = $('#new_timeslot_start_time').val();
            const endTime = $('#new_timeslot_end_time').val();
            const serviceCenterId = '{{ $model?$model->id:'' }}';
            if (!startTime || !endTime) {
                alert('Please fill in both start time and end time.');
                return;
            }

            $.ajax({
                url: '{{ route('autoservice.ajax.timeslot.add') }}',
                method: 'POST',
                data: {
                    start_time: startTime,
                    end_time: endTime,
                    service_center_id: serviceCenterId,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.success) {
                        alert('Time Slot added successfully!');
                        location.reload();
                    } else {
                        alert('Error adding time slot.');
                    }
                },
            });
        });

        // Editing a timeslot
        $(document).on('click', '.edit-timeslot', function () {
            const timeslotId = $(this).data('id');
            const startInput=$(this).closest('tr').find('.start-time-input');
            startInput.prop('disabled', false);
            const startTime = startInput.val();
            const endInput=$(this).closest('tr').find('.end-time-input');
            endInput.prop('disabled', false);
            const endTime = endInput.val();

            $.ajax({
                url: '{{ route('autoservice.ajax.timeslot.edit') }}',
                method: 'POST',
                data: {
                    start_time: startTime,
                    end_time: endTime,
                    id:timeslotId,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.success) {
                        alert('Time Slot updated successfully!');
                        location.reload();
                    }
                },
            });
        });

        // Deleting a timeslot
        $(document).on('click', '.delete-timeslot', function () {
            const timeslotId = $(this).data('id');

            if (confirm('Are you sure you want to delete this time slot?')) {
                $.ajax({
                    url: '{{ route('autoservice.ajax.timeslot.delete') }}',
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id:timeslotId
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('Time Slot deleted successfully!');
                            location.reload();
                        }
                    },
                });
            }
        });

        // Adding a new working hour
        $('.add-schedule-entry').on('click', function () {
            const day = $('#new-working-day').val();
            const selectedSlots = [];
            $('input[name="new_time_slots[]"]:checked').each(function () {
                selectedSlots.push($(this).val());
            });

            const serviceCenterId = '{{ $model?$model->id:'' }}';

            if (!day || selectedSlots.length === 0) {
                alert('Please select a day and at least one time slot.');
                return;
            }

            $.ajax({
                url: '{{ route('autoservice.ajax.working_hour.add') }}',
                method: 'POST',
                data: {
                    day: day,
                    time_slots: selectedSlots,
                    service_center_id: serviceCenterId,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.success) {
                        alert('Working hour added successfully!');
                        location.reload();
                    } else {
                        alert('Failed to add working hour.');
                    }
                },
            });
        });
        $('#province-select').on('change', function () {
            let provinceId = $(this).val();
            $.ajax({
                url: '/cart/cities/' + provinceId,
                type: 'GET',
                success: function (data) {
                    let citySelect = $('#city-select');
                    citySelect.empty();
                    $.each(data, function (key, value) {
                        citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });


        // Deleting a working hour
        $(document).on('click', '.delete-working-hour', function () {
            const workingHourId = $(this).data('id');

            if (confirm('Are you sure you want to delete this working hour?')) {
                $.ajax({
                    url: '{{ route('autoservice.ajax.working_hour.delete') }}',
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id:workingHourId
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('Working hour deleted successfully!');
                            location.reload();
                        }
                    },
                });
            }
        });
        $(document).on('click', '.edit-working-hour', function () {
            const row = $(this).closest('tr');
            const workingHourId = $(this).data('id');
            const dayInput = row.find('.working-hour-day');
            const dayValue = dayInput.val();

            const selectedSlotIds = [];
            row.find('.working-hour-slot:checked').each(function () {
                selectedSlotIds.push($(this).val());
            });

            $.ajax({
                url: '{{ route('autoservice.ajax.working_hour.edit') }}',
                method: 'POST',
                data: {
                    id: workingHourId,
                    day: dayValue,
                    time_slots: selectedSlotIds,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.success) {
                        // alert('Working hour updated successfully!');
                        location.reload();
                    }
                },
                error: function (xhr) {
                    alert(xhr.responseJSON?.error || 'Something went wrong!');
                }
            });
        });

    });
</script>
