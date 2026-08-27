<?php

namespace Botble\Ecommerce\Http\Controllers\Customers;

use App\Events\UserAttemptedOtpLogin;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Forms\Fronts\Auth\OTPLoginForm;
use Botble\Ecommerce\Http\Requests\OTPLoginRequest;
use Botble\Ecommerce\Models\Customer;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;

class OTPLoginController extends BaseController
{
    public string $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('customer.guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        SeoHelper::setTitle(__('Login'));

        Theme::breadcrumb()->add(__('Login'), route('customer.login'));

        if (! in_array(url()->previous(), [route('customer.login'), route('customer.register')])) {
            session(['url.intended' => url()->previous()]);
        }
        return Theme::scope(
            'ecommerce.customers.login',
            ['form' => OTPLoginForm::create()],
            'plugins/ecommerce::themes.customers.login'
        )->render();
    }

    public function login(OTPLoginRequest $request)
    {
        if (!Customer::where('phone', $request->phone)->exists()) {
            return redirect()->route('customer.register')->with(['messages'=>trans('plugins/ecommerce::customer.phone_not_exist')]);
        }
        event(new UserAttemptedOtpLogin($request->phone));

        return redirect()->route('otpl.login', ['phone' => $request->phone]);
    }

}
