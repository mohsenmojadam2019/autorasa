<?php

use Botble\Ecommerce\Http\Controllers\API\AddressController;
use Botble\Ecommerce\Http\Controllers\API\BrandController;
use Botble\Ecommerce\Http\Controllers\API\OrderController;
use Botble\Ecommerce\Http\Controllers\API\ProductCategoryController;
use Botble\Ecommerce\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'api/v1/ecommerce/',
    'namespace' => 'Botble\Ecommerce\Http\Controllers\API',
], function (): void {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{slug}', [ProductController::class, 'show']);
    Route::get('products/{slug}/related', [ProductController::class, 'relatedProducts']);
    Route::get('products/{slug}/reviews', [ProductController::class, 'reviews']);

    Route::get('product-categories', [ProductCategoryController::class, 'index']);
    Route::get('product-categories/{slug}', [ProductCategoryController::class, 'show']);
    Route::get('product-categories/{id}/products', [ProductCategoryController::class, 'products']);

    Route::get('brands', [BrandController::class, 'index']);
    Route::get('brands/{slug}', [BrandController::class, 'show']);
    Route::get('brands/{id}/products', [BrandController::class, 'products']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('addresses', [AddressController::class, 'index']);
    });
});
