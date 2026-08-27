<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Campaign\Http\Controllers\CampaignController;
use Botble\Campaign\Http\Controllers\OperatorController;
use Botble\Campaign\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'campaigns', 'as' => 'campaign.'], function () {
        Route::resource('', CampaignController::class)->parameters(['' => 'campaign']);
    });
    Route::group(['prefix' => 'campaignsubmissions', 'as' => 'campaignsubmissions.'], function () {
        Route::resource('', SubmissionController::class)->only(['index', 'edit'])->parameters(['' => 'campaignsubmissions']);
//    Route::get('/', [
//        'as' => 'index',
//        'uses' => 'Botble\Campaign\Http\Controllers\SubmissionController@index',
//        'permission' => 'submissions.index',
//    ]);
//    Route::get('/edit/{id}', [
//        'as' => 'index',
//        'uses' => 'Botble\Campaign\Http\Controllers\SubmissionController@edit',
//        'permission' => 'submissions.edit',
//    ]);
    });

    Route::group(['prefix' => 'operators', 'as' => 'operators.'], function () {
        Route::resource('', OperatorController::class)->parameters(['' => 'operator']);
    });

    }
    );

Theme::registerRoutes(function () {
    Route::group(['prefix' => 'campaigns', 'as' => 'campaigns.'], function () {
        Route::get('{campaign}', [\Botble\Campaign\Http\Controllers\Fronts\CampaignController::class, 'show'])->name('show');
        Route::get('/agency/{id}', [\Botble\Campaign\Http\Controllers\Fronts\CampaignController::class, 'agency'])->name('agency');
        Route::post('/reserve', [\Botble\Campaign\Http\Controllers\Fronts\CampaignController::class, 'reserve'])->name('reserve');
    });
});
