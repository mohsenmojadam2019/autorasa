<?php

namespace Botble\Nextpay;

use Botble\Ecommerce\Enums\OrderStatusEnum;
use Botble\Ecommerce\Models\Order;
use Botble\Nextpay\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use RuntimeException;

class NextpayGateway
{
    private string $baseUrl;
    private string $paymentUrl;
    private string $merchantId;
    private string $callbackUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('plugins.nextpay.general.baseUrl'), '/') . '/';
        $this->paymentUrl = rtrim((string) config('plugins.nextpay.general.apiPaymentUrl'), '/') . '/';
        $this->merchantId = (string) config('plugins.nextpay.general.merchantId');
        $this->callbackUrl = (string) config('plugins.nextpay.general.callbackUrl');
    }

    public function createPayment(array $requestData): array
    {
        $amount = (int) ($requestData['amount'] ?? 0);
        $orderId = (string) ($requestData['order_id'] ?? '');

        if ($amount <= 0 || $orderId === '') {
            throw new RuntimeException('NextPay amount and order_id are required.');
        }

        $data = [
            'api_key' => $this->merchantId,
            'amount' => $amount,
            'order_id' => $orderId,
            'callback_uri' => $requestData['callback_url'] ?? $this->callbackUrl,
        ];

        $response = $this->makeRequest('token', $data);

        if ((int) ($response['code'] ?? -1) !== 0 || empty($response['trans_id'])) {
            return ['response' => $response, 'url' => ''];
        }

        $transId = (string) $response['trans_id'];
        $metadata = $this->normalizeMetadata($requestData['metadata'] ?? []);

        Transaction::create([
            'customer_id' => $requestData['customer_id'] ?? ($metadata['customer_id'] ?? null),
            'amount' => $amount,
            'order_id' => (int) $orderId,
            'transaction_id' => $transId,
            'token' => $requestData['token'] ?? null,
            'currency' => $requestData['currency'] ?? 'IRR',
            'metadata' => $metadata,
            'status' => 'pending',
            'code' => 0,
        ]);

        return [
            'response' => $response,
            'url' => $this->paymentUrl . $transId,
        ];
    }

    public function verifyPayment(Request $request): array
    {
        $transId = (string) $request->input('trans_id', '');
        $transaction = null;

        try {
            if ($transId === '') {
                throw new RuntimeException('Missing NextPay trans_id.');
            }

            $transaction = Transaction::query()
                ->where('transaction_id', $transId)
                ->firstOrFail();

            $result = $this->makeRequest('verify', [
                'api_key' => $this->merchantId,
                'trans_id' => $transaction->transaction_id,
                'order_id' => (string) $transaction->order_id,
            ]);

            $code = (int) ($result['code'] ?? -1);
            if ($code !== 0) {
                $transaction->update([
                    'status' => 'failed',
                    'code' => $code,
                    'message' => $result['message'] ?? 'NextPay verification failed.',
                ]);

                return [
                    'code' => $code,
                    'message' => $result['message'] ?? 'Payment verification failed.',
                    'error' => $result,
                ];
            }

            $orderQuery = Order::query()->whereKey($transaction->order_id);
            if ($transaction->customer_id) {
                $orderQuery->where('user_id', $transaction->customer_id);
            }

            $order = $orderQuery->first();
            if (! $order) {
                throw new RuntimeException('Order associated with the payment was not found.');
            }

            $order->update(['status' => OrderStatusEnum::COMPLETED]);

            $reference = (string) ($result['Shaparak_Ref_Id'] ?? $result['ref_id'] ?? $transId);

            $transaction->update([
                'status' => 'completed',
                'reference_id' => $reference,
                'code' => 0,
                'message' => $result['message'] ?? 'Payment verified',
            ]);

            return [
                'code' => 0,
                'message' => 'Payment successfully verified.',
                'data' => [
                    'amount' => $transaction->amount,
                    'transaction_id' => $transaction->transaction_id,
                    'reference' => $reference,
                    'currency' => $transaction->currency ?: 'IRR',
                    'metadata' => $this->normalizeMetadata($transaction->metadata),
                    'fee' => 0,
                    'card_pan' => null,
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

    private function makeRequest(string $endpoint, array $data): array
    {
        $url = $this->baseUrl . ltrim($endpoint, '/');
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        curl_close($ch);

        if ($error) {
            throw new RuntimeException('CURL Error: ' . $error);
        }

        if ($status >= 400 || ! is_string($response)) {
            throw new RuntimeException('NextPay returned HTTP status ' . $status . '.');
        }

        $decoded = json_decode($response, true);
        if (! is_array($decoded)) {
            throw new RuntimeException('NextPay returned an invalid JSON response.');
        }

        return $decoded;
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
