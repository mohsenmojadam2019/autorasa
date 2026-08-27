<script>
    $(document).ready(function () {
        // Make checkbox ids unique per working-hour row so labels target the right input.
        $('tr').has('.edit-working-hour').each(function () {
            const row = $(this);
            const workingHourId = row.find('.edit-working-hour').data('id');

            row.find('.working-hour-slot').each(function () {
                const checkbox = $(this);
                const id = `working-hour-${workingHourId}-slot-${checkbox.val()}`;
                checkbox.attr('id', id);
                checkbox.siblings('label.form-check-label').attr('for', id);
            });
        });

        // Replace the old one-click handler: first click enters edit mode, second click saves.
        $(document).off('click', '.edit-timeslot');
        $(document).on('click', '.edit-timeslot', function () {
            const button = $(this);
            const row = button.closest('tr');
            const startInput = row.find('.start-time-input');
            const endInput = row.find('.end-time-input');

            if (startInput.prop('disabled')) {
                startInput.prop('disabled', false);
                endInput.prop('disabled', false);
                button.attr('title', 'ذخیره');
                startInput.trigger('focus');
                return;
            }

            $.ajax({
                url: '{{ route('autoservice.ajax.timeslot.edit') }}',
                method: 'POST',
                data: {
                    start_time: startInput.val(),
                    end_time: endInput.val(),
                    id: button.data('id'),
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function (xhr) {
                    alert(xhr.responseJSON?.message || xhr.responseJSON?.error || 'Something went wrong!');
                },
            });
        });
    });
</script>
