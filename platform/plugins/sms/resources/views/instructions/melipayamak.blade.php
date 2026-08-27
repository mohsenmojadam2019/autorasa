<h3>{{ trans('plugins/sms::melipayamak.instructions.configuration_guide') }}</h3>
<ol>
    <li>
        <strong>{{ trans('plugins/sms::melipayamak.instructions.sign_up') }}:</strong>
        <p>
            {!! BaseHelper::clean(trans('plugins/sms::melipayamak.instructions.sign_up_description', [
                'link' => Html::link('https://www.melipayamak.com', 'Melipayamak', ['target' => '_blank']),
            ])) !!}
        </p>
    </li>
    <li>
        <strong>{{ trans('plugins/sms::melipayamak.instructions.get_sid_token') }}:</strong>
        <p>
            {!! BaseHelper::clean(trans('plugins/sms::melipayamak.instructions.get_sid_token_description', [
                'link' => Html::link('https://www.melipayamak.com/console', trans('plugins/sms::melipayamak.instructions.admin_console'), ['target' => '_blank']),
            ])) !!}
        </p>
    </li>
    <li>
        <strong>{{ trans('plugins/sms::melipayamak.instructions.get_from_number') }}:</strong>
        <p>{!! BaseHelper::clean(trans('plugins/sms::melipayamak.instructions.get_from_number_description')) !!}</p>
    </li>
</ol>
