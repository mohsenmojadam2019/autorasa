@if (get_payment_setting('status', ZARINPAL_PAYMENT_METHOD_NAME) == 1)
    <x-plugins-payment::payment-method
            :name="ZARINPAL_PAYMENT_METHOD_NAME"
            paymentName="Zarinpal"
            :supportedCurrencies="(new Botble\Zarinpal\Services\Gateways\ZarinpalService)->supportedCurrencyCodes()"
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
