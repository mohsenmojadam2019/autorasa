<?php

namespace FriendsOfBotble\Sms\Forms;

use Botble\Base\Forms\FieldOptions\ButtonFieldOption;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\HiddenFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\HiddenField;
use Botble\Base\Forms\FormAbstract;

class PhoneLoginForm extends FormAbstract
{
    public function setup(): void
    {
        $phone = $this->formOptions['phone'] ?? null; // Get the phone value from form options
        $forgotFlag = $this->formOptions['forgotflag'] ?? false; // Get the forgotflag value from form options

        $this
            ->contentOnly()
            ->add(
                'phone',  // Add the hidden field for the phone number
                HiddenField::class,
                HiddenFieldOption::make()->value($phone)
            )
            ->add(
                'forgotflag', // Add the hidden field for the forgot flag
                HiddenField::class,
                HiddenFieldOption::make()->value($forgotFlag)
            )
            ->add(
                'otp',
                TextField::class,
                TextFieldOption::make()
                    ->label(false)
                    ->required()
                    ->attributes([
                        'autocomplete' => 'one-time-code',
                        'autofocus' => true,
                        'inputmode' => 'numeric',
                        'maxlength' => 4,
                        'pattern' => '\d{4}',
                    ])
            )
            ->add(
                'resend',
                HtmlField::class,
                HtmlFieldOption::make()->content(view('plugins/sms::phone-login.resend',['phone'=>$phone]))
            )
            ->add(
                'submit',
                'submit',
                ButtonFieldOption::make()
                    ->label(trans('plugins/sms::otp.verify'))
                    ->cssClass('btn btn-primary w-100')
                    ->attributes(['style' => 'border-radius: 12px !important;'])
            );
    }
}
