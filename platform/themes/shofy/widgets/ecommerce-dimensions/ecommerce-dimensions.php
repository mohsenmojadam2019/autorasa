<?php

use Botble\Base\Forms\FieldOptions\MultiChecklistFieldOption;
use Botble\Base\Forms\FieldOptions\RadioFieldOption;
use Botble\Base\Forms\Fields\MultiCheckListField;
use Botble\Base\Forms\Fields\RadioField;
use Botble\Ecommerce\Models\Dimension;
use Botble\Widget\AbstractWidget;
use Botble\Widget\Forms\WidgetForm;
use Illuminate\Support\Collection;

class EcommerceDimensions extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Ecommerce Dimensions'),
            'description' => __('Display dimensions list'),
            'dimensions_id' => null,
            'style' => 'slider',
        ]);
    }

    protected function data(): array|Collection
    {
        $dimensionIds = $this->getConfig('dimension_ids');

        if (empty($dimensionIds)) {
            return [
                'dimensions' => collect(),
            ];
        }

        $dimensions = Dimension::query()
            ->wherePublished()
            ->whereIn('id', $dimensionIds)
            ->with('slugable')
            ->get();

        return compact('dimensions');
    }

    protected function settingForm(): WidgetForm|string|null
    {
        return WidgetForm::createFromArray($this->getConfig())
            ->add(
                'dimension_ids',
                MultiCheckListField::class,
                MultiChecklistFieldOption::make()
                    ->label(__('Choose dimensions to display'))
                    ->choices(Dimension::query()->pluck('name', 'id')->all())
                    ->multiple()
            )
            ->add(
                'style',
                RadioField::class,
                RadioFieldOption::make()
                    ->label(__('Display type'))
                    ->choices([
                        'slider' => __('Slider'),
                        'grid' => __('Grid'),
                    ])
            );
    }

    protected function requiredPlugins(): array
    {
        return ['ecommerce'];
    }
}
