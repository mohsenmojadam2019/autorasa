<?php

namespace Botble\Ecommerce\Rules;

use Illuminate\Contracts\Validation\Rule;
use Botble\Ecommerce\Models\FitmentAttributeOption;

class ValidFitmentOption implements Rule
{
    protected int $attributeId;

    public function __construct(int $attributeId)
    {
        $this->attributeId = $attributeId;
    }

    public function passes($attribute, $value): bool
    {
        return FitmentAttributeOption::where('id', $value)
            ->where('attribute_id', $this->attributeId)
            ->exists();
    }

    public function message(): string
    {
        return 'گزینه انتخاب‌شده به ویژگی مشخص‌شده تعلق ندارد.';
    }
}
