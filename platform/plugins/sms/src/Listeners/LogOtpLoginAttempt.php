<?php

namespace FriendsOfBotble\Sms\Listeners;

use App\Events\UserAttemptedOtpLogin;
use FriendsOfBotble\Sms\Actions\SendOtpLoginAction;
use Illuminate\Http\RedirectResponse;

class LogOtpLoginAttempt
{
    public function __construct(
        protected SendOtpLoginAction $sendOtpLoginAction
    ) {
    }

    public function handle(UserAttemptedOtpLogin $event): void
    {

        if (empty($event->phoneNumber)) {
            abort(400, 'Phone number is required.');
        }

        // Call the action and return the redirect response
         ($this->sendOtpLoginAction)($event->phoneNumber);
    }
}

