<?php

namespace Botble\Ecommerce\Http\Requests\Fronts\Auth;

use Botble\Support\Http\Requests\Request;

class SmsForgotPasswordRequest extends Request
{
    public function rules(): array
    {

        return [
            'phone' => ['required', 'exists:ec_customers,phone'], // Corrected the array syntax
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => trans('plugins/ecommerce::customer.phone_required'),
            'phone.exists' => trans('plugins/ecommerce::customer.phone_not_found'),
        ];
    }
}
