<?php

namespace Botble\Nextpay;

use Exception;

/**
 * method createPayment()
 */
class NextpayGateway
{
    private string $baseUrl;
    private string $merchantId;
    private string $callbackUrl;

    public function __construct()
    {
        $this->baseUrl = config('plugins.nextpay.general.baseUrl');
        $this->merchantId = config('plugins.nextpay.general.merchantId');
        $this->callbackUrl = config('plugins.nextpay.general.callbackUrl');
    }

    /**
     * @throws Exception
     */
    public function createPayment(int $amount, string $orderId): array
    {
        $data = [
            'api_key' => $this->merchantId,
            'amount' => $amount,
            'order_id' => $orderId,
            'callback_uri' => $this->callbackUrl,
        ];
        $response = $this->makeRequest('token', $data);

        if (isset($response['code']) && $response['code'] == 0) {
            $transId = $response['trans_id'];
            return ['response' => $response ,'url'=> $this->baseUrl . $transId];
        }
        return ['response' => $response ,'url'=> ''];
    }

    public function verifyPayment(string $transId, string $orderId)
    {
        $data = [
            'api_key' => $this->merchantId,
            'trans_id' => $transId,
            'order_id' => $orderId,
        ];

        return $this->makeRequest('verify', $data);
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
