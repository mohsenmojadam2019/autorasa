<?php

namespace Botble\Zarinpal\Services;

use LogicException;

class Zarinpal
{
    public function refundOrder($paymentId, $amount): never
    {
        throw new LogicException('Online refund is not supported by this Zarinpal integration.');
    }

    public function getPaymentDetails($transactionId): never
    {
        throw new LogicException('Remote payment-detail lookup is not supported by this Zarinpal integration.');
    }

    public function getListTransactions(array $params = []): never
    {
        throw new LogicException('Remote transaction listing is not supported by this Zarinpal integration.');
    }

    public function getRefundDetails($refundId): never
    {
        throw new LogicException('Online refund is not supported by this Zarinpal integration.');
    }
}
