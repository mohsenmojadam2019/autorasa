<?php

namespace Botble\Autoservice;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Autoservices');
        Schema::dropIfExists('Autoservices_translations');
    }
}
