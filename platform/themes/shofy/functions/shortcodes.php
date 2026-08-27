<?php

use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\CoreIconFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\RadioFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\UiSelectorFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\CoreIconField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\RadioField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UiSelectorField;
use Botble\Ecommerce\Models\Brand;
use Botble\Ecommerce\Models\Dimension;
use Botble\Newsletter\Forms\Fronts\NewsletterForm;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Shortcode\ShortcodeField;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Carbon\Carbon;
use Illuminate\Support\Arr;

app()->booted(function (): void {
    ThemeSupport::registerGoogleMapsShortcode(Theme::getThemeNamespace('partials.shortcodes.google-maps'));
    ThemeSupport::registerYoutubeShortcode();

    Shortcode::register('site-features', __('Site Features'), __('Site Features'), function (ShortcodeCompiler $shortcode) {
        $tabs = Shortcode::fields()->getTabsData(['title', 'description', 'icon'], $shortcode);

        return Theme::partial('shortcodes.site-features.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setPreviewImage('site-features', Theme::asset()->url('images/shortcodes/site-features/style-1.png'));

    Shortcode::setAdminConfig('site-features', function (array $attributes) {
        $styles = [];

        foreach (range(1, 4) as $i) {
            $styles[$i] = [
                'label' => __('Style :number', ['number' => $i]),
                'image' => Theme::asset()->url(sprintf('images/shortcodes/site-features/style-%s.png', $i)),
            ];
        }

        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'style',
                UiSelectorField::class,
                UiSelectorFieldOption::make()
                    ->choices($styles)
                    ->selected(Arr::get($attributes, 'style', 1))
            )
            ->add(
                'features',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->fields([
                        'title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                            'required' => true,
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'title' => __('Description'),
                            'required' => false,
                        ],
                        'icon' => [
                            'type' => 'coreIcon',
                            'title' => __('Icon'),
                            'required' => true,
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->add(
                'icon_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->label(__('Icon color'))
                    ->defaultValue('#fd4b6b')
            );
    });

    Shortcode::register('app-downloads', __('App Downloads'), __('App Downloads'), function (ShortcodeCompiler $shortcode): ?string {
        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);

        return Theme::partial('shortcodes.app-downloads.index', compact('shortcode', 'platforms'));
    });

    Shortcode::setPreviewImage('app-downloads', Theme::asset()->url('images/shortcodes/app-downloads.png'));

    Shortcode::setAdminConfig('app-downloads', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'open_wrapper_google',
                HtmlField::class,
                ['html' => '<div class="form-fieldset">']
            )
            ->add(
                'google_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Google label'))
                    ->placeholder(__('Enter Google label'))
            )
            ->add(
                'google_icon',
                CoreIconField::class,
                CoreIconFieldOption::make()
                    ->label(__('Google Play icon'))
            )
            ->add(
                'google_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Google URL'))
                    ->placeholder(__('Enter Google URL'))
            )
            ->add('close_wrapper_google', HtmlField::class, ['html' => '</div>'])
            ->add('open_wrapper_apple', HtmlField::class, ['html' => '<div class="form-fieldset">'])
            ->add(
                'apple_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Apple label'))
                    ->placeholder(__('Enter Apple label'))
            )
            ->add(
                'apple_icon',
                CoreIconField::class,
                CoreIconFieldOption::make()
                    ->label(__('Apple icon'))
            )
            ->add(
                'apple_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Apple URL'))
                    ->placeholder(__('Enter Apple URL'))
            )
            ->add('close_wrapper_apple', HtmlField::class, ['html' => '</div>'])
            ->add(
                'screenshot',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Mobile screenshot'))
            )
            ->add(
                'shape_image_left',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Shape image left'))
            )
            ->add(
                'shape_image_right',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Shape image right'))
            );
    });

    Shortcode::register('steps', __('Steps'), __('Steps'), function (ShortcodeCompiler $shortcode): ?string {
        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);

        return Theme::partial('shortcodes.steps.index', compact('shortcode', 'platforms'));
    });

    Shortcode::setPreviewImage('steps', Theme::asset()->url('images/shortcodes/steps.png'));

    Shortcode::setAdminConfig('steps', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'step1_title_open',
                HtmlField::class,
                ['html' => '<div class="form-fieldset">']
            )
            ->add(
                'step1_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Step 1 Title'))
                    ->placeholder(__('Enter the title'))
            )
            ->add(
                'step1_desc',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Step 1 Description'))
                    ->placeholder(__('Enter the description'))
            )
            ->add('step1_title_close', HtmlField::class, ['html' => '</div>'])
            ->add(
                'step2_title_open',
                HtmlField::class,
                ['html' => '<div class="form-fieldset">']
            )
            ->add(
                'step2_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Step 2 Title'))
                    ->placeholder(__('Enter the title'))
            )
            ->add(
                'step2_desc',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Step 2 Description'))
                    ->placeholder(__('Enter the description'))
            )
            ->add('step2_title_close', HtmlField::class, ['html' => '</div>'])
            ->add(
                'step3_title_open',
                HtmlField::class,
                ['html' => '<div class="form-fieldset">']
            )
            ->add(
                'step3_label',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Step 1 Title'))
                    ->placeholder(__('Enter the title'))
            )
            ->add(
                'step3_desc',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Step 3 Description'))
                    ->placeholder(__('Enter the description'))
            )
            ->add('step3_title_close', HtmlField::class, ['html' => '</div>'])
            ->add(
                'banner',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Banner'))
            );
    });
