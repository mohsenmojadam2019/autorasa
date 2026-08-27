<?php

namespace Botble\Ecommerce\Forms\Fronts\Auth;

use Botble\Base\Facades\Html;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\PhoneNumberField;
use Botble\Ecommerce\Forms\Fronts\Auth\FieldOptions\TextFieldOption;
use Botble\Ecommerce\Http\Requests\LoginRequest;

class OTPLoginForm extends AuthForm
{
    public static function formTitle(): string
    {
        return __('Customer login form');
    }

    public function setup(): void
    {
        parent::setup();
        $this
            ->setUrl(route('customer.otplogin.post'))
            ->setValidatorClass(LoginRequest::class)
            ->icon('ti')
            ->add(
                'heading',
                HtmlField::class,
                HtmlFieldOption::make()->addAttribute('class', 'text-center')
                    ->view('plugins/ecommerce::customers.includes.login-otp-heading')
            )
            ->add(
                'register',
                HtmlField::class,
                HtmlFieldOption::make()->addAttribute('class', 'text-center')
                    ->view('plugins/ecommerce::customers.includes.register-link')
            )
            ->add(
                'phone',
                PhoneNumberField::class, // استفاده از PhoneNumberField برای شماره تلفن
                TextFieldOption::make()
                    ->label(trans('plugins/ecommerce::customer.phone'))
                    ->placeholder(__('Phone number'))
                    ->icon('ti ti-phone') // تغییر آیکون به آیکون تلفن
            )
            ->submitButton(__('Login'), 'ti ti-arrow-narrow-left');
    }
}
