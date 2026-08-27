<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Ecommerce\Models\Customer;
use Botble\Support\Http\Requests\Request;

class OTPLoginRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'phone' => [
                'required',
                'regex:/^(?:\+98|0098|098|0)?9\d{9}$/',
                function ($attribute, $value, $fail) {
                    $normalizedPhone = $this->normalizePhone($value);

                    if (!Customer::where('phone', $normalizedPhone)->exists()) {
                        $fail(trans('plugins/ecommerce::customer.phone_not_exist'));
                    }
                },
            ],
        ];

        return apply_filters('ecommerce_customer_login_form_validation_rules', $rules);
    }

    public function attributes(): array
    {
        return apply_filters('ecommerce_customer_login_form_validation_attributes', [
            'phone' => trans('plugins/ecommerce::customer.phone'),
        ]);
    }

    public function messages(): array
    {
        return apply_filters('ecommerce_customer_login_form_validation_messages', [
            'phone.required' => trans('plugins/ecommerce::customer.phone_required'),
            'phone.regex' => trans('plugins/ecommerce::customer.phone_invalid'),
        ]);
    }

    protected function prepareForValidation()
    {
        $inputPhone = $this->input('phone');
        $normalizedPhone = $this->normalizePhone($inputPhone);

        $this->merge([
            'phone' => $normalizedPhone,
        ]);
    }

    private function normalizePhone($value): string
    {
        $phone = preg_replace('/[^0-9]/', '', $value);

        if (str_starts_with($phone, '0098')) {
            $phone = '0' . substr($phone, 4);
        } elseif (str_starts_with($phone, '098')) {
            $phone = '0' . substr($phone, 3);
        } elseif (str_starts_with($phone, '98')) {
            $phone = '0' . substr($phone, 2);
        } elseif (str_starts_with($phone, '+98')) {
            $phone = '0' . substr($phone, 3);
        } elseif (str_starts_with($phone, '9') && strlen($phone) === 10) {
            $phone = '0' . $phone;
        }
        return $phone;
    }
}
