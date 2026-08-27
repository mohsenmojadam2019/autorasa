<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Ecommerce\Models\FitmentGroup;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class FitmentProductRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:250'],
            'description' => ['nullable', 'string', 'max:400'],
            'groups' => ['nullable', 'array'],
            'groups.*' => [Rule::exists(FitmentGroup::class, 'id')],
            'order' => ['nullable', 'array'],
            'order.*' => ['integer'],
        ];
    }
}
