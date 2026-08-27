<?php

namespace Botble\Nextpay\Forms;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Payment\Forms\PaymentMethodForm;

class NextpayPaymentMethodForm extends PaymentMethodForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->paymentId(NEXTPAY_PAYMENT_METHOD_NAME)
            ->paymentName('Nextpay')
            ->paymentDescription(__('Customer :name', ['name' => 'Nextpay']))
            ->paymentLogo(url('vendor/core/plugins/nextpay/images/nextpay.png'))
            ->paymentUrl('https://nextpay.org')
            ->paymentInstructions(view('plugins/nextpay::instructions')->render())
            ->add(
                sprintf('payment_%s_public', NEXTPAY_PAYMENT_METHOD_NAME),
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Public Key'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('public', NEXTPAY_PAYMENT_METHOD_NAME))
            )
            ->add(
                sprintf('payment_%s_secret', NEXTPAY_PAYMENT_METHOD_NAME),
                'password',
                TextFieldOption::make()
                    ->label(__('Secret Key'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('secret', NEXTPAY_PAYMENT_METHOD_NAME))
            );
    }
}
