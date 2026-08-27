@if (get_payment_setting('status', BEHPARDAKHT_PAYMENT_METHOD_NAME) == 1)
    <x-plugins-payment::payment-method
            :name="BEHPARDAKHT_PAYMENT_METHOD_NAME"
            paymentName="Behpardakht"
            :supportedCurrencies="(new Botble\Behpardakht\Services\Gateways\BehpardakhtService)->supportedCurrencyCodes()"
    >
        <x-slot name="currencyNotSupportedMessage">
            <p class="mt-1 mb-0">
                {{ __('Learn more') }}:
                {{ Html::link('https://support.nextpay.com/hc/en-us/articles/360009973779', attributes: ['target' => '_blank', 'rel' => 'nofollow']) }}
                .
            </p>
        </x-slot>
    </x-plugins-payment::payment-method>
@endif
