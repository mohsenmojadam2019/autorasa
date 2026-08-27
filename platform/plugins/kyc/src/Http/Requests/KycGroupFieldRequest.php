<?php

namespace Botble\Kyc\Http\Requests;

use Botble\Kyc\Enums\KycGroupFieldStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class KycGroupFieldRequest extends Request
{
    public function rules(): array
    {
        return [
            'group_field_name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0', // Ensure order is a non-negative integer
            'status' => ['required', Rule::in(KycGroupFieldStatusEnum::values())], // Validate against the enum values
        ];
    }
}
