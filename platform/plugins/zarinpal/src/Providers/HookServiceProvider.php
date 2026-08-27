<?php

namespace Botble\Zarinpal\Providers;

use Botble\Base\Facades\Html;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Facades\PaymentMethods;
use Botble\Zarinpal\Forms\ZarinpalForm;
use Botble\Zarinpal\Services\Gateways\ZarinpalService;
use Botble\Zarinpal\ZarinpalGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Throwable;
use Illuminate\Support\Facades\Auth;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, [$this, 'registerZarinpalMethod'], 16, 2);
        $this->app->booted(function (): void {
            add_filter(PAYMENT_FILTER_AFTER_POST_CHECKOUT, [$this, 'checkoutWithZarinpal'], 16, 2);
        });

        add_filter(PAYMENT_METHODS_SETTINGS_PAGE, [$this, 'addPaymentSettingsZarinPal'], 97);

        add_filter(BASE_FILTER_ENUM_ARRAY, function ($values, $class) {
            if ($class == PaymentMethodEnum::class) {
                $values['ZARINPAL'] = ZARINPAL_PAYMENT_METHOD_NAME;
            }

            return $values;
        }, 21, 2);

        add_filter(BASE_FILTER_ENUM_LABEL, function ($value, $class) {
            if ($class == PaymentMethodEnum::class && $value == ZARINPAL_PAYMENT_METHOD_NAME) {
                $value = 'Zarinpal';
            }

            return $value;
        }, 21, 2);

        add_filter(BASE_FILTER_ENUM_HTML, function ($value, $class) {
            if ($class == PaymentMethodEnum::class && $value == ZARINPAL_PAYMENT_METHOD_NAME) {
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
            if ($value == ZARINPAL_PAYMENT_METHOD_NAME) {
                $data = ZarinpalService::class;
            }

            return $data;
        }, 20, 2);

        add_filter(PAYMENT_FILTER_PAYMENT_INFO_DETAIL, function ($data, $payment) {
            if ($payment->payment_channel == ZARINPAL_PAYMENT_METHOD_NAME) {
                $paymentService = (new ZarinpalService());
                $paymentDetail = $paymentService->getPaymentDetails($payment);
                if ($paymentDetail) {
                    $data = view(
                        'plugins/zarinpal::detail',
                        ['payment' => $paymentDetail, 'paymentModel' => $payment]
                    )->render();
                }
            }

            return $data;
        }, 20, 2);

        add_filter(PAYMENT_FILTER_GET_REFUND_DETAIL, function ($data, $payment, $refundId) {
            if ($payment->payment_channel == ZARINPAL_PAYMENT_METHOD_NAME) {
                $refundDetail = (new ZarinpalService())->getRefundDetails($refundId);
                if (!Arr::get($refundDetail, 'error')) {
                    $refunds = Arr::get($payment->metadata, 'refunds');
                    $refund = collect($refunds)->firstWhere('data.id', $refundId);
                    $refund = array_merge($refund, Arr::get($refundDetail, 'data', []));

                    return array_merge($refundDetail, [
                        'view' => view(
                            'plugins/zarinpal::refund-detail',
                            ['refund' => $refund, 'paymentModel' => $payment]
                        )->render(),
                    ]);
                }

                return $refundDetail;
            }

            return $data;
        }, 20, 3);
    }

    public function addPaymentSettingsZarinPal(?string $settings): string
    {
        return $settings . ZarinpalForm::create()->renderForm();
    }


    public function registerZarinpalMethod(?string $html, array $data): string
    {
        PaymentMethods::method(ZARINPAL_PAYMENT_METHOD_NAME, [
            'html' => view('plugins/zarinpal::methods', $data)->render(),
        ]);

        return $html;
    }

    public function checkoutWithZarinpal(array $data, Request $request): array
    {
        if ($data['type'] !== ZARINPAL_PAYMENT_METHOD_NAME) {
            return $data;
        }

        $supportedCurrencies = (new ZarinpalService())->supportedCurrencyCodes();

        $paymentData = apply_filters(PAYMENT_FILTER_PAYMENT_DATA, [], $request);
        if (!in_array($paymentData['currency'], $supportedCurrencies)) {
            $data['error'] = true;
            $data['message'] = __(
                ":name doesn't support :currency. List of currencies supported by :name: :currencies.",
                [
                    'name' => 'Zarinpal',
                    'currency' => $paymentData['currency'],
                    'currencies' => implode(', ', $supportedCurrencies),
                ]
            );

            return $data;
        }
        try {
            $requestData = [
                'token' => $paymentData['checkout_token'],
                'customer_id' => auth('customer')->id(),
                'reference' => uniqid(),
                'quantity' => DB::table('ec_order_product')->where('order_id', $request->order_id)->value('qty'),
                'currency' => $paymentData['currency'],
                'amount' => (int)$paymentData['amount'],
                'email' => $paymentData['address']['email'],
                'phone' => $paymentData['address']['phone'],
                'callback_url' => route('zarinpal.payment.callback'),
                'metadata' => json_encode([
                    'order_id' => $request->order_id,
                    'customer_id' => $paymentData['customer_id'],
                    'customer_type' => $paymentData['customer_type'],
                ]),
            ];
            do_action('payment_before_making_api_request', ZARINPAL_PAYMENT_METHOD_NAME, $requestData);
//dd($requestData);
//            $res = app(ZarinpalGateway::class)->createPayment($paymentData['amount'], $request->order_id);
            $res = app(ZarinpalGateway::class)->createPayment($paymentData, $requestData);
//            dd($res['response']['code']);
//            dd($res);

            do_action('payment_after_api_response', ZARINPAL_PAYMENT_METHOD_NAME, $requestData, (array)$res['response']);

            if (isset($res['response']['code']) && !empty($res['response']['code'])) {
                header('Location: ' . $res['url']);
                exit;
            }
//            if (isset($res['response']['code']) && $res['response']['code'] == 0) {
//                header('Location: ' . $res['url']);
//                exit;
//            }

            $data['error'] = true;
            $data['message'] = __('Payment failed!');
        } catch (Throwable $exception) {
            $data['error'] = true;
            $data['message'] = json_encode($exception->getMessage());
        }

        return $data;
    }
}
