<?php

namespace Botble\Campaign\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\FileField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Campaign\Http\Requests\CampaignRequest;
use Botble\Campaign\Models\Campaign;

class CampaignForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Campaign::class)
            ->setValidatorClass(CampaignRequest::class)
            // Using trans() for labels, assuming the translation keys exist
            ->add('name', TextField::class, NameFieldOption::make()->required()->label(trans('plugins/campaign::campaign.name')))
//            ->add('image', FileField::class, [
//                'label' => trans('plugins/campaign::campaign.image'), // Translation key for Image
//                'required' => false,
//            ])
//            ->add('description', TextField::class, [
//                'label' => trans('plugins/campaign::campaign.description'), // Translation key for Description
//                'required' => false,
//            ])
//            ->add('form_name', TextField::class, [
//                'label' => trans('plugins/campaign::campaign.form_name'), // Translation key for Form Name
//                'required' => false,
//            ])
//            ->add('btn_title', TextField::class, [
//                'label' => trans('plugins/campaign::campaign.btn_title'), // Translation key for Button Title
//                'required' => false,
//            ])
            ->add('status', SelectField::class, StatusFieldOption::make()->label(trans('plugins/campaign::campaign.status')))
            ->setBreakFieldPoint('status');
    }
}
