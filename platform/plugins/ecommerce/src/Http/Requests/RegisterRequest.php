<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Rules\EmailRule;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\Customer;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Str;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'max:120', 'min:2'],
            'email' => [
                'nullable',
                Rule::requiredIf(! EcommerceHelper::isLoginUsingPhone()),
                new EmailRule(),
                Rule::unique((new Customer())->getTable()),
            ],
//            'phone' => [
//                'nullable',
//                Rule::requiredIf(EcommerceHelper::isLoginUsingPhone() || get_ecommerce_setting('make_customer_phone_number_required', false)),
//                ...explode('|', BaseHelper::getPhoneValidationRule()),
//                function ($attribute, $value, $fail) {
//                    // Check if a customer exists with this phone
//                    $customer = Customer::where('phone', $value)->first();
//
//                    if ($customer) {
//                        // If the phone exists, ensure 'phone_verified_at' is null
//                        if ($customer->phone_verified_at !== null) {
//                            $fail(__('The :attribute has already been verified.'));
//                        }
//                    }
//                },
//            ],

            'phone' => [
                'nullable',
                Rule::requiredIf(EcommerceHelper::isLoginUsingPhone() || get_ecommerce_setting('make_customer_phone_number_required', false)),
                function ($attribute, $value, $fail) {
                    // پاک کردن کاراکترهای اضافی
                    $phone = preg_replace('/[^0-9]/', '', $value);

                    // نرمال‌سازی: تبدیل هر فرمتی به ۰۹xxxxxxxxx
                    if (Str::startsWith($phone, '0098')) {
                        $phone = '0' . substr($phone, 4);
                    } elseif (Str::startsWith($phone, '098')) {
                        $phone = '0' . substr($phone, 3);
                    } elseif (Str::startsWith($phone, '98')) {
                        $phone = '0' . substr($phone, 2);
                    } elseif (Str::startsWith($phone, '+98')) {
                        $phone = '0' . substr($phone, 3);
                    } elseif (Str::startsWith($phone, '9') && strlen($phone) === 10) {
                        $phone = '0' . $phone;
                    }

                    // بررسی نهایی: ۱۱ رقم، شروع با ۰۹
                    if (!preg_match('/^09\d{9}$/', $phone)) {
                        return $fail(__('The :attribute must be a valid Iranian mobile number.'));
                    }

                    // تبدیل به فرمت استاندارد برای جستجو در دیتابیس
                    $normalized = '+98' . substr($phone, 1);

                    // بررسی وجود شماره تلفن در دیتابیس و تأیید نشدن آن
                    $customer = Customer::where('phone', $normalized)->first();
                    if ($customer && $customer->phone_verified_at !== null) {
                        return $fail(__('The :attribute has already been verified.'));
                    }
                },
            ],


//            'password' => ['required', 'min:6', 'confirmed'],
            'agree_terms_and_policy' => ['sometimes', 'accepted:1'],
        ];

        return apply_filters('ecommerce_customer_registration_form_validation_rules', $rules);
    }

    public function attributes(): array
    {
        return apply_filters('ecommerce_customer_registration_form_validation_attributes', [
            'name' => __('Name'),
            'email' => __('Email'),
//            'password' => __('Password'),
            'phone' => __('Phone'),
            'agree_terms_and_policy' => __('Term and Policy'),
        ]);
    }

    public function messages(): array
    {
        return apply_filters('ecommerce_customer_registration_form_validation_messages', []);
    }
}
