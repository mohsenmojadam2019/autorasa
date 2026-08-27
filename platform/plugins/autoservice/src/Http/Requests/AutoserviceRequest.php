<?php

namespace Botble\Autoservice\Http\Requests;

use Botble\Support\Http\Requests\Request;

class AutoserviceRequest extends Request
{
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'code'        => ['required', 'string', 'max:100'],
            'province_id' => ['required', 'exists:provinces,id'],
            'city_id'     => ['required', 'exists:cities,id'],
            'area'        => ['nullable', 'string', 'max:255'],
            'address'     => ['required', 'string', 'max:500'],
            'pic'         => ['nullable', 'string', 'max:255'],
            'lat'         => ['required', 'numeric', 'between:-90,90'],
            'long'        => ['required', 'numeric', 'between:-180,180'],
        ];
    }
}
