<?php

namespace FriendsOfBotble\Sms\Providers;

use App\Events\UserAttemptedOtpLogin;
use FriendsOfBotble\Sms\Listeners\LogOtpForgotPasswordAttempt;
use FriendsOfBotble\Sms\Listeners\LogOtpLoginAttempt;
use FriendsOfBotble\Sms\Listeners\SendOtpNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendOtpNotification::class,
        ],
        UserAttemptedOtpLogin::class => [
            LogOtpLoginAttempt::class,
        ],
    ];
}
