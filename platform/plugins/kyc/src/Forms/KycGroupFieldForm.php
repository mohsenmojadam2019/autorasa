<?php

namespace Botble\Kyc\Forms;

use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\HiddenField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Kyc\Enums\KycGroupFieldStatusEnum;
use Botble\Kyc\Http\Requests\KycGroupFieldRequest;
use Botble\Kyc\Models\KYCGroupField;

class KycGroupFieldForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(KYCGroupField::class)
            ->setValidatorClass(KycGroupFieldRequest::class)
            ->contentOnly()
            ->add('kyc_entry_id', HiddenField::class, [
                'value' => $this->getRequest()->input('kyc_entry_id'),
            ])
            ->add('group_field_name', TextField::class, [
                'label' => trans('plugins/kyc::kyc.field_name'),
                'attr' => [
                    'placeholder' => trans('plugins/kyc::kyc.placeholders.group_field_name'),
                    'required' => true,
                ],
            ])
            ->add('order', NumberField::class, [
                'label' => trans('plugins/kyc::kyc.field_order'),
                'attr' => [
                    'required' => true,
                ],
            ])
            ->add('status', SelectField::class, StatusFieldOption::make()->choices(KycGroupFieldStatusEnum::labels()));
    }
}
