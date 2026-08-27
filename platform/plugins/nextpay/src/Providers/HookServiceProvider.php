<?php

namespace Botble\Nextpay\Providers;

use Botble\Base\Facades\Html;
use Botble\Nextpay\NextpayGateway;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Facades\PaymentMethods;
use Botble\Nextpay\Forms\NextpayPaymentMethodForm;
use Botble\Nextpay\Services\Gateways\NextpayPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Throwable;
use Unicodeveloper\Paystack\Facades\Paystack;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, [$this, 'registerNextpayMethod'], 16, 2);
        $this->app->booted(function (): void {
            add_filter(PAYMENT_FILTER_AFTER_POST_CHECKOUT, [$this, 'checkoutWithNextpay'], 16, 2);
        });

        add_filter(PAYMENT_METHODS_SETTINGS_PAGE, [$this, 'addPaymentSettings'], 97);

        add_filter(BASE_FILTER_ENUM_ARRAY, function ($values, $class) {
            if ($class == PaymentMethodEnum::class) {
                $values['NEXTPAY'] = NEXTPAY_PAYMENT_METHOD_NAME;
            }

            return $values;
        }, 21, 2);

        add_filter(BASE_FILTER_ENUM_LABEL, function ($value, $class) {
            if ($class == PaymentMethodEnum::class && $value == NEXTPAY_PAYMENT_METHOD_NAME) {
                $value = 'Nextpay';
            }

            return $value;
        }, 21, 2);

        add_filter(BASE_FILTER_ENUM_HTML, function ($value, $class) {
            if ($class == PaymentMethodEnum::class && $value == NEXTPAY_PAYMENT_METHOD_NAME) {
                $value = Html::tag(
                    'span',
                    PaymentMethodEnum::getLabel($value),
                    ['class' => 'label-success status-label']
                )
                    ->toHtml();
            }

            return $value;
        }, 21, 2);

        add_filter(PAYMENT_FILTER_GET_SERVICE_CLASS, function ($data, $value) {
            if ($value == NEXTPAY_PAYMENT_METHOD_NAME) {
                $data = NextpayPaymentService::class;
            }

            return $data;
        }, 20, 2);

        add_filter(PAYMENT_FILTER_PAYMENT_INFO_DETAIL, function ($data, $payment) {
            if ($payment->payment_channel == NEXTPAY_PAYMENT_METHOD_NAME) {
                $paymentService = (new NextpayPaymentService());
                $paymentDetail = $paymentService->getPaymentDetails($payment);
                if ($paymentDetail) {
                    $data = view(
                        'plugins/nextpay::detail',
                        ['payment' => $paymentDetail, 'paymentModel' => $payment]
                    )->render();
                }
            }

            return $data;
        }, 20, 2);

        add_filter(PAYMENT_FILTER_GET_REFUND_DETAIL, function ($data, $payment, $refundId) {
            if ($payment->payment_channel == NEXTPAY_PAYMENT_METHOD_NAME) {
                $refundDetail = (new NextpayPaymentService())->getRefundDetails($refundId);
                if (!Arr::get($refundDetail, 'error')) {
                    $refunds = Arr::get($payment->metadata, 'refunds');
                    $refund = collect($refunds)->firstWhere('data.id', $refundId);
                    $refund = array_merge($refund, Arr::get($refundDetail, 'data', []));

                    return array_merge($refundDetail, [
                        'view' => view(
                            'plugins/nextpay::refund-detail',
                            ['refund' => $refund, 'paymentModel' => $payment]
                        )->render(),
                    ]);
                }

                return $refundDetail;
            }

            return $data;
        }, 20, 3);
    }

    public function addPaymentSettings(?string $settings): string
    {
        return $settings . NextpayPaymentMethodForm::create()->renderForm();
    }

    public function registerNextpayMethod(?string $html, array $data): string
    {
        PaymentMethods::method(NEXTPAY_PAYMENT_METHOD_NAME, [
            'html' => view('plugins/nextpay::methods', $data)->render(),
        ]);

        return $html;
    }

    public function checkoutWithNextpay(array $data, Request $request): array
    {
        if ($data['type'] !== NEXTPAY_PAYMENT_METHOD_NAME) {
            return $data;
        }

        $supportedCurrencies = (new NextpayPaymentService())->supportedCurrencyCodes();

        $paymentData = apply_filters(PAYMENT_FILTER_PAYMENT_DATA, [], $request);

        if (!in_array($paymentData['currency'], $supportedCurrencies)) {
            $data['error'] = true;
            $data['message'] = __(
                ":name doesn't support :currency. List of currencies supported by :name: :currencies.",
                [
                    'name' => 'Nextpay',
                    'currency' => $paymentData['currency'],
                    'currencies' => implode(', ', $supportedCurrencies),
                ]
            );

            return $data;
        }
        try {
            $requestData = [
                'reference' => Paystack::genTranxRef(),
                'quantity' => 1,
                'currency' => $paymentData['currency'],
                'amount' => (int)$paymentData['amount'] * 100,
                'email' => $paymentData['address']['email'],
                'callback_url' => route('nextpay.payment.callback'),
                'metadata' => json_encode([
                    'order_id' => $paymentData['order_id'],
                    'customer_id' => $paymentData['customer_id'],
                    'customer_type' => $paymentData['customer_type'],
                ]),
            ];
            do_action('payment_before_making_api_request', NEXTPAY_PAYMENT_METHOD_NAME, $requestData);

            $res = app(NextpayGateway::class)->createPayment($paymentData['amount'], $request->order_id);

            do_action('payment_after_api_response', NEXTPAY_PAYMENT_METHOD_NAME, $requestData, (array)$res['response']);

            if (isset($res['response']['code']) && $res['response']['code'] == 0) {
                header('Location: ' . $res['url']);
                exit;
            }

            $data['error'] = true;
            $data['message'] = __('Payment failed!');
        } catch (Throwable $exception) {
            $data['error'] = true;
            $data['message'] = json_encode($exception->getMessage());
        }

        return $data;
    }
}
