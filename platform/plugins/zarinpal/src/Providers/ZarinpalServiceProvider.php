<?php

namespace Botble\Zarinpal\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Zarinpal\Providers\HookServiceProvider;


class ZarinpalServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    public function boot(): void
    {
        if (! is_plugin_active('payment')) {
            return;
        }

        $this->setNamespace('plugins/zarinpal')
            ->loadHelpers()
            ->loadRoutes()
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);

        $config = $this->app['config'];

        $config->set([
            'zarinpal.merchantId' => get_payment_setting('merchantId', ZARINPAL_PAYMENT_METHOD_NAME),
            'zarinpal.paymentUrl' => 'https://zarinpal.com',
        ]);
    }
}
