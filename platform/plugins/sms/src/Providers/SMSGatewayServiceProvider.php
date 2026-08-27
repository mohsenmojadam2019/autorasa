<?php

namespace FriendsOfBotble\Sms\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;
use FriendsOfBotble\Sms\Models\SMSGateway;

class SMSGatewayServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/sms-gateway')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();

            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(SMSGateway::class, [
                    'name',
                ]);
            }

            DashboardMenu::default()->beforeRetrieving(function () {
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-sms gateway',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'plugins/sms gateway::sms gateway.name',
                    'icon' => 'ti ti-box',
                    'url' => route('sms gateway.index'),
                    'permissions' => ['sms gateway.index'],
                ]);
            });
    }
}
