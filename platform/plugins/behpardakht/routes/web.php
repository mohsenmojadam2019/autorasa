<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Behpardakht\Http\Controllers', 'middleware' => ['web', 'core']], function (): void {
    Route::match(['GET', 'POST'], 'behpardakht/payment/callback', [
        'as' => 'behpardakht.payment.callback',
        'uses' => 'BehpardakhtController@getPaymentStatus',
    ]);
});
