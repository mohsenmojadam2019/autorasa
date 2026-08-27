<?php

namespace Botble\Zarinpal\Services\Abstracts;

use Botble\Payment\Services\Traits\PaymentErrorTrait;
use Botble\Support\Services\ProduceServiceInterface;
use Botble\Zarinpal\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

abstract class ZarinpalAbstract implements ProduceServiceInterface
{
    use PaymentErrorTrait;

    protected ?string $paymentCurrency = null;
    protected bool $supportRefundOnline;
    protected float $totalAmount;

    public function __construct()
    {
        $this->paymentCurrency = config('plugins.payment.payment.currency');
        $this->totalAmount = 0;
        $this->supportRefundOnline = false;
    }

    public function getSupportRefundOnline(): bool
    {
        return $this->supportRefundOnline;
    }

    public function setCurrency($currency)
    {
        $this->paymentCurrency = $currency;

        return $this;
    }

    public function getCurrency()
    {
        return $this->paymentCurrency;
    }

    public function getPaymentDetails($payment)
    {
        return Transaction::query()
            ->where('payment', ZARINPAL_PAYMENT_METHOD_NAME)
            ->where(function ($query) use ($payment) {
                $query->where('reference_id', $payment->charge_id)
                    ->orWhere('transaction_id', $payment->charge_id);
            })
            ->first()?->toArray() ?: false;
    }

    public function refundOrder($paymentId, $amount): array
    {
        return [
            'error' => true,
            'message' => 'Online refund is not supported by this Zarinpal integration.',
        ];
    }

    public function getRefundDetails($refundId): array
    {
        return [
            'error' => true,
            'message' => 'Online refund is not supported by this Zarinpal integration.',
        ];
    }

    public function execute(Request $request)
    {
        try {
            return $this->makePayment($request);
        } catch (Exception $exception) {
            $this->setErrorMessageAndLogging($exception, 1);

            return false;
        }
    }

    abstract public function makePayment(Request $request);

    abstract public function afterMakePayment(Request $request);
}
