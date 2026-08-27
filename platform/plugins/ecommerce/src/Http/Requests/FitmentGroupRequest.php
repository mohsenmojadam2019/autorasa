<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Ecommerce\Enums\ProductFitmentTypeEnum;
use Botble\Support\Http\Requests\Request;

class FitmentGroupRequest extends Request
{
    public function rules(): array
    {
//        dd(implode(',', ProductFitmentTypeEnum::toArray()));
        return [
            'name' => ['required', 'string', 'max:250'],
            'type' => ['nullable'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
