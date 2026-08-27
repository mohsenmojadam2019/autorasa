<?php

if (! function_exists('isKYCRequired')) {
    function isKYCRequired($modelType)
    {
        $settings = config('kyc_plugin_settings');
        return $settings['enabled'] && ($settings['models'][$modelType] ?? false);
    }
}
