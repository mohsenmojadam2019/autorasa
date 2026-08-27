<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Demo\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'demos', 'as' => 'demo.'], function () {
        Route::resource('', DemoController::class)->parameters(['' => 'demo']);
    });
});
