<?php

use App\Http\Controllers\ShahkarController;
use App\Services\SubmitRetailService;
use Botble\Autoservice\Models\Autoservice;
use Botble\Ecommerce\Http\Controllers\Fronts\ServiceCenterController;
use Illuminate\Support\Facades\Route;
use Carbon\CarbonInterface;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;


Route::get('/cart/service-centers/{cityId}', function ($cityId) {
    $services = Autoservice::where('city_id', $cityId)
        ->with(['workingHours.timeSlots', 'timeSlots', 'province', 'city'])
        ->get();

    foreach ($services as $service) {
        $days = [];

        foreach ($service->workingHours as $workingHour) {
            $days[] = $workingHour->day;
        }

        $uniqueDays = array_unique($days);

        $service['dates'] = getUpcomingWeekdaysWithDates($uniqueDays);
    }

    return response()->json([
        'message' => 'Option fetch successfully',
        'data' => ['autoservices' => $services],
    ]);
});
//Route::get('/cart/service-centers/{cityId}', function ($cityId) {
//    $services = \Botble\Autoservice\Models\Autoservice::where('city_id', $cityId)
//        ->with(['workingHours.timeSlots', 'timeSlots', 'province', 'city'])
//        ->get();
//
//    // استخراج روزهای کاری تمام مراکز سرویس‌دهی
//    $days = [];
//    foreach ($services as $service) {
//        foreach ($service->workingHours as $workingHour) {
//            $days[] = $workingHour->day;
//        }
//        $uniqueDays = array_unique($days);
//        $service['dates']=getUpcomingWeekdaysWithDates($uniqueDays);
//    }
//    return response()->json(['message' => 'Option fetch successfully','data'=>['autoservices'=> $services]]);
//});

//GET http://yourdomain.com/provinces
Route::get('/cart/provinces', function () {
    return DB::table('provinces')->get();
})->name('public.cart.provinces');


Route::get('/cart/cities/{province_id}', function ($province_id) {
    return DB::table('cities')->where('province_id', $province_id)->get();
})->name('public.cart.cities');


//Route::get('/cart/service-centers/{cityId}', function ($cityId){
//    return \Botble\Autoservice\Models\Autoservice::where('city_id', $cityId)->with(['workingHours.timeSlots','timeSlots','province','city'])->get();
//
//});
Route::post('/cart/booking', [ServiceCenterController::class, 'submitForm'])->name('submitBooking');

//Route::get('/code', [ShahkarController::class, 'submitNationalCode']);
//Route::get('/inquiryBirthDate', [ShahkarController::class, 'inquiryBirthDate']);




//Route::get('/a', function (SubmitRetailService $submitRetailService) {
//
//    $data = [
//        'password_otpCode' => '123456', // مقدار واقعی وارد کن
//        'BuyerDatiles' => 'خریدار تستی',
//        'PostalCode' => '1234567890',
//        'Stuffs_In' => [
//            [
//                'StuffID' => '10001',
//                'Count' => 1,
//                'Price' => 100000
//            ]
//        ],
//    ];
//
//    $response = $submitRetailService->sendRetailDocument($data);
//
//    return response()->json($response);
//});


//  protected function updateOrderAddressWithBookingData($order): void
//    {
//        $customer = auth('customer')->user();
//
//        if (!$customer || !$order->address) {
//            return;
//        }
//
//        $booking = \Botble\Ecommerce\Models\Booking::where('customer_id', $customer->id)
//            ->latest()
//            ->first();
//        if ($booking) {
//            $order->address->update([
//                'date' => $booking->booking_date,
//                'time' => $booking->booking_time,
//            ]);
//        }
//    }
