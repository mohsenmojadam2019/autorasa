<?php

use Illuminate\Support\Facades\Route;
use App\Services\RemoteSmsService;
use Illuminate\Http\Request;

Route::post('/api/send-remote-sms', function (Request $request, RemoteSmsService $smsService) {
    return $smsService->handle($request);
});
