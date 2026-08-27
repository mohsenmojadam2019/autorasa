@php
    $expiryTime = \FriendsOfBotble\Sms\Facades\Otp::getExpiryTime($phone);
@endphp
<p class="card-text mt-3">
<span class="card-text expiry-time">
    {!! BaseHelper::clean(trans('plugins/sms::otp.code_expiry', ['time' => "<span></span>"])) !!}
</span>
    <a
        href="javascript:void(0);"
        onclick="event.preventDefault(); document.querySelector('#resend-otpl-form').submit();"
        class="text-primary"
    >
        {{ trans('plugins/sms::otp.resend_otp') }}
    </a>
</p>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var expiryTime = '{{ $expiryTime->getTimestamp() }}' * 1000;
        var element = document.querySelector('.expiry-time > span');

        function updateExpiryTime() {
            var now = new Date().getTime();
            var distance = expiryTime - now;

            if (distance < 0) {
                document.querySelector('.expiry-time').style.display = 'none';
                return;
            }

            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (seconds < 10) {
                seconds = '0' + seconds;
            }

            element.style.fontWeight = 'bold';
            element.innerText = `${minutes}:${seconds}`;
        }

        setInterval(updateExpiryTime, 1000);

        updateExpiryTime();
    });
</script>
