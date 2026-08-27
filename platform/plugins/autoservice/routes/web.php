<?php

use Botble\Autoservice\Http\Controllers\AutoserviceController;
use Botble\Autoservice\Http\Controllers\AutoserviceHourWorkController;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'autoservices', 'as' => 'autoservice.'], function () {
        Route::resource('', AutoserviceController::class)->parameters(['' => 'autoservice']);

        Route::post('ajax/timeslot/add', [AutoserviceController::class, 'addTimeslot'])->name('ajax.timeslot.add');
        Route::post('ajax/timeslot/edit', [AutoserviceController::class, 'editTimeslot'])->name('ajax.timeslot.edit');
        Route::delete('ajax/timeslot/delete', [AutoserviceController::class, 'deleteTimeslot'])->name('ajax.timeslot.delete');

        Route::post('ajax/working-hour/add', [AutoserviceController::class, 'addWorkingHour'])->name('ajax.working_hour.add');
        Route::post('ajax/working-hour/edit', [AutoserviceController::class, 'editWorkingHour'])->name('ajax.working_hour.edit');
        Route::delete('ajax/working-hour/delete', [AutoserviceController::class, 'deleteWorkingHour'])->name('ajax.working_hour.delete');
    });

    Route::group(['prefix' => 'operators/autoservicehourworks', 'as' => 'autoservicehourworks.'], function () {
        Route::resource('', AutoserviceHourWorkController::class)
            ->parameters(['' => 'autoservicehourwork']);
    });
});
