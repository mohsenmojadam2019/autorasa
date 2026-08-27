<?php

namespace FriendsOfBotble\Sms\Http\Controllers;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Models\Customer;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Carbon\Carbon;
use FriendsOfBotble\Sms\Facades\Guard;
use FriendsOfBotble\Sms\Facades\Otp as OtpFacade;
use FriendsOfBotble\Sms\Forms\PhoneVerificationForm;
use FriendsOfBotble\Sms\Http\Requests\PhoneVerificationRequest;
use Illuminate\Http\Request;

class PhoneVerificationController extends BaseController
{
    public function index(Request $request)
    {
        SeoHelper::setTitle(trans('plugins/sms::sms.phone_number_verification'));

        $identifier = $request->phone;
        $expiryTime = OtpFacade::getExpiryTime($identifier);
        $form = PhoneVerificationForm::create(['phone'=>$identifier]);

        return Theme::scope(
            'otp.verify',
            compact('form', 'identifier', 'expiryTime'),
            'plugins/sms::phone-verification.verify'
        )->render();
    }

    public function store(PhoneVerificationRequest $request)
    {
        $user = Customer::where('phone',$request->phone)->first();

        if (! OtpFacade::verify($user->phone, $request->input('otp'))) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage(trans('plugins/sms::sms.your_OTP_is_invalid_or_expired'));
        }

        $user->phone_verified_at = Carbon::now();
        $user->save();
        auth('customer')->login($user);

        return $this
            ->httpResponse()
            ->setNextUrl(BaseHelper::getHomepageUrl())
            ->setMessage(trans('plugins/sms::sms.Your_phone_number_has_been_verified_successfully'));
    }
}
