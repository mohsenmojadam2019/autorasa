<?php

namespace Botble\Nextpay\Providers;

use Botble\Base\Facades\Html;
use Botble\Nextpay\Forms\NextpayPaymentMethodForm;
use Botble\Nextpay\NextpayGateway;
use Botble\Nextpay\Services\Gateways\NextpayPaymentService;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Facades\PaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Throwable;

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
                $value = Html::tag('span', PaymentMethodEnum::getLabel($value), ['class' => 'label-success status-label'])->toHtml();
            }

            return $value;
        }, 21, 2);

        add_filter(PAYMENT_FILTER_GET_SERVICE_CLASS, function ($data, $value) {
            if ($value == NEXTPAY_PAYMENT_METHOD_NAME) {
                $data = NextpayPaymentService::class;
            }

            return $data;
        }, 20, 2);
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

        if (! in_array($paymentData['currency'], $supportedCurrencies, true)) {
            $data['error'] = true;
            $data['message'] = __(":name doesn't support :currency. List of currencies supported by :name: :currencies.", [
                'name' => 'Nextpay',
                'currency' => $paymentData['currency'],
                'currencies' => implode(', ', $supportedCurrencies),
            ]);

            return $data;
        }

        try {
            $orderId = $request->input('order_id') ?: Arr::get($paymentData, 'order_id');
            if (is_array($orderId)) {
                $orderId = reset($orderId);
            }

            $requestData = [
                'token' => $paymentData['checkout_token'] ?? null,
                'customer_id' => $paymentData['customer_id'] ?? auth('customer')->id(),
                'currency' => $paymentData['currency'],
                'amount' => (int) $paymentData['amount'],
                'order_id' => $orderId,
                'callback_url' => route('nextpay.payment.callback'),
                'metadata' => [
                    'order_id' => $orderId,
                    'customer_id' => $paymentData['customer_id'] ?? auth('customer')->id(),
                    'customer_type' => $paymentData['customer_type'] ?? null,
                ],
            ];

            do_action('payment_before_making_api_request', NEXTPAY_PAYMENT_METHOD_NAME, $requestData);

            $result = app(NextpayGateway::class)->createPayment($requestData);

            do_action('payment_after_api_response', NEXTPAY_PAYMENT_METHOD_NAME, $requestData, (array) $result['response']);

            if ((int) ($result['response']['code'] ?? -1) === 0 && ! empty($result['url'])) {
                header('Location: ' . $result['url']);
                exit;
            }

            $data['error'] = true;
            $data['message'] = __('Payment failed!');
        } catch (Throwable $exception) {
            report($exception);
            $data['error'] = true;
            $data['message'] = __('Payment failed!');
        }

        return $data;
    }
}
