<?php

namespace Botble\Nextpay\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Nextpay\NextpayGateway;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Supports\PaymentHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NextpayController extends BaseController
{
    public function getPaymentStatus(Request $request, BaseHttpResponse $response)
    {
        do_action('payment_before_making_api_request', NEXTPAY_PAYMENT_METHOD_NAME, []);

        $result = app(NextpayGateway::class)->verifyPayment($request);

        do_action('payment_after_api_response', NEXTPAY_PAYMENT_METHOD_NAME, [], $result);

        if (($result['code'] ?? -1) !== 0 || ! isset($result['data'])) {
            return $response
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage($result['message'] ?? __('Payment failed!'));
        }

        $metadata = is_array($result['data']['metadata'] ?? null)
            ? $result['data']['metadata']
            : [];

        do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, [
            'amount' => $result['data']['amount'],
            'currency' => $result['data']['currency'],
            'charge_id' => $result['data']['reference'],
            'payment_channel' => NEXTPAY_PAYMENT_METHOD_NAME,
            'status' => PaymentStatusEnum::COMPLETED,
            'customer_id' => Arr::get($metadata, 'customer_id'),
            'customer_type' => Arr::get($metadata, 'customer_type'),
            'payment_type' => 'direct',
            'order_id' => (array) Arr::get($metadata, 'order_id'),
        ], $request);

        return $response
            ->setNextUrl(PaymentHelper::getRedirectURL())
            ->setMessage(__('Checkout successfully!'));
    }
}
