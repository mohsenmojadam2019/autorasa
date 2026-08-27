<?php

use ArchiElite\UrlRedirector\Http\Controllers\UrlRedirectorController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Zarinpal\Http\Controllers', 'middleware' => ['web', 'core']], function (): void {
    Route::get('behpardakht/payment/callback', [
        'as' => 'behpardakht.payment.callback',
        'uses' => 'BehpardakhtController@getPaymentStatus',
    ]);
});

//Route::get('{any}', [UrlRedirectorController::class, 'handle'])->where('any', '.*');