//search conteiner
    Shortcode::register('searchcontainer', __('Search Contaier'), __('Search Contaier'), function (ShortcodeCompiler $shortcode): ?string {
        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);

        return Theme::partial('shortcodes.searchcontainer.index', compact('shortcode', 'platforms'));
    });

    Shortcode::setPreviewImage('searchcontainer', Theme::asset()->url('images/shortcodes/searchcontainer.png'));

    Shortcode::setAdminConfig('searchcontainer', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'title_tire',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Tire'))
            )
            ->add(
                'main_banner',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Main Banner'))
            )
            ->add(
                'mobile_banner',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Mobile Banner'))
            )
//            ->add(
//                'title_batry',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Batry'))
//            )
//            ->add(
//                'title_roghan',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Roghan')))
//            ->add(
//                'title_bime',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Bime')))
            ;
    });


    //banner conteiner
    Shortcode::register('banner', __('Banner'), __('Banner'), function (ShortcodeCompiler $shortcode): ?string {
        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);

        return Theme::partial('shortcodes.banner.index', compact('shortcode', 'platforms'));
    });

    Shortcode::setPreviewImage('banner', Theme::asset()->url('images/shortcodes/banner.png'));

    Shortcode::setAdminConfig('banner', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'main_banner',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Main Banner'))
            )
            ->add(
                'mobile_banner',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Mobile Banner'))
            )
            ;
    });
//    badget

    Shortcode::register('badget-counter', __('Badget-counter'), __('Badget-counter'), function (ShortcodeCompiler $shortcode): ?string {
        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);

        return Theme::partial('shortcodes.badget-counter.index', compact('shortcode', 'platforms'));
    });

    Shortcode::setPreviewImage('badget-counter', Theme::asset()->url('images/shortcodes/badget-counter.png'));

    Shortcode::setAdminConfig('badget-counter', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'markaz_faal',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Markaz Faal'))
            )
            ->add(
                'markaz_faal_counter',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Markaz Faal Counter'))
            )
            ->add(
                'sayar',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Khodro Nasb Sayar')))
            ->add(
                'sayar_counter',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Sayar Counter')))
            ->add(
                'brand',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Brand')))
            ->add(
                'brand_counter',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Brand Counter')))
           ;
    });


//    category-slider

    Shortcode::register('category-slider', __('Category-slider'), __('Category-slider'), function (ShortcodeCompiler $shortcode): ?string {
        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);

        return Theme::partial('shortcodes.category-slider.index', compact('shortcode', 'platforms'));
    });

    Shortcode::setPreviewImage('category-slider', Theme::asset()->url('images/shortcodes/category-slider.png'));

    Shortcode::setAdminConfig('category-slider', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title_tire',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Tire'))
            )
            ->add(
                'title_batry',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Batry'))
            )
            ->add(
                'title_roghan',
                TextField::class,
                TextFieldOption::make()
                        ->label(__('Roghan')))
            ->add(
                'title_bime',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Bime')))
            ;
    });
