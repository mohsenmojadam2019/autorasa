<?php

namespace FriendsOfBotble\Sms\Http\Controllers;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Models\Customer;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use FriendsOfBotble\Sms\Actions\SendOtpAction;
use FriendsOfBotble\Sms\Facades\Otp as OtpFacade;
use FriendsOfBotble\Sms\Forms\PhoneLoginForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneLoginController extends BaseController
{
    public function index(Request $request)
    {
        SeoHelper::setTitle(trans('plugins/sms::sms.phone_number_login'));
        $identifier = $request->phone;
        $form = PhoneLoginForm::create(['phone' => $identifier]);
        $expiryTime = OtpFacade::getExpiryTime($identifier);

        return Theme::scope(
            'otpl.verify',
            compact('form', 'identifier', 'expiryTime'),
            'plugins/sms::phone-login.verify'
        )->render();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'exists:ec_customers,phone'],
            'otp' => ['required', 'digits:4'],
        ]);

        if (! OtpFacade::verify($validated['phone'], $validated['otp'])) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(trans('plugins/sms::sms.your_OTP_is_invalid_or_expired'));
        }

        $customer = Customer::where('phone', $validated['phone'])->firstOrFail();
        Auth::guard('customer')->login($customer);

        return $this
            ->httpResponse()
            ->setNextUrl(session()->pull('url.intended', BaseHelper::getHomepageUrl()))
            ->setMessage(trans('plugins/sms::sms.Your_logedin_successfully'));
    }

    public function resend(Request $request, SendOtpAction $sendOtpAction)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'exists:ec_customers,phone'],
        ]);

        $sendOtpAction($validated['phone']);

        return $this
            ->httpResponse()
            ->setNextUrl(route('otpl.login', ['phone' => $validated['phone']]))
            ->setMessage(trans('plugins/sms::otp.otp_sent'));
    }
}
