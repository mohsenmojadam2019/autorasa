<?php

namespace FriendsOfBotble\Sms\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use FriendsOfBotble\Sms\Actions\SendOtpAction;
use FriendsOfBotble\Sms\Facades\Guard;
use Illuminate\Http\Request;

class ResendOtpController extends BaseController
{
    public function __invoke(Request $request, SendOtpAction $sendOtpAction)
    {

        $sendOtpAction($request->phone);

        return $this
            ->httpResponse()
            ->setNextUrl(route('otp.verify',['phone'=>$request->phone]))
            ->setMessage(trans('plugins/sms::otp.otp_sent'));
    }
}
