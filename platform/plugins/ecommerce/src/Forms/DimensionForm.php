<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Forms\FieldOptions\DescriptionFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\SortOrderFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\TreeCategoryField;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Facades\ProductCategoryHelper;
use Botble\Ecommerce\Forms\Fronts\Auth\FieldOptions\TextFieldOption;
use Botble\Ecommerce\Http\Requests\DimensionRequest;
use Botble\Ecommerce\Models\Dimension;

class DimensionForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Dimension::class)
            ->setValidatorClass(DimensionRequest::class)
            ->add('name', TextField::class, NameFieldOption::make())
            ->add('description', TextareaField::class, DescriptionFieldOption::make())

            ->add('status', SelectField::class, StatusFieldOption::make())
            ->add(
                'logo',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(trans('plugins/ecommerce::brands.logo'))
            )

            ->add(
                'categories[]',
                TreeCategoryField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/ecommerce::products.form.categories'))
                    ->choices(ProductCategoryHelper::getActiveTreeCategories())
                    ->selected($this->getModel()->getKey() ? $this->getModel()->categories->pluck('id')->all() : [])
                    ->addAttribute('card-body-class', 'p-0')
            )
            ->setBreakFieldPoint('status');
    }
}
