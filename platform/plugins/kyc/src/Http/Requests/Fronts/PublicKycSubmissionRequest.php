<?php

namespace Botble\Kyc\Http\Requests\Fronts;

use Botble\Kyc\Enums\KycStatusEnum;
use Botble\Kyc\Models\KYCField;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PublicKycSubmissionRequest extends Request
{
    public function rules(): array
    {
        return [
            'kyc_entry_id' => 'required|exists:kyc_entries,id', // Must exist in the `kyc_entries` table
            'kyc_field_id' => 'required|exists:kyc_fields,id',  // Must exist in the `kyc_fields` table
            'modelable_type' => 'required|string|max:191',      // Should not exceed varchar length
            'modelable_id' => 'required|numeric|min:1',         // Ensure it's a valid ID
            'value' => 'required|string',                       // Optional field for the value
        ];
    }
}
