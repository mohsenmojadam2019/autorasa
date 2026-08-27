<?php

namespace Botble\Behpardakht\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Behpardakht\Providers\HookServiceProvider;


class BehpardakhtServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    public function boot(): void
    {
        if (! is_plugin_active('payment')) {
            return;
        }

        $this->setNamespace('plugins/behpardakht')
            ->loadHelpers()
            ->loadRoutes()
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);

        $config = $this->app['config'];

        $config->set([
            'behpardakht.merchantId' => get_payment_setting('merchantId', BEHPARDAKHT_PAYMENT_METHOD_NAME),
            'behpardakht.paymentUrl' => 'https://behpardakht.com',
        ]);
    }
}
