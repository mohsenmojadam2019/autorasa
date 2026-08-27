<?php

namespace Botble\Ecommerce\Http\Controllers\Fronts;

use App\Models\Province;
use Botble\Autoservice\Models\Autoservice;
use Botble\Ecommerce\Cart\Cart;
use Botble\Ecommerce\Http\Controllers\BaseController;
use Botble\Ecommerce\Models\Booking;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ServiceCenterController extends BaseController
{
    public function index(Request $request)
    {
        session()->put('order_type', 'autoservice');
        $provinces = Province::select('id', 'name')->get();

        return Theme::scope('ecommerce.services.on-spot.service-center.index', compact('provinces'))->render();
    }

    public function saveSelection(Request $request)
    {
        $request->validate([
            'service_center_id' => 'required|exists:service_centers,id',
            'day' => 'required|string',
            'time' => 'required|string',
        ]);

        session()->put('selected_service_center', $request->only(['service_center_id', 'day', 'time']));

        return response()->json(['message' => 'زمان ذخیره شد.']);
    }

    public function submitForm(Request $request, Cart $cart)
    {
        // Autoservice checkout always continues through customer KYC, so it cannot be a guest flow.
        if (! auth('customer')->check()) {
            session()->put('url.intended', url()->previous());

            return $this
                ->httpResponse()
                ->setNextUrl(route('customer.login'));
        }

        $validated = $request->validate([
            'service_center_id' => ['required', 'integer', 'exists:service_centers,id'],
            'booking_date' => ['required', 'date_format:Y-m-d'],
            'booking_time' => ['required', 'date_format:H:i'],
        ]);

        $token = $request->route('token') ?: $request->query('token') ?: $request->input('token');

        if (! $token) {
            throw ValidationException::withMessages([
                'token' => 'توکن ادامه فرایند تسویه‌حساب یافت نشد.',
            ]);
        }

        $serviceCenter = Autoservice::query()->findOrFail($validated['service_center_id']);
        $cartItems = $cart->instance('cart')->content();

        if ($cartItems->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'سبد خرید خالی است.',
            ]);
        }

        DB::beginTransaction();

        try {
            foreach ($cartItems as $item) {
                Booking::create([
                    'customer_id' => auth('customer')->id(),
                    'service_center_id' => $serviceCenter->getKey(),
                    'booking_date' => $validated['booking_date'],
                    'booking_time' => $validated['booking_time'] . ':00',
                    'product_id' => $item->id,
                    'quantity' => $item->qty,
                    'price' => $item->price,
                    'total' => $item->qty * $item->price,
                    'options' => array_merge(
                        method_exists($item->options, 'toArray') ? $item->options->toArray() : [],
                        [
                            'service_center_id' => $serviceCenter->getKey(),
                            'area' => $serviceCenter->area,
                            'city_id' => $serviceCenter->city_id,
                            'province_id' => $serviceCenter->province_id,
                        ]
                    ),
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            return back()->with('error', 'خطا در ثبت رزرو. لطفاً دوباره تلاش کنید.');
        }

        return redirect()->route('public.kyc.list', [
            'redirect' => 'public.checkout.information',
            'token' => $token,
        ])->with('success', 'رزرو خدمات با موفقیت ثبت شد.');
    }
}
