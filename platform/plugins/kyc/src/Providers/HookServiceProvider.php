<?php

namespace Botble\Kyc\Providers;

use Botble\Base\Contracts\BaseModel;
use Botble\Base\Facades\Assets;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Supports\ServiceProvider;
use Botble\Kyc\Models\Kyc;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\Slug\Facades\SlugHelper;
use Botble\Slug\Forms\Fields\PermalinkField;
use Botble\Theme\Facades\Theme;
use Botble\Theme\FormFront;

class HookServiceProvider extends ServiceProvider
{
    public function boot():void
    {
        //
    }
}
