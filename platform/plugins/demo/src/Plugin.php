<?php

namespace Botble\Demo;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('Demos');
        Schema::dropIfExists('Demos_translations');
    }
}
