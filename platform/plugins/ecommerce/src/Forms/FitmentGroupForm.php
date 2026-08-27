<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Enums\ProductFitmentTypeEnum;
use Botble\Ecommerce\Http\Requests\FitmentGroupRequest;
use Botble\Ecommerce\Models\FitmentAttribute;
use Botble\Ecommerce\Models\FitmentGroup;

class FitmentGroupForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(FitmentGroup::class)
            ->setValidatorClass(FitmentGroupRequest::class)
            ->add(
                'name',
                TextField::class,
                NameFieldOption::make()
                    ->required(),
            )
            ->add(
                'type',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/ecommerce::product-fitment.fitment_attributes.type'))
                    ->attributes([
                        'placeholder' => trans('plugins/ecommerce::product-fitment.fitment_attributes.type_placeholder'),
                    ])
                    ->choices(
                        ProductFitmentTypeEnum::toArray()
                    )
            )
            ->add(
                'description',
                TextareaField::class,
                DescriptionFieldOption::make()
            );
    }
}
