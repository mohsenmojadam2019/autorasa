<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class DimensionRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:250'],
            'slug' => ['nullable', 'string', 'max:250'],
            'description' => ['nullable', 'string', 'max:400'],
            'status' => Rule::in(BaseStatusEnum::values()),
            'categories' => ['nullable', 'array'],
        ];
    }

    public function attributes(): array
    {
        return [
            'categories.*' => trans('plugins/ecommerce::products.form.categories'),
        ];
    }
}
