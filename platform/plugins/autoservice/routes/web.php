<?php

use Botble\Autoservice\Http\Controllers\AutoserviceController;

AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'autoservices', 'as' => 'autoservice.'], function () {
        Route::resource('', AutoserviceController::class)->parameters(['' => 'autoservice']);

        // AJAX routes for timeslots and working hours
        Route::post('ajax/timeslot/add', [AutoserviceController::class, 'addTimeslot'])->name('ajax.timeslot.add');
        Route::post('ajax/timeslot/edit', [AutoserviceController::class, 'editTimeslot'])->name('ajax.timeslot.edit');
        Route::delete('ajax/timeslot/delete', [AutoserviceController::class, 'deleteTimeslot'])->name('ajax.timeslot.delete');

        Route::post('ajax/working-hour/add', [AutoserviceController::class, 'addWorkingHour'])->name('ajax.working_hour.add');
        Route::post('ajax/working-hour/edit', [AutoserviceController::class, 'editWorkingHour'])->name('ajax.working_hour.edit');
        Route::delete('ajax/working-hour/delete', [AutoserviceController::class, 'deleteWorkingHour'])->name('ajax.working_hour.delete');
    });

    Route::group(['prefix' => 'operators', 'as' => 'autoservicehourworks.'], function () {
        Route::resource('autoservicehourworks', \Botble\Autoservice\Http\Controllers\AutoserviceHourWorkController::class)
            ->parameters(['autoservicehourworks' => 'autoservicehourwork']);
    });
});

