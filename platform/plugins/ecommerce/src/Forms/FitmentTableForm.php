<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Facades\Assets;
use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Http\Requests\FitmentTableRequest;
use Botble\Ecommerce\Models\FitmentGroup;
use Botble\Ecommerce\Models\FitmentTable;

class FitmentTableForm extends FormAbstract
{
    public function setup(): void
    {
        Assets::addScripts('jquery-ui');

        $groups = FitmentGroup::query()->pluck('name', 'id');

        $this
            ->model(FitmentTable::class)
            ->setValidatorClass(FitmentTableRequest::class)
            ->add(
                'name',
                TextField::class,
                NameFieldOption::make()
                    ->label(trans('plugins/ecommerce::product-fitment.fitment_tables.fields.name'))
                    ->required(),
            )
            ->add(
                'description',
                TextareaField::class,
                DescriptionFieldOption::make()
            )
            ->when($groups->isNotEmpty(), function (FormAbstract $form) use ($groups): void {
                $form->add(
                    'groups',
                    HtmlField::class,
                    HtmlFieldOption::make()
                        ->content(view('plugins/ecommerce::fitment-tables.groups', [
                            'groups' => $groups,
                            'selectedGroups' => $this->getModel() ? $this->getModel()->groups : collect(),
                        ])->render())
                );
            });
    }
}
