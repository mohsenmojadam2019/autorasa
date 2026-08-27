<?php

namespace Botble\Nextpay\Services\Gateways;

use Botble\Nextpay\NextpayGateway;
use Botble\Nextpay\Services\Abstracts\NextPayPaymentAbstract;
use Illuminate\Http\Request;

class NextpayPaymentService extends NextPayPaymentAbstract
{
    public function makePayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'order_id' => ['required'],
        ]);

        return app(NextpayGateway::class)->createPayment([
            'amount' => (int) $validated['amount'],
            'order_id' => is_array($validated['order_id']) ? reset($validated['order_id']) : $validated['order_id'],
            'customer_id' => $request->input('customer_id'),
            'token' => $request->input('token'),
            'currency' => $request->input('currency', 'IRR'),
            'callback_url' => route('nextpay.payment.callback'),
            'metadata' => $request->input('metadata', []),
        ]);
    }

    public function afterMakePayment(Request $request)
    {
        return app(NextpayGateway::class)->verifyPayment($request);
    }

    public function supportedCurrencyCodes(): array
    {
        return [
            'IRR',
            'USD',
        ];
    }
}
