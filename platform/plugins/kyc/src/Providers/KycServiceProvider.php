<?php

namespace Botble\Kyc\Providers;

use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\Supports\DashboardMenuItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Facades\DashboardMenu;
use Botble\Ecommerce\PanelSections\SettingEcommercePanelSection;
use Botble\Ecommerce\PanelSections\SettingKycPanelSection;
use Botble\Kyc\Http\Middleware\RedirectIfModelHasNotKYC;
use Botble\Kyc\Models\Kyc;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

class KycServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        // Load and publish resources (configurations, translations, routes, views, migrations, etc.)
        $this
            ->setNamespace('plugins/kyc')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes([
                'kyc',
                'web'
            ])
            ->loadAndPublishViews()
            ->publishAssets()
            ->loadMigrations();

        // Register advanced language module if available
        if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Kyc::class, [
                'name',
            ]);
        }
        DashboardMenu::for('customer')->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-customer-kyc',
                    'priority' => 10,
                    'name' => trans('plugins/kyc::kyc.name'),
                    'url' => fn() => route('public.kyc.showkycs'),
                    'icon' => 'ti ti-home',
                ]);
        });
        // Define dashboard menu items
        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                // Parent Menu: KYC
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-kyc')
                        ->priority(5)
                        ->name('plugins/kyc::kyc.name')
                        ->icon('ti ti-user')
                )
                // Child Menu: Form Builder
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-kyc-forms')
                        ->parentId('cms-plugins-kyc')
                        ->priority(1) // Lower priority for ordering
                        ->name('plugins/kyc::kyc.formbuilder')
                        ->icon('ti ti-file-text')
                        ->route('kyc.index')
                )
                // Child Menu: All Users
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-kyc-alluser')
                        ->parentId('cms-plugins-kyc')
                        ->priority(2)
                        ->name('plugins/kyc::kyc.alluser')
                        ->icon('ti ti-user')
                        ->route('submissions.index')
                // Uncomment the line below if you want to add permissions
                // ->permissions('kyc.edit')
                )
                // Child Menu: Pending KYC Requests
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-kyc-pendings')
                        ->parentId('cms-plugins-kyc')
                        ->priority(3)
                        ->name('plugins/kyc::kyc.pendingkycs')
                        ->icon('ti ti-list-check')
                        ->route('pendingsubmissions.index')
                // Uncomment the line below if you want to add permissions
                // ->permissions('kyc.edit')
                );
        });

        PanelSectionManager::beforeRendering(function (): void {
            PanelSectionManager::default()
                ->register(\Botble\Kyc\PanelSections\SettingKycPanelSection::class);
        });

        // Apply the KYC middleware to Ecommerce routes
        Route::middlewareGroup('apply-kyc-middleware', [
            \Botble\Kyc\Http\Middleware\RedirectIfModelHasNotKYC::class,
        ]);

        // Add KYC middleware to specific routes
        Route::matched(function ($event) {
            $event->route->middleware('apply-kyc-middleware');
        });
    }
}
