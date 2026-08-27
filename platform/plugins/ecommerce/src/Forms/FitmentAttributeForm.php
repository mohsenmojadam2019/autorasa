<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\MediaImagesField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Forms\MetaBox;
use Botble\Ecommerce\Enums\FitmentAttributeFieldType;
use Botble\Ecommerce\Forms\Fronts\Auth\FieldOptions\TextFieldOption;
use Botble\Ecommerce\Http\Requests\FitmentAttributeRequest;
use Botble\Ecommerce\Models\FitmentAttribute;
use Botble\Ecommerce\Models\FitmentGroup;

class FitmentAttributeForm extends FormAbstract
{
    public function setup(): void
    {
        $model=$this->model;

        $this
            ->model(FitmentAttribute::class)
            ->setValidatorClass(FitmentAttributeRequest::class)
            ->add(
                'group_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->required()
                    ->label(trans('plugins/ecommerce::product-fitment.fitment_attributes.group'))
                    ->attributes([
                        'placeholder' => trans('plugins/ecommerce::product-fitment.fitment_attributes.group_placeholder'),
                    ])
                    ->choices(FitmentGroup::query()->pluck('name', 'id')->all())
            )
            ->add(
                'name',
                TextField::class,
                NameFieldOption::make()
                    ->required(),
            )
            ->add('icon', TextField::class, [
                'label' => trans('plugins/ecommerce::product-fitment.fitment_attributes.svgicon'),
                'values' => $this->getModel()->icon,
            ])
            ->add(
                'parent_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/ecommerce::product-fitment.fitment_attributes.parent'))
                    ->attributes([
                        'placeholder' => trans('plugins/ecommerce::product-fitment.fitment_attributes.parent_placeholder'),
                    ])
                    ->choices(
                        FitmentAttribute::with('group')->get()
                            ->mapWithKeys(function ($item) {
                                return [
                                    $item->id => $item->name . ' - ' . ($item->group->name ?? trans('plugins/ecommerce::product-fitment.fitment_attributes.no_group')),
                                ];
                            })
                            ->toArray()
                    )

            )

            ->addMetaBox(
                MetaBox::make('fitment-attribute-options')
                    ->hasTable()
                    ->title(trans('plugins/ecommerce::product-fitment.fitment_attributes.options.heading'))
                    ->content(view('plugins/ecommerce::fitment-attributes.partials.options', compact('model')))
            )
        ;
    }
}
