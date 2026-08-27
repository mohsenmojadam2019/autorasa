<?php

namespace Botble\Zarinpal;

use Botble\Setting\Facades\Setting;
use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Setting::delete([
            'payment_zarinpal_name',
            'payment_zarinpal_description',
            'payment_zarinpal_secret',
            'payment_zarinpal_merchant_email',
            'payment_zarinpal_status',
        ]);
    }
}
