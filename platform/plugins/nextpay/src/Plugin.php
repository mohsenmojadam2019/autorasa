<?php

namespace Botble\Nextpay;

use Botble\Setting\Facades\Setting;
use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Setting::delete([
            'payment_nextpay_name',
            'payment_nextpay_description',
            'payment_nextpay_secret',
            'payment_nextpay_merchant_email',
            'payment_nextpay_status',
        ]);
    }
}
