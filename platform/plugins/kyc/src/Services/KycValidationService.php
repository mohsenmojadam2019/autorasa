<?php

namespace Botble\Kyc\Services;

use Botble\Kyc\Enums\KycEnum;
use Botble\Kyc\Models\Kyc;
use Botble\Kyc\Models\KYCField;
use Botble\Kyc\Models\KYCSubmission;
use Botble\Kyc\Traits\DetectGuard;
use Illuminate\Support\Facades\Auth;

class KycValidationService
{
    use DetectGuard;

    public function getKycStatus(string $modelType, int $modelId): string
    {
        $guard = $this->detectGuard();

        $authenticatedModel = Auth::guard($guard)->user();

        $kycEntry = Kyc::where('model', $modelType)
            ->where('status', 'activate')
            ->first();

        if (!$kycEntry) {
            return KycEnum::KYC_PENDING; // No KYC entry exists for this model
        }

        // Get all required fields for the KYC entry
        $requiredFields = KYCField::where('kyc_entry_id', $kycEntry->id)
            ->where('is_required', true)
            ->where('status', 'activate') // Ensure the field is active
            ->pluck('id')
            ->toArray();
// dd($requiredFields);
        if (empty($requiredFields)) {
            return KycEnum::KYC_COMPLETED; // No required fields for this KYC entry
        }
        // Check submitted fields
        $submittedFieldIds = KYCSubmission::where('modelable_type', $authenticatedModel::class)
            ->where('modelable_id', $authenticatedModel->id)
            ->whereIn('kyc_field_id', $requiredFields)
            ->pluck('kyc_field_id')
            ->toArray();

        if (empty($submittedFieldIds)) {
            return KycEnum::KYC_PENDING; // No fields submitted
        }

        if (empty(array_diff($requiredFields, $submittedFieldIds))) {
            return KycEnum::KYC_COMPLETED; // All required fields submitted
        }

        return KycEnum::KYC_IN_PROGRESS; // Some fields submitted, but not all
    }
}
