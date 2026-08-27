<?php

namespace Botble\Campaign\Forms\Fronts;

use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Campaign\Http\Requests\CampaignRequest;
use Botble\Campaign\Models\Campaign;
use Botble\Theme\FormFront;

class CampaignForm extends FormFront
{
    protected string $errorBag = 'campaign';

    public static function formTitle(): string
    {
        return trans('plugins/campaign::campaign.campaign_form');
    }

    public function setup(): void
    {
//        dd('sdfg');
        $this
            ->contentOnly()
//            ->setUrl(route('public.campaign.subscribe'))
//            ->setFormOption('class', 'subscribe-form')
//            ->setValidatorClass(CampaignRequest::class)
//            ->model(Campaign::class)
//            ->add('wrapper_before', HtmlField::class, HtmlFieldOption::make()->content('<div class="input-group mb-3">'))
//            ->add(
//                'reserve',
//                HtmlField::class,
//                HtmlFieldOption::make()
//                    ->content(<<<'HTML'
//                        <a class="btn btn-primary" href="#"></a>
//                    HTML)
//            )
//            ->add('wrapper_after', HtmlField::class, HtmlFieldOption::make()->content('</div>'))
            ;
    }
}
