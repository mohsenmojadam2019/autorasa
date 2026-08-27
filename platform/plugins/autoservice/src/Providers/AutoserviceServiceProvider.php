<?php

namespace Botble\Autoservice\Providers;

use Botble\Base\Supports\DashboardMenuItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;
use Botble\Autoservice\Models\Autoservice;

class AutoserviceServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/autoservice')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadMigrations();

            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Autoservice::class, [
                    'name',
                ]);
            }

            DashboardMenu::default()->beforeRetrieving(function () {
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-autoservice',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'plugins/autoservice::autoservice.name',
                    'icon' => 'ti ti-box',
                    'url' => route('autoservice.index'),
                    'permissions' => ['autoservice.index'],
                ]);
            });
//        DashboardMenu::default()->beforeRetrieving(function () {
//            DashboardMenu::make()
//                // Parent Menu: KYC
//                ->registerItem(
//                    DashboardMenuItem::make()
//                        ->id('cms-plugins-autoservice')
//                        ->priority(5)
//                        ->name('plugins/autoservice::autoservice.name')
//                        ->icon('ti ti-user')
//                )
//                ->registerItem(
//                    DashboardMenuItem::make()
//                        ->id('cms-plugins-autoservice-autoservices')
//                        ->parentId('cms-plugins-autoservice')
//                        ->priority(3)
//                        ->name('plugins/campaign::autoservice.autoservices')
//                        ->icon('ti ti-list-check')
//                        ->route('autoservice.index')
//                )
//                ->registerItem(
//                    DashboardMenuItem::make()
//                        ->id('cms-plugins-autoservice-works')
//                        ->parentId('cms-plugins-autoservice')
//                        ->priority(4)
//                        ->name('plugins/autoservice::autoservice.hourworks')
//                        ->icon('ti ti-list-check')
//                        ->route('autoservicehourworks.autoservicehourworks.index')
//
//                );
//        });
    }
}
