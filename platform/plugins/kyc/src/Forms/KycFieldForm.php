<?php

namespace Botble\Kyc\Forms;

use Botble\Base\Forms\Fields\HiddenField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Forms\MetaBox;
use Botble\Kyc\Enums\KycFieldTypeEnum;
use Botble\Kyc\Enums\KycStatusEnum;
use Botble\Kyc\Http\Requests\KycFieldRequest;
use Botble\Kyc\Models\KYCField;
use Botble\Kyc\Models\KYCGroupField;
use Botble\Kyc\Tables\KycGroupFieldTable;

class KycFieldForm extends FormAbstract
{
    public function setup(): void
    {
        $kyc_entry_id=$this->getRequest()->input('kyc_entry_id')?$this->getRequest()->input('kyc_entry_id'):$this->getModel()->kyc_entry_id;
//        dd($this->getModel()->kyc_entry_id);
        $this
            ->model(KYCField::class)
            ->setValidatorClass(KycFieldRequest::class)
            ->contentOnly(false) // Ensure MetaBoxes are included
            ->add('kyc_entry_id', HiddenField::class, [
                'value' => $this->getRequest()->input('kyc_entry_id'),
            ])
            ->add('kyc_group_field_id', SelectField::class, [
                'label' => trans('plugins/kyc::kyc.group_field'),
                'choices' => KYCGroupField::where('kyc_entry_id', $kyc_entry_id)
                    ->pluck('group_field_name', 'id')
                    ->toArray(),
                'value' => $this->model->kyc_group_field_id ?? null,
                'attr' => [
                    'placeholder' => trans('plugins/kyc::kyc.select_group_field'),
                    'required' => true,
                ],
            ])
            ->add('field_name', TextField::class, [
                'label' => trans('plugins/kyc::kyc.field_name'),
                'attr' => [
                    'placeholder' => 'E.g., National ID',
                    'required' => true,
                ],
            ])
            ->add('field_type', SelectField::class, [
                'label' => trans('plugins/kyc::kyc.field_type'),
                'choices' => KycFieldTypeEnum::toArray(),
                'attr' => [
                    'required' => true,
                    'id' => 'field_type',
                ],
            ])
            ->add(
                'is_required',
                OnOffCheckboxField::class,
                [
                    'label' => trans('plugins/kyc::kyc.is_required'),
                    'defaultValue' => false
                ]
            )
            ->add('status', SelectField::class, [
                'label' => trans('plugins/kyc::kyc.status'),
                'choices' => KycStatusEnum::labels(),
            ]);
        $this->
        addMetaBoxes([
            'group_fields' => [
                'title' => trans('plugins/kyc::kyc.group_fields'),
                'content' => view('plugins/kyc::partials.new-group-action', [
                    'field' => $this->getModel(),
                ])->render(),
                'header_actions' => view('plugins/kyc::partials.new-group-action', [
                    'field' => $this->getModel(),
                ])->render(),
                'has_table' => true,
            ],
        ]);
    }
}
