<?php

namespace Botble\Campaign;

use Botble\Base\Facades\AdminHelper;
use Botble\Base\Forms\FieldOptions\CheckboxFieldOption;
use Botble\Base\Forms\FieldOptions\EmailFieldOption;
use Botble\Base\Forms\Fields\CheckboxField;
use Botble\Base\Forms\Fields\EmailField;
use Botble\Campaign\Forms\Fronts\CampaignForm;
use Botble\Theme\Events\RenderingThemeOptionSettings;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Facades\ThemeOption;
use Botble\Theme\ThemeOption\Fields\MediaImageField;
use Botble\Theme\ThemeOption\Fields\MultiCheckListField;
use Botble\Theme\ThemeOption\Fields\NumberField;
use Botble\Theme\ThemeOption\Fields\TextareaField;
use Botble\Theme\ThemeOption\Fields\TextField;
use Botble\Theme\ThemeOption\Fields\ToggleField;
use Botble\Theme\ThemeOption\ThemeOptionSection;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

class CampaignManager
{
    public function registerCampaignPopup(bool $keepHtmlDomOnClose = false): void
    {
        app('events')->listen(RenderingThemeOptionSettings::class, function (): void {
            ThemeOption::setSection(
                ThemeOptionSection::make('opt-text-subsection-campaign-popup')
                    ->title(__('Campaign Popup'))
                    ->icon('ti ti-mail-opened')
                    ->fields([
                        ToggleField::make()
                            ->name('campaign_popup_enable')
                            ->label(__('Enable Campaign Popup')),
                        MediaImageField::make()
                            ->name('campaign_popup_image')
                            ->label(__('Popup Image')),
                        TextField::make()
                            ->name('campaign_popup_title')
                            ->label(__('Popup Title')),
                        TextField::make()
                            ->name('campaign_popup_capacity')
                            ->label(__('Popup capacity')),
                        TextField::make()
                            ->name('campaign_popup_btn_title')
                            ->label(__('Popup button title')),
                        TextareaField::make()
                            ->name('campaign_popup_description')
                            ->label(__('Popup Description')),
                        NumberField::make()
                            ->name('campaign_popup_delay')
                            ->label(__('Popup Delay (seconds)'))
                            ->defaultValue(5)
                            ->helperText(__('Set the delay time to show the popup after the page is loaded. Set 0 to show the popup immediately.'))
                            ->attributes([
                                'min' => 0,
                            ]),
                        MultiCheckListField::make()
                            ->name('campaign_popup_display_pages')
                            ->label(__('Display on pages'))
                            ->inline()
                            ->defaultValue(['homepage'])
                            ->options(apply_filters('campaign_popup_display_pages', [
                                'public.index' => __('Homepage'),
                                'all' => __('All Pages'),
                            ])),
                    ])
            );
        });

        app('events')->listen(RouteMatched::class, function () use ($keepHtmlDomOnClose): void {
            if (
                is_plugin_active('campaign')
                && theme_option('campaign_popup_enable', false)
                && ($keepHtmlDomOnClose || ! isset($_COOKIE['campaign_popup']))
                && ! AdminHelper::isInAdmin()
            ) {
                $displayPages = json_decode(theme_option('campaign_popup_display_pages', '[]'), true) ?: ['public.index'];

                if (
                    ! in_array('all', $displayPages)
                    && ! in_array(Route::currentRouteName(), $displayPages)
                ) {
                    return;
                }
                $ignoredBots = [
                    'googlebot', // Googlebot
                    'bingbot', // Microsoft Bingbot
                    'slurp', // Yahoo! Slurp
                    'ia_archiver', // Alexa
                    'Chrome-Lighthouse', // Google Lighthouse
                ];

                if (in_array(strtolower(request()->userAgent()), $ignoredBots)) {
                    return;
                }
                Theme::asset()
                    ->add('campaign', asset('vendor/core/plugins/campaign/css/campaign.css'));

                Theme::asset()
                    ->container('footer')
                    ->add('campaign', asset('vendor/core/plugins/campaign/js/campaign.js'), ['jquery']);

                add_filter(THEME_FRONT_BODY, function (?string $html): string {
                    return $html . view('plugins/campaign::partials.campaign-popup');
                });
            }
        });
    }

}
