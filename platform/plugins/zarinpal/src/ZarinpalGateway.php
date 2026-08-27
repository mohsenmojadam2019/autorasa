<?php

namespace Botble\Zarinpal;

use Botble\Ecommerce\Enums\OrderStatusEnum;
use Botble\Ecommerce\Models\Order;
use Botble\Zarinpal\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use RuntimeException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class ZarinpalGateway
{
    public function createPayment($paymentData, $requestData)
    {
        $amount = (int) $requestData['amount'];
        $metadata = $this->normalizeMetadata($requestData['metadata'] ?? []);
        $orderId = $metadata['order_id'] ?? $requestData['order_id'] ?? null;

        try {
            $invoice = (new Invoice())
                ->amount($amount)
                ->detail('metadata', $metadata);

            $payment = Payment::via('zarinpal')
                ->callbackUrl(route('zarinpal.payment.callback'))
                ->purchase($invoice, function ($driver, $transactionId) use ($metadata, $requestData, $orderId, $amount) {
                    Transaction::create([
                        'customer_id' => $requestData['customer_id'] ?? ($metadata['customer_id'] ?? null),
                        'transaction_id' => $transactionId,
                        'token' => $requestData['token'] ?? null,
                        'amount' => $amount,
                        'order_id' => $orderId,
                        'currency' => $requestData['currency'] ?? 'IRT',
                        'metadata' => $metadata,
                        'payment' => ZARINPAL_PAYMENT_METHOD_NAME,
                    ]);
                });

            return [
                'response' => [
                    'code' => $invoice->getUuid(),
                    'amount' => $invoice->getAmount(),
                    'transaction_id' => $invoice->getTransactionId(),
                ],
                'url' => $payment->pay()->getAction(),
            ];
        } catch (Exception $e) {
            throw new RuntimeException('Payment creation failed: ' . $e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    public function verifyPayment(Request $request): array
    {
        $authority = $request->input('Authority');
        $transaction = null;

        try {
            if (! $authority) {
                throw new RuntimeException('Missing Zarinpal Authority.');
            }

            $transaction = Transaction::query()
                ->where('payment', ZARINPAL_PAYMENT_METHOD_NAME)
                ->where('transaction_id', $authority)
                ->firstOrFail();

            $receipt = Payment::via('zarinpal')
                ->amount($transaction->amount)
                ->transactionId($transaction->transaction_id)
                ->verify();

            $orderQuery = Order::query()->whereKey($transaction->order_id);
            if ($transaction->customer_id) {
                $orderQuery->where('user_id', $transaction->customer_id);
            }

            $order = $orderQuery->first();
            if (! $order) {
                throw new RuntimeException('Order associated with the payment was not found.');
            }

            $order->update(['status' => OrderStatusEnum::COMPLETED]);

            $details = $receipt->getDetails();
            $referenceId = (string) $receipt->getReferenceId();
            $code = $details['code'] ?? 0;

            $transaction->update([
                'status' => 'completed',
                'reference_id' => $referenceId,
                'fee' => $details['fee'] ?? 0,
                'card_pan' => $details['card_pan'] ?? null,
                'message' => $details['message'] ?? 'Payment verified',
                'code' => is_numeric($code) ? (int) $code : 0,
            ]);

            return [
                'code' => 0,
                'message' => 'Payment successfully verified.',
                'data' => [
                    'amount' => $transaction->amount,
                    'transaction_id' => $transaction->transaction_id,
                    'reference' => $referenceId,
                    'currency' => $transaction->currency ?: 'IRT',
                    'metadata' => $this->normalizeMetadata($transaction->metadata),
                    'fee' => $details['fee'] ?? 0,
                    'card_pan' => $details['card_pan'] ?? null,
                ],
            ];
        } catch (\Throwable $e) {
            if ($transaction && $transaction->status !== 'completed') {
                $transaction->update([
                    'status' => 'failed',
                    'message' => $e->getMessage(),
                ]);
            }

            report($e);

            return [
                'code' => 500,
                'message' => 'Payment verification failed.',
                'error' => $e->getMessage(),
            ];
        }
    }

    private function normalizeMetadata(mixed $metadata): array
    {
        if (is_array($metadata)) {
            return $metadata;
        }

        if (is_string($metadata) && $metadata !== '') {
            $decoded = json_decode($metadata, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }
}
