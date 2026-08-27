<?php

namespace Botble\Ecommerce\Http\Requests\Fronts\Auth;

use Botble\Base\Rules\EmailRule;
use Botble\Support\Http\Requests\Request;

class SmsResetPasswordRequest extends Request
{
    public function rules(): array
    {
        return [
            '__token' => ['required', 'string'],
            'phone' => ['required', 'exists:ec_customers,phone'],
            'password' => ['required', 'confirmed', 'min:6'],
        ];
    }
}
