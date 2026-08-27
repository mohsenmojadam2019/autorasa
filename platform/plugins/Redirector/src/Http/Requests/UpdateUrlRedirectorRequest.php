<?php

namespace ArchiElite\UrlRedirector\Http\Requests;

use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateUrlRedirectorRequest extends Request
{
    public function rules(): array
    {
        $urlRedirectorId = $this->route('url')?->id;

        return [
            'original' => [
                'required',
                'max:255',
//                'regex:/^\//', // اطمینان از اینکه با / شروع می‌شود
                Rule::unique('url_redirector', 'original')->ignore($urlRedirectorId),
            ],
            'target' => ['nullable', 'max:255',
//                'url',
                'different:original'],

            'is_canonical' => ['nullable', 'boolean'],
            'is_410' => ['nullable', 'boolean'],
            'is_404' => ['nullable', 'boolean'],
            'is_nofollow' => ['nullable', 'boolean'],
            'is_noindex' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        foreach (['is_canonical', 'is_nofollow', 'is_noindex', 'is_410','is_404'] as $field) {
            $this->merge([
                $field => $this->boolean($this->input($field)),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'original.regex' => 'آدرس مبدا باید با / شروع شود.',
            'original.unique' => 'این آدرس مبدا قبلاً ثبت شده است.',
//            'target.url' => 'آدرس مقصد باید یک آدرس معتبر باشد.',
            'target.different' => 'آدرس مقصد باید با آدرس مبدا متفاوت باشد.',
        ];
    }

}
