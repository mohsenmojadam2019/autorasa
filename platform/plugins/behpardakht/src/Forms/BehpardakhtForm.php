<?php

namespace Botble\Behpardakht\Forms;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Payment\Forms\PaymentMethodForm;


class BehpardakhtForm extends PaymentMethodForm
{
    public function setup(): void
    {
        parent::setup();
        $this
            ->paymentId(BEHPARDAKHT_PAYMENT_METHOD_NAME)
            ->paymentName('behpardakht')
            ->paymentDescription(__('customer :name', ['name' => 'behpardakht']))
            ->paymentLogo(url('vendor/core/plugins/behpardakht/images/behpardakht.jpg'))
            ->paymentUrl('https://www.behpardakht.com/')
            ->paymentInstructions(view('plugins/behpardakht::instructions')->render())
            ->add(
                sprintf('payment_%s_username', BEHPARDAKHT_PAYMENT_METHOD_NAME),
                TextField::class,
                TextFieldOption::make()
                    ->label(__('username'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('username', BEHPARDAKHT_PAYMENT_METHOD_NAME))
            )
            ->add(
                sprintf('payment_%s_password', BEHPARDAKHT_PAYMENT_METHOD_NAME),
                TextField::class,
                TextFieldOption::make()
                    ->label(__('password'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('password', BEHPARDAKHT_PAYMENT_METHOD_NAME))
            )
            ->add(
                sprintf('payment_%s_terminalId', BEHPARDAKHT_PAYMENT_METHOD_NAME),
                TextField::class,
                TextFieldOption::make()
                    ->label(__('terminalId'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('terminalId', BEHPARDAKHT_PAYMENT_METHOD_NAME))
            )
          ;
    }
}