//
    Shortcode::register('image', __('Image'), __('Image'), function (ShortcodeCompiler $shortcode): ?string {
        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);

        return Theme::partial('shortcodes.image.index', compact('shortcode', 'platforms'));
    });

    Shortcode::setPreviewImage('image', Theme::asset()->url('images/shortcodes/image.png'));

    Shortcode::setAdminConfig('image', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
//            ->add(
//                'step1_title_open',
//                HtmlField::class,
//                ['html' => '<div class="form-fieldset">']
//            )
//            ->add(
//                'alignment',
//                SelectField::class,
//                SelectFieldOption::make()
//                    ->label(__('Select Alignment'))
//                    ->choices([
//                        'right' => __('Right'),
//                        'left' => __('Left'),
//                    ])
//                    ->selected(Arr::get($attributes, 'alignment', 'right')) // Default to 'right'
//                    ->searchable(false) // No need for search in only two choices
//                    ->wrapperAttributes([
//                        'class' => 'mb-3 position-relative',
//                        'data-bb-value' => 'brand_position',
//                        'style' => sprintf('display: %s', Arr::get($attributes, 'type') === 'alignment' ? 'block' : 'none'),
//                    ]),
//            )
            ->add(
                'alt',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Alt'))
                    ->placeholder(__('Enter the alt'))
            )
//            ->add('step1_title_close', HtmlField::class, ['html' => '</div>'])
//            ->add(
//                'step2_title_open',
//                HtmlField::class,
//                ['html' => '<div class="form-fieldset">']
//            )
//            ->add(
//                'step2_label',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Step 2 Title'))
//                    ->placeholder(__('Enter the title'))
//            )
//            ->add(
//                'step2_desc',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Step 2 Description'))
//                    ->placeholder(__('Enter the description'))
//            )
//            ->add('step2_title_close', HtmlField::class, ['html' => '</div>'])
//            ->add(
//                'step3_title_open',
//                HtmlField::class,
//                ['html' => '<div class="form-fieldset">']
//            )
//            ->add(
//                'step3_label',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Step 1 Title'))
//                    ->placeholder(__('Enter the title'))
//            )
//            ->add(
//                'step3_desc',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Step 3 Description'))
//                    ->placeholder(__('Enter the description'))
//            )
//            ->add('step3_title_close', HtmlField::class, ['html' => '</div>'])
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            );
    });

