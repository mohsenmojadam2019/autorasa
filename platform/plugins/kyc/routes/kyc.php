<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

Theme::registerRoutes(function (): void {
    Route::group(['namespace' => 'Botble\Kyc\Http\Controllers\Fronts'], function (): void {
        Route::group(
            ['prefix' => 'kyc', 'as' => 'public.kyc.'],
            function (): void {
                Route::get('/{user}/{filename}', function ($user, $filename) {
                    $path = storage_path("app/kyc/{$user}/{$filename}");

                    if (!file_exists($path)) {
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
                ]);

                /**
                 * @Depricate
                 */
                Route::post('/delete-file', [
                    'as' => 'deleteFile',
                    'uses' => 'PublicKycController@nextStep',
                ]);
                Route::post('upload-temp-documents', [
                    'as' => 'temp',
                    'uses' => 'PublicKycController@uploadTempDocument',
                    'permission' => false,
                ]);
                Route::post('/submit', [
                    'as' => 'submit',
                    'uses' => 'PublicKycController@uploadDocument',
                ]);
            });
    });
});
