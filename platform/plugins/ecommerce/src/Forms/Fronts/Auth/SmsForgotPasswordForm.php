<?php

namespace Botble\Ecommerce\Forms\Fronts\Auth;

use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\PhoneNumberField;
use Botble\Ecommerce\Http\Requests\Fronts\Auth\SmsForgotPasswordRequest;

class SmsForgotPasswordForm extends AuthForm
{
    public static function formTitle(): string
    {
        return __('Customer forgot password form');
    }

    public function setup(): void
    {
        parent::setup();

        $this
            ->setUrl(route('customer.password.sendCode'))
            ->setValidatorClass(SmsForgotPasswordRequest::class)
            ->icon('ti ti-lock-question')
            ->heading(__('Forgot Password'))
            ->description(__('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.'))
            ->add(
                'phone',
                PhoneNumberField::class,
                NumberFieldOption::make()
                    ->label(__('Phone'))
                    ->placeholder(__('Phone number'))
            )
            ->submitButton(trans('plugins/ecommerce::customer.send_sms'))
            ->add('back_to_login', HtmlField::class, [
                'html' => sprintf(
                    '<div class="mt-3 text-center"><a href="%s" class="text-decoration-underline">%s</a></div>',
                    route('customer.login'),
                    __('Back to login page')
                ),
            ]);
    }
}