//    Shortcode::register('campaign', __('Campaign'), __('Campaign'), function (ShortcodeCompiler $shortcode): ?string {
////        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);
//
//        return Theme::partial('shortcodes.campaign.index');
//    });
//
//    Shortcode::setPreviewImage('campaign', Theme::asset()->url('images/shortcodes/campaign.png'));
//
//    Shortcode::setAdminConfig('campaign', function (array $attributes) {
//        return ShortcodeForm::createFromArray($attributes)
//            ->withLazyLoading()
//            ->add(
//                'title',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Title'))
//            )
//            ->add(
//                'form_name',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Form name'))
//                    ->placeholder(__('Enter the form name'))
//            )
//            ->add(
//                'description',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Description'))
//                    ->placeholder(__('Enter the description'))
//            )
//            ->add(
//                'btn_title',
//                TextField::class,
//                TextFieldOption::make()
//                    ->label(__('Button Title'))
//                    ->placeholder(__('Enter the button title'))
//            )
//            ->add(
//                'banner',
//                MediaImageField::class,
//                MediaImageFieldOption::make()
//                    ->label(__('Banner'))
//            );
//    });
    Shortcode::register('tpabanner', __('TPA Banner'), __('TPA Banner'), function (ShortcodeCompiler $shortcode): ?string {
        $platforms = Shortcode::fields()->getTabsData(['image', 'url'], $shortcode);

        return Theme::partial('shortcodes.tpabanner.index', compact('shortcode', 'platforms'));
    });

    Shortcode::setPreviewImage('tpabanner', Theme::asset()->url('images/shortcodes/tpabanner.png'));

    Shortcode::setAdminConfig('tpabanner', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'heading_title_open',
                HtmlField::class,
                ['html' => '<div class="form-fieldset">']
            )
            ->add(
                'heading_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Heading Title'))
                    ->placeholder(__('Enter the heading title'))
            )
            ->add(
                'heading_desc',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Heading Description'))
                    ->placeholder(__('Enter the heading description'))
            )
            ->add('heading_title_close', HtmlField::class, ['html' => '</div>'])
            ->add(
                'contact_open',
                HtmlField::class,
                ['html' => '<div class="form-fieldset">']
            )
            ->add(
                'phone',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Phone number'))
                    ->placeholder(__('Enter the phone number'))
            )
            ->add(
                'weekly_schedule',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Weekly schedule'))
                    ->placeholder(__('Enter the weekly schedule'))
            )
            ->add('contact_close', HtmlField::class, ['html' => '</div>'])
            ;
    });


    Shortcode::register(
        'image-slider',
        __('Image Slider'),
        __('Dynamic carousel for featured content with customizable links.'),
        function (ShortcodeCompiler $shortcode) {
            $tabs = [];
            $brands = [];
            $dimensions = [];

            switch ($shortcode->type) {
                case 'custom':
                    $tabs = Shortcode::fields()->getTabsData(['name', 'image', 'url'], $shortcode);

                    if (empty($tabs)) {
                        return null;
                    }

                    break;

                case 'brands':
                    $brandIds = Shortcode::fields()->getIds('brand_ids', $shortcode);

                    if (empty($brandIds)) {
                        return null;
                    }

                    $brands = Brand::query()
                        ->wherePublished()
                        ->whereIn('id', $brandIds)
                        ->get();

                    if (empty($brands)) {
                        return null;
                    }

                    break;

                case 'dimensions':
                    $dimensionIds = Shortcode::fields()->getIds('dimension_ids', $shortcode);

                    if (empty($dimensionIds)) {
                        return null;
                    }

                    $dimensions = Dimension::query()
                        ->wherePublished()
                        ->whereIn('id', $dimensionIds)
                        ->get();

                    if (empty($dimensions)) {
                        return null;
                    }

                    break;
            }

            return Theme::partial('shortcodes.image-slider.index', compact('shortcode', 'tabs', 'brands', 'dimensions'));
        }
    );

    Shortcode::setPreviewImage('image-slider', Theme::asset()->url('images/shortcodes/image-slider.png'));

    Shortcode::setAdminConfig('image-slider', function (array $attributes) {
        $types = [
            'custom' => __('Custom'),
        ];

        if (is_plugin_active('ecommerce')) {
            $types['brands'] = __('Brands');
        }

        if (is_plugin_active('ecommerce')) {
            $types['dimensions'] = __('Dimensions');
        }

        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->add(
                'type',
                RadioField::class,
                RadioFieldOption::make()
                    ->label(__('Get data from to show'))
                    ->choices($types)
                    ->attributes([
                        'data-bb-toggle' => 'collapse',
                        'data-bb-target' => '.image-slider',
                    ]),
            )
            ->when(is_plugin_active('ecommerce'), function (ShortcodeForm $form) use ($attributes): void {
                $form->add(
                    'brand_ids',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Brands'))
                        ->choices(
                            Brand::query()
                                ->wherePublished()
                                ->pluck('name', 'id')
                                ->all()
                        )
                        ->selected(ShortcodeField::parseIds(Arr::get($attributes, 'brand_ids')))
                        ->searchable()
                        ->multiple()
                        ->wrapperAttributes([
                            'class' => 'mb-3 position-relative image-slider',
                            'data-bb-value' => 'brands',
                            'style' => sprintf('display: %s', Arr::get($attributes, 'type') === 'brands' ? 'block' : 'none'),
                        ]),
                );

                $form->add(
                    'dimension_ids',
                    SelectField::class,
                    SelectFieldOption::make()
                        ->label(__('Dimensions'))
                        ->choices(
                            Dimension::query()
                                ->wherePublished()
                                ->pluck('name', 'id')
                                ->all()
                        )
                        ->selected(ShortcodeField::parseIds(Arr::get($attributes, 'dimension_ids')))
                        ->searchable()
                        ->multiple()
                        ->wrapperAttributes([
                            'class' => 'mb-3 position-relative image-slider',
                            'data-bb-value' => 'dimensions',
                            'style' => sprintf('display: %s', Arr::get($attributes, 'type') === 'dimensions' ? 'block' : 'none'),
                        ]),
                );
            })
            ->add(
                'open_tabs_wrapper',
                HtmlField::class,
                ['html' => sprintf('<div class="image-slider" data-bb-value="custom" style="display: %s">', Arr::get($attributes, 'type') === 'custom' ? 'block' : 'none')]
            )
            ->add(
                'tabs',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->fields([
                        'name' => [
                            'type' => 'text',
                            'title' => __('Name'),
                        ],
                        'image' => [
                            'type' => 'image',
                            'title' => __('Image'),
                            'required' => true,
                        ],
                        'url' => [
                            'type' => 'text',
                            'title' => __('URL'),
                        ],
                    ])
                    ->attrs($attributes)
            )
            ->add('close_tabs_wrapper', HtmlField::class, ['html' => '</div>']);
    });

    Shortcode::register('about', __('About'), __('About'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.about.index', compact('shortcode'));
    });

    Shortcode::setPreviewImage('about', Theme::asset()->url('images/shortcodes/about.png'));

    Shortcode::setAdminConfig('about', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->columns()
            ->add(
                'title_1',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title 1'))
                    ->colspan(2)
            )
            ->add(
                'description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Description'))
                    ->colspan(2)
            )
            ->add(
                'title_2',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title 2'))
                    ->colspan(2)
            )
            ->add(
                'image_1',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image 1'))
            )
            ->add(
                'image_2',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image 2'))
            )
            ->add(
                'image_3',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image 3'))
            );
    });








    Shortcode::register('installservices', __('install services'), __('install services'), function (ShortcodeCompiler $shortcode) {
        return Theme::partial('shortcodes.installservices.index', compact('shortcode'));
    });

    Shortcode::setPreviewImage('installservices', Theme::asset()->url('images/shortcodes/installservices.png'));

    Shortcode::setAdminConfig('installservices', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->withLazyLoading()
            ->columns()
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            )
            ;
    });

    Shortcode::register('coming-soon', __('Coming Soon'), __('Coming Soon'), function (ShortcodeCompiler $shortcode): string {
        try {
            $countdownTime = Carbon::parse($shortcode->countdown_time);
        } catch (Exception) {
            $countdownTime = null;
        }

        $form = null;

        if (is_plugin_active('newsletter')) {
            $form = NewsletterForm::create();
        }

        return Theme::partial('shortcodes.coming-soon.index', compact('shortcode', 'countdownTime', 'form'));
    });

    Shortcode::setAdminConfig('coming-soon', function (array $attributes): ShortcodeForm {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
            )
            ->add(
                'countdown_time',
                'datetime',
                [
                    'label' => __('Countdown time'),
                    'default_value' => Carbon::now()->addDays(7)->format('Y-m-d H:i'),
                ]
            )
            ->add(
                'address',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Address'))
            )
            ->add(
                'hotline',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Hotline'))
            )
            ->add(
                'business_hours',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Business hours'))
            )
            ->add(
                'show_social_links',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(__('Show social links'))
                    ->defaultValue(true)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
            );
    });
});
