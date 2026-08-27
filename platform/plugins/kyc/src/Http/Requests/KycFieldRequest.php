<?php

namespace Botble\Kyc\Http\Requests;

use Botble\Kyc\Enums\KycStatusEnum;
use Botble\Kyc\Models\KYCField;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class KycFieldRequest extends Request
{
    public function rules(): array
    {
        return [
            'kyc_group_field_id' => 'required|exists:kyc_group_fields,id', // Ensure the field exists in the kyc_group_fields table
            'field_name' => 'required|string|max:255',
            'field_type' => 'required|string|in:' . implode(',', KYCField::$field_types), // Validate field type against the allowed types
            'is_required' => 'nullable|boolean',
            'status' => ['required', Rule::in(KycStatusEnum::values())], // Ensure status is valid
        ];
    }
}
