<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Ecommerce\Http\Controllers\FitmentAttributeController;
use Botble\Ecommerce\Http\Controllers\FitmentGroupController;
use Botble\Ecommerce\Http\Controllers\FitmentTableController;
use Botble\Ecommerce\Http\Middleware\CheckProductFitmentEnabledMiddleware;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function (): void {
    Route::prefix('ecommerce')
        ->name('ecommerce.')
        ->middleware(CheckProductFitmentEnabledMiddleware::class)
        ->group(function (): void {
            Route::prefix('fitment-groups')->name('fitment-groups.')->group(function (): void {
                Route::resource('/', FitmentGroupController::class)->parameters(['' => 'group']);
            });
            Route::prefix('fitment-attributes')->name('fitment-attributes.')->group(function (): void {
                Route::resource('/', FitmentAttributeController::class)->parameters(['' => 'attribute']);

                // Add option (POST)
                Route::post('option/add', [FitmentAttributeController::class, 'addOption'])->name('option.add');
                Route::get('option/children', [FitmentAttributeController::class, 'getChildren'])->name('option.children');

                // Remove option (DELETE)
                Route::delete('option/remove', [FitmentAttributeController::class, 'removeOption'])->name('option.remove');
            });

            Route::prefix('fitment-tables')->name('fitment-tables.')->group(function (): void {
                Route::resource('/', FitmentTableController::class)->parameters(['' => 'table']);
            });
            Route::prefix('fitment-products')->name('fitment-products.')->group(function (): void {
                Route::post('option/add', [\Botble\Ecommerce\Http\Controllers\FitmentProductController::class, 'addOption'])->name('option.add');
                Route::delete('option/remove', [\Botble\Ecommerce\Http\Controllers\FitmentProductController::class, 'removeOption'])->name('option.remove');
                Route::get('option/details', [\Botble\Ecommerce\Http\Controllers\FitmentProductController::class, 'details'])->name('option.details');
                Route::resource('/', \Botble\Ecommerce\Http\Controllers\FitmentProductController::class)->parameters(['' => 'table']);
            });
        });
});
Theme::registerRoutes(function (): void {
    Route::group(
        ['prefix' => 'fitments', 'as' => 'public.fitment.'],
        function (): void {
            Route::get('group/children', [FitmentAttributeController::class, 'getGroupAttributes'])->name('group.children');
            Route::get('option/children', [FitmentAttributeController::class, 'getChildrenPublic'])->name('option.children');

        });
});
