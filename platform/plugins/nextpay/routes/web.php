<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Nextpay\Http\Controllers', 'middleware' => ['web', 'core']], function (): void {
    Route::match(['GET', 'POST'], 'nextpay/payment/callback', [
        'as' => 'nextpay.payment.callback',
        'uses' => 'NextpayController@getPaymentStatus',
    ]);
});
