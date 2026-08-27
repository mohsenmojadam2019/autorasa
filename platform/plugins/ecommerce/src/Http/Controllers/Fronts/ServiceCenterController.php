<?php
namespace Botble\Ecommerce\Http\Controllers\Fronts;

use App\Models\Province;
use Botble\Ecommerce\Cart\Cart;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Http\Controllers\BaseController;
use Botble\Ecommerce\Models\Booking;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceCenterController extends BaseController
{
    public function index(Request $request)
    {
//        dd($request);
        session()->put('order_type','autoservice');
        $provinces = Province::select('id', 'name')->get();
        return Theme::scope('ecommerce.services.on-spot.service-center.index', compact('provinces'))->render();
    }



    public function saveSelection(Request $request)
    {
//        dd($request);
        $request->validate([
            'service_center_id' => 'required|exists:service_centers,id',
            'day' => 'required|string',
            'time' => 'required|string',
        ]);

        // فرض می‌کنیم اطلاعات انتخابی در سشن یا جدول موقتی ذخیره شود
        session()->put('selected_service_center', $request->only(['service_center_id', 'day', 'time']));

        return response()->json(['message' => 'زمان ذخیره شد.']);
    }

    public function submitForm(Request $request, Cart $cart)
    {
//        dd($request);
        if (!EcommerceHelper::isEnabledGuestCheckout() && !auth('customer')->check()) {
            return $this
                ->httpResponse()
                ->setNextUrl(route('customer.login'));
        }

        DB::beginTransaction();

        try {
            // Use the injected Cart instance

            foreach ($cart->instance('cart')->content() as $item) {
//                dd([
//                    'type' => gettype($item->options),
//                    'data' => [
//                        'service_center_id' => $request->input('service_center_id'),
//                        'area' => $request->input('area'),
//                        'city_id' => $request->input('city_id'),
//                        'province_id' => $request->input('province_id'),
//                    ],
//                ]);
//dd($request->booking_date);
                Booking::create([
                    'customer_id' => auth('customer')->id(),
                    'service_center_id' => $request->service_center_id,
                    'booking_date' => $request->booking_date,
                    'booking_time' => $request->booking_time . ':00',
                    'product_id' => $item->id,
                    'quantity' => $item->qty,
                    'price' => $item->price,
                    'total' => $item->qty * $item->price,
                    'options' => json_encode(array_merge(
                        method_exists($item->options, 'toArray') ? $item->options->toArray() : [],
                        [
                            'service_center_id' => $request->input('service_center_id'),
                            'area' => $request->input('area'),
                            'city_id' => $request->input('city_id'),
                            'province_id' => $request->input('province_id'),
                        ]
                    )),

                ]);
            }

            DB::commit();

            return redirect()->route('public.kvc.list', ['redirect' => 'public.checkout.information', 'token' => $request->route('token')])
                ->with('success', 'رزرو خدمات با موفقیت ثبت شد.');
        } catch (\Exception $e) {
//            dd($e->getMessage());
            DB::rollBack();
            return back()->with('error', 'خطا در ثبت رزرو: ' . $e->getMessage());
        }
    }

}
