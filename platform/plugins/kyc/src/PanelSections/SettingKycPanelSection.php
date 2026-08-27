<?php

namespace Botble\Kyc\PanelSections;

use Botble\Base\PanelSections\PanelSection;
use Botble\Base\PanelSections\PanelSectionItem;

class SettingKycPanelSection extends PanelSection
{
    public function setup(): void
    {
        $this
            ->setId('settings.kyc')
            ->setTitle(trans('plugins/kyc::kyc.name'))
            ->withPriority(1000)
            ->addItems([
                PanelSectionItem::make('settings.kyc.general_settings')
                    ->setTitle(trans('plugins/kyc::kyc.media.title'))
                    ->withIcon('ti ti-settings')
                    ->withDescription(trans('plugins/kyc::kyc.media.description'))
                    ->withPriority(10)
                    ->withRoute('kyc.media'),
            ]);
    }
}
