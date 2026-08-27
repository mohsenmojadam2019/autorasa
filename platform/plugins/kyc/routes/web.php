<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Kyc\Http\Controllers\KycController;
use Botble\Kyc\Http\Controllers\KycFieldController;
use Botble\Kyc\Http\Controllers\KycSubmissionController;
use Botble\Kyc\Http\Controllers\KycPendingSubmissionController;
use Illuminate\Support\Facades\Route;
use \Botble\Kyc\Http\Controllers\MediaSettingController;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'pendingsubmissions', 'as' => 'pendingsubmissions.'], function () {
        Route::resource('/', KycPendingSubmissionController::class);
    });
        Route::group(['prefix' => 'submissions', 'as' => 'submissions.'], function () {
        Route::resource('/', KycSubmissionController::class)
            ->parameters(['' => 'model']);
        Route::post('/submissions/{kyc_submission}/approve', [
            'as' => 'approve',
            'uses' => 'Botble\Kyc\Http\Controllers\KycSubmissionController@approve',
            'permission' => 'submissions.approve',
        ]);
        Route::post('/submissions/{kyc_submission}/reject', [
            'as' => 'reject',
            'uses' => 'Botble\Kyc\Http\Controllers\KycSubmissionController@reject',
            'permission' => 'submissions.reject',
        ]);
//        Route::post('/submissions/{kyc_submission}/reject', [KycSubmissionController::class, 'reject'])
//            ->name('submissions.reject');
    });
    Route::group(['prefix' => 'kyc-fields', 'as' => 'kyc-fields.'], function (): void {
        Route::resource('', 'Botble\Kyc\Http\Controllers\KycFieldController')->except([
            'index',
        ])->parameters(['' => 'kyc-fields']);

        Route::match(['GET', 'POST'], 'list/{id}', [
            'as' => 'index',
            'permission'=>'kyc-fields.edit',
            'uses' => 'Botble\Kyc\Http\Controllers\KycFieldController@index',
        ])->wherePrimaryKey();

        Route::get('kyc-fields', [
            'permission'=>'kyc-fields.edit',
            'uses' => 'Botble\Kyc\Http\Controllers\KycFieldController@edit',
        ]);

        Route::put('simple-sliders', [
            'permission'=>'kyc-fields.edit',
            'uses' => 'Botble\Kyc\Http\Controllers\KycFieldController@update',
        ]);
    });
    Route::group(['prefix' => 'kyc-group-fields', 'as' => 'kyc-group-fields.'], function (): void {
        Route::resource('', 'Botble\Kyc\Http\Controllers\KycGroupFieldController')->except([
            'index',
        ])->parameters(['' => 'kyc-group-fields']);

        Route::match(['GET', 'POST'], 'list/{id}', [
            'as' => 'index',
            'permission'=>'kyc-group-fields.index',
            'uses' => 'Botble\Kyc\Http\Controllers\KycGroupFieldController@index',
        ])->wherePrimaryKey();

        Route::get('kyc-group-fields', [
            'permission'=>'kyc-group-fields.edit',
            'uses' => 'Botble\Kyc\Http\Controllers\KycGroupFieldController@edit',
        ]);

        Route::put('simple-sliders', [
            'permission'=>'kyc-group-fields.edit',
            'uses' => 'Botble\Kyc\Http\Controllers\KycGroupFieldController@update',
        ]);
    });

    Route::group(['prefix' => 'kycs', 'as' => 'kyc.'], function () {
        Route::prefix('media')->group(function (): void {
            Route::get('/', [
                'as' => 'media',
                'uses' => '\Botble\Kyc\Http\Controllers\KYCSettingController@edit',
            ]);

            Route::put('/', [
                'as' => 'media.update',
                'uses' => '\Botble\Kyc\Http\Controllers\KYCSettingController@update',
                'permission' => 'settings.media',
                'middleware' => 'preventDemo',
            ]);

            Route::post('generate-thumbnails', [
                'as' => 'media.generate-thumbnails',
                'uses' => '\Botble\Kyc\Http\Controllers\KYCSettingController@generateThumbnails',
                'permission' => 'settings.media',
                'middleware' => 'preventDemo',
            ]);
        });
        Route::resource('', KycController::class)->parameters(['' => 'kyc']);





    });
});
