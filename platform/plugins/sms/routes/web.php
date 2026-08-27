<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Base\Http\Middleware\DisableInDemoModeMiddleware;
use FriendsOfBotble\Sms\Facades\Guard;
use FriendsOfBotble\Sms\Http\Controllers\PhoneVerificationController;
use FriendsOfBotble\Sms\Http\Controllers\PhoneLoginController;
use FriendsOfBotble\Sms\Http\Controllers\RegisterController;
use FriendsOfBotble\Sms\Http\Controllers\ResendOtpController;
use FriendsOfBotble\Sms\Http\Controllers\SmsController;
use FriendsOfBotble\Sms\Http\Controllers\SmsLogController;
use FriendsOfBotble\Sms\Http\Middleware\EnsurePhoneIsVerified;
use FriendsOfBotble\Sms\Http\Middleware\RedirectIfPhoneIsVerified;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::prefix('sms')->name('sms.')->group(function () {
        Route::group(['prefix' => 'gateways', 'as' => 'gateways.', 'permissions' => 'sms.gateways'], function () {
            Route::get('/', [SmsController::class, 'index'])->name('index');

            Route::middleware(DisableInDemoModeMiddleware::class)->group(function () {
                Route::put('/', [SmsController::class, 'update'])->name('settings');
                Route::post('test', [SmsController::class, 'test'])->name('test');
                Route::post('{driver}', [SmsController::class, 'updateGateway'])->name('update');
                Route::post('{driver}/change-status', [SmsController::class, 'changeStatus'])->name('change-status');
            });
        });

        Route::group(['prefix' => 'logs', 'as' => 'logs.', 'permissions' => 'sms.logs'], function () {
            Route::match(['GET', 'POST'], '/', [SmsLogController::class, 'index'])->name('index');
            Route::get('{id}', [SmsLogController::class, 'show'])->name('show');
            Route::delete('{id}', [SmsLogController::class, 'destroy'])->name('destroy');
        });
    });
});

if (setting('fob_otp_guard')) {
    Theme::registerRoutes(function () {
        Route::prefix('otp')
            ->name('otp.')
//            ->middleware([Guard::getGuard(), RedirectIfPhoneIsVerified::class])
//            ->withoutMiddleware(EnsurePhoneIsVerified::class)
            ->group(function () {
                Route::get('verify/', [PhoneVerificationController::class, 'index'])->name('verify');
                Route::post('verify', [PhoneVerificationController::class, 'store']);
                Route::get('resend', ResendOtpController::class)->name('resend');

            });
        Route::prefix('otpl')
            ->name('otpl.')
//            ->middleware([Guard::getGuard(), RedirectIfPhoneIsVerified::class])
            ->withoutMiddleware(RedirectIfPhoneIsVerified::class)
            ->group(function () {
                Route::get('login', [PhoneLoginController::class, 'index'])->name('login');
                Route::post('login', [PhoneLoginController::class, 'store']);
                Route::post('loginresend', [PhoneLoginController::class,'resend'])->name('resend');
            });
//        Route::prefix('otpr')
//            ->name('otpr.')
////            ->middleware([Guard::getGuard(), RedirectIfPhoneIsVerified::class])
//            ->withoutMiddleware(RedirectIfPhoneIsVerified::class)
//            ->group(function () {
////                Route::get('register', [RegisterController::class, 'index'])->name('registerform');
//                Route::post('register', [RegisterController::class, 'store'])->name('register');
//                Route::post('resend', [RegisterController::class,'resend'])->name('resend');
//            });
    });
}
