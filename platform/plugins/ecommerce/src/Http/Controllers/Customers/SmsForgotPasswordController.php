<?php

namespace Botble\Ecommerce\Http\Controllers\Customers;

use App\Events\UserAttemptedRegister;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Forms\Fronts\Auth\SmsForgotPasswordForm;
use Botble\Ecommerce\Forms\Fronts\Auth\SmsResetPasswordForm;
use Botble\Ecommerce\Http\Requests\OTPLoginRequest;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
class SmsForgotPasswordController extends BaseController
{
    public string $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('customer.guest', ['except' => 'logout']);
    }

    public function showPhoneForm()
    {
        SeoHelper::setTitle(__('Forgot Password'));

        Theme::breadcrumb()->add(__('Forgot Password'), route('customer.password.smsrequest'));

        if (! in_array(url()->previous(), [route('customer.login'), route('customer.register')])) {
            session(['url.intended' => url()->previous()]);
        }

        return Theme::scope(
            'ecommerce.customers.login',
            ['form' => SmsForgotPasswordForm::create()],
            'plugins/ecommerce::themes.customers.forgotpassword'
        )->render();
    }

    public function sendResetCode(OTPLoginRequest $request)
    {
        event(new UserAttemptedRegister($request->phone));

        return redirect()->route('otpf.resetform', ['phone' => $request->phone]);
    }

}
