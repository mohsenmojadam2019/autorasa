<?php

namespace FriendsOfBotble\Sms\Http\Requests;

use Botble\Support\Http\Requests\Request;

class PhoneVerificationRequest extends Request
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'exists:ec_customers,phone'],
            'otp' => ['required', 'digits:4'],
        ];
    }
}
