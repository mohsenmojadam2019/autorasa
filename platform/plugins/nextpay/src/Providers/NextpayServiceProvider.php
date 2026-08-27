<?php

namespace Botble\Nextpay\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;

class NextpayServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        if (! is_plugin_active('payment')) {
            return;
        }

        $this->setNamespace('plugins/nextpay')
            ->loadHelpers()
            ->loadRoutes()
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);

        $config = $this->app['config'];

        $config->set([
            'nextpay.publicKey' => get_payment_setting('public', NEXTPAY_PAYMENT_METHOD_NAME),
            'nextpay.secretKey' => get_payment_setting('secret', NEXTPAY_PAYMENT_METHOD_NAME),
            'nextpay.paymentUrl' => 'https://api.nextpay.org',
        ]);
    }
}
