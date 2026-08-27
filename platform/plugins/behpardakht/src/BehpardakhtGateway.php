<?php

namespace Botble\Behpardakht;

use Botble\Ecommerce\Enums\OrderStatusEnum;
use Botble\Ecommerce\Models\Order;
use Botble\Behpardakht\Models\Transaction;
use Illuminate\Http\Request;
use Shetabit\Multipay\Drivers\Behpardakht\Behpardakht;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\InvoiceNotFoundException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Exceptions\TimeoutException;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;
use Exception;
use Illuminate\Support\Facades\Session;

class BehpardakhtGateway
{
    public function createPayment($paymentData, $requestData)
    {
        $amount = $requestData['amount'];
        $metadata = [
            'customer_id' => $requestData['customer_id'] ?? null,
            'amount' => $requestData['amount'] ?? null,
            'metadata' => $requestData['metadata'] ?? null,
            'token' => $requestData['token'] ?? null,
            'order_id' => $requestData['metadata'] ? json_decode($requestData['metadata'], true)['order_id'] : null,
        ];
        try {
            $invoice = (new Invoice())
                ->amount($amount)
                ->detail('metadata', $metadata);

            $payment = Payment::via('behpardakht')
                ->callbackUrl(route('behpardakht.payment.callback'))
                ->purchase($invoice, function ($driver, $transactionId) use ($metadata) {

                    Transaction::create([
                        'customer_id' => $metadata['customer_id'],
                        'transaction_id' => $transactionId,
                        'token' => $metadata['token'],
                        'amount' => $metadata['amount'],
                        'order_id' => $metadata['order_id'],
                        'metadata' => $metadata['metadata'],
                        'payment' => 'behpardakht',
                    ]);

                });

            $paymentUrl = $payment->pay()->getAction();


            return [
                'response' => [
                    'code' => $invoice->getUuid(),
                    'amount' => $invoice->getAmount(),
                    'transaction_id' => $invoice->getTransactionId(),
                ],
                'url' => $paymentUrl,

            ];
        } catch (Exception $e) {
            throw new Exception('امکان اتصال برقرار نیست: ' . $e->getMessage() . ' | Code: ' . $e->getCode() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
        }
    }


    public function verifyPayment(Request $request)
    {
        $authority = $request->Authority;

        try {
            $transaction = Transaction::where('transaction_id', $authority)->firstOrFail();

            $receipt = Payment::via('behpardakht')->amount($transaction->amount)->verify();

            Order::where('user_id', $transaction->customer_id)->where('id', $transaction->order_id)->first()->update(['status' => OrderStatusEnum::COMPLETED]);

            $details = $receipt->getDetails();

            $transaction->update([
                'status' => 'completed',
                'reference_id' => $receipt->getReferenceId(),
                'fee' => $details['fee'] ?? 0,
                'card_pan' => $details['card_pan'] ?? null,
                'message' => $details['message'] ?? 'Payment verified',
                'code' => $details['code'] ?? 101,
            ]);

            return $response=[

                'code' => $details['code'],
                'message' => 'Payment successfully verified.',
                'data' => [
                    'amount' => $transaction->amount,
                    'transaction_id' => $transaction->transaction_id,
                    'reference' => $receipt->getReferenceId(),
                    'currency' => 'IRT',
                    'metadata' => json_decode($transaction->metadata, true),
                    'fee' => $details['fee'] ?? 0,
                    'card_pan' => $details['card_pan'] ?? null,
                ]
            ];
        } catch (Exception $e) {
            return [
                'code' => 500,
                'message' => 'Payment verification failed.',
                'error' => $e->getMessage(),
            ];
        }
    }


}
