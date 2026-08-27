<?php

namespace Botble\Zarinpal\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class Zarinpal
{
    public function refundOrder($paymentId, $amount)
    {
        $relativeUrl = '/refund';

        $data = [
            'body' => json_encode([
                'transaction' => $paymentId,
                'amount' => $amount * 100,
            ]),
        ];

        do_action('payment_before_making_api_request', ZARINPAL_PAYMENT_METHOD_NAME, $data);

        $this->response = Http::post($this->baseUrl . $relativeUrl, $data);

        do_action('payment_after_api_response', ZARINPAL_PAYMENT_METHOD_NAME, $data, (array)$this->response);

        if ($this->isValid()) {
            return $this->getResponse();
        }

        throw new Exception('Invalid Refund Order Shetabit');
    }

    protected function getResponse(): array
    {
        return json_decode($this->response->getBody(), true);
    }

    public function isValid(): bool
    {
        return $this->getResponse()['status'];
    }

    public function getPaymentDetails($transactionId)
    {
        $relativeUrl = '/transaction/' . $transactionId;

        do_action('payment_before_making_api_request', ZARINPAL_PAYMENT_METHOD_NAME, ['transaction_id' => $transactionId]);

        $this->response = Http::get($this->baseUrl . $relativeUrl);

        do_action('payment_after_api_response', ZARINPAL_PAYMENT_METHOD_NAME, ['transaction_id' => $transactionId], (array)$this->response);

        if ($this->isValid()) {
            return $this->getResponse();
        }

        throw new Exception('Invalid Get Payment Details Paystack');
    }

    public function getListTransactions(array $params = [])
    {
        $relativeUrl = '/transaction' . ($params ? ('?' . http_build_query($params)) : '');

        do_action('payment_before_making_api_request', ZARINPAL_PAYMENT_METHOD_NAME, $params);

        $this->response = Http::get($this->baseUrl . $relativeUrl);

        do_action('payment_after_api_response', ZARINPAL_PAYMENT_METHOD_NAME, $params, (array)$this->response);

        if ($this->isValid()) {
            return $this->getResponse();
        }

        throw new Exception('Invalid Get List Transactions Paystack');
    }

    public function getRefundDetails($refundId)
    {
        $relativeUrl = '/refund/' . $refundId;

        do_action('payment_before_making_api_request', ZARINPAL_PAYMENT_METHOD_NAME, ['refund_id' => $refundId]);

        $this->response = Http::get($this->baseUrl . $relativeUrl);

        do_action('payment_after_api_response', ZARINPAL_PAYMENT_METHOD_NAME, ['refund_id' => $refundId], (array)$this->response);

        if ($this->isValid()) {
            return $this->getResponse();
        }

        throw new Exception('Invalid Refund Order Paystack');
    }

    private function makeRequest(string $endpoint, array $data): array
    {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            throw new Exception('CURL Error: ' . $error);
        }

        return json_decode($response, true) ?? [];
    }
}
