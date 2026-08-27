<?php

namespace Botble\Zarinpal\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Supports\PaymentHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Botble\Zarinpal\ZarinpalGateway;

class ZarinpalController extends BaseController
{
    public function getPaymentStatus(Request $request, BaseHttpResponse $response)
    {
        do_action('payment_before_making_api_request', ZARINPAL_PAYMENT_METHOD_NAME, []);

        $result = app(ZarinpalGateway::class)->verifyPayment($request);
        do_action('payment_after_api_response', ZARINPAL_PAYMENT_METHOD_NAME, [], $result);

        if (!isset($result['code']) && $result['code'] != 200 || !isset($result['data'])) {
            return $response
                ->setError()
                ->setNextUrl(PaymentHelper::getCancelURL())
                ->setMessage(__('Payment failed!'));
        }


        do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, [
            'amount' => $result['data']['amount'] / 100,
            'currency' => $result['data']['currency'],
            'charge_id' => $result['data']['reference'],
            'payment_channel' => ZARINPAL_PAYMENT_METHOD_NAME,
            'status' => PaymentStatusEnum::COMPLETED,
            'customer_id' => Arr::get($result['data']['metadata'], 'customer_id'),
            'customer_type' => Arr::get($result['data']['metadata'], 'customer_type'),
            'payment_type' => 'direct',
            'order_id' => (array)$result['data']['metadata']['order_id'],
        ], $request);
//
        return $response
            ->setNextUrl(PaymentHelper::getRedirectURL())
            ->setMessage(__('Checkout successfully!'));
    }
}
