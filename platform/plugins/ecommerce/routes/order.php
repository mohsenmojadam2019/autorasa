<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Http\Controllers\Fronts\PublicCheckoutController;
use Botble\Ecommerce\Http\Controllers\Fronts\ServiceCenterController;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function (): void {
    Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers', 'prefix' => 'ecommerce'], function (): void {
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function (): void {
            Route::resource('', 'OrderController')->parameters(['' => 'order']);

            Route::get('reorder', [
                'as' => 'reorder',
                'uses' => 'OrderController@getReorder',
                'permission' => 'orders.create',
            ]);

            Route::get('generate-invoice/{order}', [
                'as' => 'generate-invoice',
                'uses' => 'OrderController@getGenerateInvoice',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('confirm', [
                'as' => 'confirm',
                'uses' => 'OrderController@postConfirm',
                'permission' => 'orders.edit',
            ]);

            Route::post('send-order-confirmation-email/{order}', [
                'as' => 'send-order-confirmation-email',
                'uses' => 'OrderController@postResendOrderConfirmationEmail',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('create-shipment/{order}', [
                'as' => 'create-shipment',
                'uses' => 'OrderController@postCreateShipment',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('cancel-shipment/{shipment}', [
                'as' => 'cancel-shipment',
                'uses' => 'OrderController@postCancelShipment',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('update-shipping-address/{address}', [
                'as' => 'update-shipping-address',
                'uses' => 'OrderController@postUpdateShippingAddress',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('update-tax-information/{taxInformation}', [
                'as' => 'update-tax-information',
                'uses' => 'OrderController@postUpdateTaxInformation',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('cancel-order/{order}', [
                'as' => 'cancel',
                'uses' => 'OrderController@postCancelOrder',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::get('print-shipping-order/{order}', [
                'as' => 'print-shipping-order',
                'uses' => 'OrderController@getPrintShippingOrder',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('confirm-payment/{order}', [
                'as' => 'confirm-payment',
                'uses' => 'OrderController@postConfirmPayment',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::get('get-shipment-form/{order}', [
                'as' => 'get-shipment-form',
                'uses' => 'OrderController@getShipmentForm',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('refund/{order}', [
                'as' => 'refund',
                'uses' => 'OrderController@postRefund',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::get('get-available-shipping-methods', [
                'as' => 'get-available-shipping-methods',
                'uses' => 'OrderController@getAvailableShippingMethods',
                'permission' => 'orders.edit',
            ]);

            Route::post('coupon/apply', [
                'as' => 'apply-coupon-when-creating-order',
                'uses' => 'OrderController@postApplyCoupon',
                'permission' => 'orders.create',
            ]);

            Route::post('check-data-before-create-order', [
                'as' => 'check-data-before-create-order',
                'uses' => 'OrderController@checkDataBeforeCreateOrder',
                'permission' => 'orders.create',
            ]);

            Route::get('orders/{order}/generate', [
                'as' => 'invoice.generate',
                'uses' => 'OrderController@generateInvoice',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey('order');

            Route::get('orders/{order}/download-proof', [
                'as' => 'download-proof',
                'uses' => 'OrderController@downloadProof',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey('order');
        });

        Route::group(['prefix' => 'incomplete-orders', 'as' => 'orders.'], function (): void {
            Route::match(['GET', 'POST'], '', [
                'as' => 'incomplete-list',
                'uses' => 'OrderController@getIncompleteList',
                'permission' => 'orders.index',
            ]);

            Route::get('view/{order}', [
                'as' => 'view-incomplete-order',
                'uses' => 'OrderController@getViewIncompleteOrder',
                'permission' => 'orders.index',
            ])->wherePrimaryKey();

            Route::post('mark-as-completed/{order}', [
                'as' => 'mark-as-completed',
                'uses' => 'OrderController@markIncompleteOrderAsCompleted',
                'permission' => 'orders.index',
            ])->wherePrimaryKey();

            Route::post('send-order-recover-email/{order}', [
                'as' => 'send-order-recover-email',
                'uses' => 'OrderController@postSendOrderRecoverEmail',
                'permission' => 'orders.index',
            ])->wherePrimaryKey();
        });

        Route::group(['prefix' => 'order-returns', 'as' => 'order_returns.'], function (): void {
            Route::resource('', 'OrderReturnController')->parameters(['' => 'order_return'])->except(
                ['create', 'store']
            );
        });
    });
});

Theme::registerRoutes(function (): void {
    Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers\Fronts'], function (): void {
        Route::group(
            ['prefix' => sprintf('%s/{token}', EcommerceHelper::getPageSlug('checkout')), 'as' => 'public.checkout.'],
            function (): void {
                Route::get('/', [
                    'as' => 'information',
                    'uses' => 'PublicCheckoutController@getCheckout',
                ]);

                Route::post('information', [
                    'as' => 'save-information',
                    'uses' => 'PublicCheckoutController@postSaveInformation',
                ]);
// services
                Route::get('services', [
                    'as' => 'services',
                    'uses' => 'PublicCheckoutController@services',
                ]);
// booking
                Route::get('booking-car', [
                    'as' => 'booking-car',
                    'uses' => 'PublicCheckoutController@bookingCar',
                ]);

                Route::post('submit-booking-car', [
                    'as' => 'submit-booking-car',
                    'uses' => 'PublicCheckoutController@submitBookingCar',
                ]);
                Route::post('submit-booking-autoservice', [
                    'as' => 'submit-booking-autoservice',
                    'uses' => 'PublicCheckoutController@submitBookingAutoservice',
                ]);
// address

                Route::get('address', [
                    'as' => 'address',
                    'uses' => 'PublicCheckoutController@address',
                ]);

                Route::post('submit-address', [
                    'as' => 'submit.address',
                    'uses' => 'PublicCheckoutController@submitAddress',
                ]);

                Route::get('address/show', [
                    'as' => 'address.show',
                    'uses' => 'PublicCheckoutController@showAddress',
                ]);

                Route::get('address/edit', [
                    'as' => 'address.edit',
                    'uses' => 'PublicCheckoutController@editAddress',
                ]);

                Route::post('address/update', [
                    'as' => 'address.update',
                    'uses' => 'PublicCheckoutController@updateAddress',
                ]);

// car

                Route::get('select-car', [
                    'as' => 'select-car',
                    'uses' => 'PublicCheckoutController@selectCar',
                ]);

                Route::post('submit-car', [
                    'as' => 'submit.car',
                    'uses' => 'PublicCheckoutController@submitCar',
                ]);



//
                Route::post('select-time-booking', [
                    'as' => 'select-time',
                    'uses' => 'PublicCheckoutController@selectTimeBooking',
                ]);

                Route::get('confirm-booking', [
                    'as' => 'confirm',
                    'uses' => 'PublicCheckoutController@confirmPageBoking',
                ]);


//auto service
//                Route::get('service-center', [
//                    'as' => 'service-center.index',
//                    'uses' => 'ServiceCenterController@index',
//                ]);
//
//                Route::get('service-center/cities/{provinceId}', [
//                    'as' => 'service-center.cities',
//                    'uses' => 'ServiceCenterController@getCitiesByProvince',
//                ]);
//
//                Route::get('service-center/areas/{cityId}', [
//                    'as' => 'service-center.areas',
//                    'uses' => 'ServiceCenterController@getAreasByCity',
//                ]);
//
//                Route::get('service-center/filter', [
//                    'as' => 'service-center.filter',
//                    'uses' => 'ServiceCenterController@getServiceCenters',
//                ]);
//
//                Route::get('service-center/working-hours/{serviceCenterId}', [
//                    'as' => 'service-center.working-hours',
//                    'uses' => 'ServiceCenterController@getWorkingHours',
//                ]);
//
//                Route::post('service-center/submit', [
//                    'as' => 'service-center.submit',
//                    'uses' => 'ServiceCenterController@submitBookingService',
//                ]);


                Route::get('submitForm', 'ServiceCenterController@submitForm')->name('submitForm');
                Route::get('service-center', 'ServiceCenterController@index')->name('service-center.index');
                Route::post('service-center/submit', 'ServiceCenterController@submit')->name('service-center.submit');

                Route::get('service-centers/{area_id}', [ServiceCenterController::class, 'getByArea']);
//                Route::get('{service_center_id}', [ServiceCenterController::class, 'getWorkingHours']);
                Route::post('save-selection', [ServiceCenterController::class, 'saveSelection']);





//
                Route::post('process', [
                    'as' => 'process',
                    'uses' => 'PublicCheckoutController@postCheckout',
                ]);

                Route::get('success', [
                    'as' => 'success',
                    'uses' => 'PublicCheckoutController@getCheckoutSuccess',
                ]);

                Route::get('recover', [
                    'as' => 'recover',
                    'uses' => 'PublicCheckoutController@getCheckoutRecover',
                ]);
            }
        );


//autoservice
        Route::get('service-centers', [ServiceCenterController::class, 'index']);
        Route::post('service-centers/submit', [ServiceCenterController::class, 'submit'])->name('service-center.submit');
        Route::get('cities/{provinceId}', [ServiceCenterController::class, 'getCitiesByProvince']);
        Route::get('areas/{cityId}', [ServiceCenterController::class, 'getAreasByCity']);
        Route::get('service-centers', [ServiceCenterController::class, 'getServiceCenters']);

    });
});
