<?php

namespace Botble\Nextpay\Services\Gateways;

use Botble\Nextpay\Services\Abstracts\NextPayPaymentAbstract;
use Illuminate\Http\Request;

class NextPayPaymentService extends NextPayPaymentAbstract
{
    public function makePayment(Request $request)
    {
    }

    public function afterMakePayment(Request $request)
    {
    }

    /**
     * List currencies supported https://support.nextpay.org.com/hc/en-us/articles/360009973779
     */
    public function supportedCurrencyCodes(): array
    {
        return [
            'IRR',
            'USD',
        ];
    }
}
