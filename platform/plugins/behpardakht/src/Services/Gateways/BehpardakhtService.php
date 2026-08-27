<?php

namespace Botble\Behpardakht\Services\Gateways;

use Botble\Behpardakht\Services\Abstracts\BehpardakhtAbstract;
use Illuminate\Http\Request;

class BehpardakhtService extends BehpardakhtAbstract
{
    public function makePayment(Request $request)
    {
    }

    public function afterMakePayment(Request $request)
    {
    }

    public function supportedCurrencyCodes(): array
    {
        return [
            'USD',
            'IRR',
        ];
    }
}
