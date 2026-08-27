<?php

namespace Botble\Zarinpal\Forms;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Payment\Forms\PaymentMethodForm;


class ZarinpalForm extends PaymentMethodForm
{
    public function setup(): void
    {
        parent::setup();
        $this
            ->paymentId(ZARINPAL_PAYMENT_METHOD_NAME)
            ->paymentName('zarinpal')
            ->paymentDescription(__('customer :name', ['name' => 'zarinpal']))
            ->paymentLogo(url('vendor/core/plugins/zarinpal/images/zarinpal.jpg'))
            ->paymentUrl('https://www.zarinpal.com/')
            ->paymentInstructions(view('plugins/zarinpal::instructions')->render())
            ->add(
                sprintf('payment_%s_merchantId', ZARINPAL_PAYMENT_METHOD_NAME),
                TextField::class,
                TextFieldOption::make()
                    ->label(__('merchantId'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('merchantId', ZARINPAL_PAYMENT_METHOD_NAME))
            )
          ;
    }
}
