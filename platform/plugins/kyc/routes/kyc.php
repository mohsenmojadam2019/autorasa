<?php

use Botble\Kyc\Http\Controllers\Fronts\PublicKycController;
use Botble\Kyc\Http\Middleware\ValidateKycSubmission;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Theme::registerRoutes(function (): void {
    Route::group(['namespace' => 'Botble\Kyc\Http\Controllers\Fronts'], function (): void {
        Route::group(
            [
                'prefix' => 'kyc',
                'as' => 'public.kyc.',
                'middleware' => ['auth:customer'],
            ],
            function (): void {
                Route::get('/{user}/{filename}', function ($user, $filename) {
                    $path = storage_path("app/kyc/{$user}/{$filename}");

                    if (! file_exists($path)) {
                        abort(404);
                    }

                    return Response::file($path);
                })->where('filename', '.*\.(jpg|png|pdf|jpeg|gif|webp)');

                Route::get('/showkycs', [
                    'as' => 'showkycs',
                    'uses' => 'PublicKycController@showKycs',
                ]);

                Route::get('/showgroupfield/{id}', [
                    'as' => 'showgroupfield',
                    'uses' => 'PublicKycController@showgroupfield',
                ]);

                Route::get('/fill/{id}', [
                    'as' => 'showfield',
                    'uses' => 'PublicKycController@showField',
                ]);

                Route::post('/fill/store', [
                    'as' => 'storekyc',
                    'uses' => 'PublicKycController@storekyc',
                ]);

                Route::get('/list/{redirect?}/{token?}', [
                    'as' => 'list',
                    'uses' => 'PublicKycController@getKyc',
                ]);

                Route::post('/prev-step', [
                    'as' => 'prevStep',
                    'uses' => 'PublicKycController@prevStep',
                ]);

                Route::post('/next-step', [
                    'as' => 'nextStep',
                    'uses' => 'PublicKycController@nextStep',
                ])->middleware(ValidateKycSubmission::class);

                Route::post('/delete-file', [
                    'as' => 'deleteFile',
                    'uses' => 'PublicKycController@deleteFile',
                ]);
            }
        );
    });
});
