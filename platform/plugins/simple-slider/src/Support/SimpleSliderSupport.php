<?php

namespace Botble\SimpleSlider\Support;

use Botble\SimpleSlider\Forms\SimpleSliderItemForm;

class SimpleSliderSupport
{
    public static function registerResponsiveImageSizes(): void
    {
        SimpleSliderItemForm::extend(function (SimpleSliderItemForm $form) {
            $form
                ->addAfter('image', 'desktop_image', 'mediaImage', [
                    'label' => __('Desktop Image'),
                    'help_block' => [
                        'text' => __(
                            'For devices with width from 1440px to 1920px, if empty, will use the image from the main image.'
                        ),
                    ],
                    'metadata' => true,
                ])
                ->addAfter('desktop_image', 'laptop_large_image', 'mediaImage', [
                    'label' => __('Laptop Large Image'),
                    'help_block' => [
                        'text' => __(
                            'For devices with width from 1024px to 1440px, if empty, will use the image from the desktop image.'
                        ),
                    ],
                    'metadata' => true,
                ])
                ->addAfter('laptop_large_image', 'laptop_image', 'mediaImage', [
                    'label' => __('Laptop Image'),
                    'help_block' => [
                        'text' => __(
                            'For devices with width from 768px to 1024px, if empty, will use the image from the laptop large image.'
                        ),
                    ],
                    'metadata' => true,
                ])

                ->addAfter('laptop_image', 'tablet_image', 'mediaImage', [
                    'label' => __('Tablet Image'),
                    'help_block' => [
                        'text' => __(
                            'For devices with width from 480px to 768px, if empty, will use the image from the laptop image.'
                        ),
                    ],
                    'metadata' => true,
                ])
                ->addAfter('tablet_image', 'mobile_image', 'mediaImage', [
                    'label' => __('Mobile Image'),
                    'help_block' => [
                        'text' => __(
                            'For devices with width less than 480px, if empty, will use the image from the tablet image.'
                        ),
                    ],
                    'metadata' => true,
                ]);

            return $form;
        }, 127);
    }
}
