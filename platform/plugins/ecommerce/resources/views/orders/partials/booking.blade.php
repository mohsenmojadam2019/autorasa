@if ($bookings)
    <h5 class="mb-2">رزرو شما</h5>

    <div class="mb-2 border rounded pt-3" style="direction: rtl; text-align: right;">
        <ul class="list-unstyled mb-0">
            <li class="mb-1" style="margin-left: 5px;">
                <span >📅</span> تاریخ: {{ $bookings->booking_date_jalali }}<br>
                <span >⏰</span> ساعت: {{ $bookings->booking_time_formatted }}


            </li>
        </ul>
    </div>
@else
    <p style="direction: rtl; text-align: right;">رزروی ثبت نشده است.</p>
@endif
