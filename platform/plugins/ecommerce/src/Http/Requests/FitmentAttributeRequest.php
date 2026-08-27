<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Ecommerce\Enums\FitmentAttributeFieldType;
use Botble\Ecommerce\Models\FitmentAttribute;
use Botble\Ecommerce\Models\FitmentGroup;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class FitmentAttributeRequest extends Request
{
    public function rules(): array
    {
        return [
            'group_id' => ['required', 'string', Rule::exists(FitmentGroup::class, 'id')],
            'parent_id' => ['nullable', 'string', Rule::exists(FitmentAttribute::class, 'id')],
            'name' => ['required', 'string', 'max:250'],
//            'type' => ['required', Rule::in(FitmentAttributeFieldType::values())],
            'default_value' => ['nullable', 'string', 'max:250'],
//            'options' => [ 'array'],
        ];
    }
}
