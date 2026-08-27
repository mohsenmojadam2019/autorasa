<?php

namespace Botble\Kyc\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Kyc\Enums\KycStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class KycRequest extends Request
{
    public function rules(): array
    {
        //
//        if (!$this->route('kyc')) { // Check if it's a new record creation
//            $rules['model'] = 'required|string|max:255';
//        }

        return [
            'status' => Rule::in(KycStatusEnum::values()),
            'model' => 'required|string|max:255',
            'route_name_pattern' => 'required|string|max:255',
            'redirect_if_not_logged_in' => 'required|string|max:255',
        ];
    }
}
