<?php

if (is_plugin_active('ecommerce')) {
    require_once __DIR__ . '/ecommerce-dimensions.php';

    register_widget(EcommerceDimensions::class);
}
