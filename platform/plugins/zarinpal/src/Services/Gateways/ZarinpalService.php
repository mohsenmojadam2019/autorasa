<?php

namespace Botble\Zarinpal\Services\Gateways;

use Botble\Zarinpal\Services\Abstracts\ZarinpalAbstract;
use Illuminate\Http\Request;

class ZarinpalService extends ZarinpalAbstract
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
