<?php

namespace Botble\Campaign\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;
use Botble\Campaign\Models\Campaign;
use Botble\Campaign\Contracts\Factory;
use Botble\Campaign\CampaignManager;
use Botble\Base\Supports\DashboardMenuItem;

class CampaignServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    public function register(): void
    {
        $this->app->singleton(Factory::class, function ($app) {
            return new CampaignManager();
        });
    }
    public function boot(): void
    {
        $this
            ->setNamespace('plugins/campaign')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->publishAssets()
            ->loadMigrations();

            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Campaign::class, [
                    'name',
                ]);
            }

            DashboardMenu::default()->beforeRetrieving(function () {
                DashboardMenu::registerItem([
                    'id' => 'cms-plugins-campaign',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'plugins/campaign::campaign.name',
                    'icon' => 'ti ti-box',
                    'url' => route('campaign.index'),
                    'permissions' => ['campaign.index'],
                ]);
            });

            DashboardMenu::default()->beforeRetrieving(function () {
                DashboardMenu::make()
                    // Parent Menu: KYC
                    ->registerItem(
                        DashboardMenuItem::make()
                            ->id('cms-plugins-campaign')
                            ->priority(5)
                            ->name('plugins/campaign::campaign.name')
                            ->icon('ti ti-user')
                    )
                    ->registerItem(
                        DashboardMenuItem::make()
                            ->id('cms-plugins-campaign-campaigns')
                            ->parentId('cms-plugins-campaign')
                            ->priority(3)
                            ->name('plugins/campaign::campaign.campaigns')
                            ->icon('ti ti-list-check')
                            ->route('campaign.index')
                    )
                    ->registerItem(
                        DashboardMenuItem::make()
                            ->id('cms-plugins-campaign-operators')
                            ->parentId('cms-plugins-campaign')
                            ->priority(4)
                            ->name('plugins/campaign::campaign.operators')
                            ->icon('ti ti-list-check')
                            ->route('operators.index')

                    )->registerItem(
                        DashboardMenuItem::make()
                            ->id('cms-plugins-campaign-submissions')
                            ->parentId('cms-plugins-campaign')
                            ->priority(5)
                            ->name('plugins/campaign::campaign.submisions')
                            ->icon('ti ti-list-check')
                            ->route('campaignsubmissions.index')

                    );
            });

    }
    public function provides(): array
    {
        return [Factory::class];
    }
}
