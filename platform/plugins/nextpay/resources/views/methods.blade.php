@if (get_payment_setting('status', NEXTPAY_PAYMENT_METHOD_NAME) == 1)
    <x-plugins-payment::payment-method
        :name="NEXTPAY_PAYMENT_METHOD_NAME"
        paymentName="Nextpay"
        :supportedCurrencies="(new Botble\Nextpay\Services\Gateways\NextpayPaymentService)->supportedCurrencyCodes()"
    >
        <x-slot name="currencyNotSupportedMessage">
            <p class="mt-1 mb-0">
                {{ __('Learn more') }}:
                {{ Html::link('https://support.nextpay.com/hc/en-us/articles/360009973779', attributes: ['target' => '_blank', 'rel' => 'nofollow']) }}.
            </p>
        </x-slot>
    </x-plugins-payment::payment-method>
@endif
