<p class="card-text mt-3">
    {{ trans('plugins/sms::otp.did_not_receive_otp') }}
    <a
        href="javascript:void(0);"
        onclick="event.preventDefault(); document.querySelector('#resend-otpl-form').submit();"
        class="text-primary"
    >
        {{ trans('plugins/sms::otp.resend_otp') }}
    </a>
</p>

