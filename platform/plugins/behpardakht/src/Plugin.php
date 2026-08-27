<?php

namespace Botble\Behpardakht;

use Botble\Setting\Facades\Setting;
use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Setting::delete([
            'payment_behpardakht_name',
            'payment_behpardakht_description',
            'payment_behpardakht_secret',
            'payment_behpardakht_merchant_email',
            'payment_behpardakht_status',
        ]);
    }
}
