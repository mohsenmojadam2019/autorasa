<?php
namespace FriendsOfBotble\Sms\Actions;

use FriendsOfBotble\Sms\Facades\Otp;
use FriendsOfBotble\Sms\Facades\Sms;
use Illuminate\Http\RedirectResponse;

class SendOtpLoginAction
{
    public function __invoke(string $phone): void
    {
        $otp = Otp::generate($phone);

//        $message = str_replace(
//            '{code}',
//            $otp->token,
//            setting('fob_otp_message', 'Your OTP code is: {code}')
//        );
        $body_id=setting('fob_otp_bodyid',311122);
        Sms::send($phone, $otp->token,$body_id);
    }
}
