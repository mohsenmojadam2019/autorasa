<?php

namespace Botble\Autoservice\Forms;

use Botble\Autoservice\Http\Requests\AutoserviceRequest;
use Botble\Autoservice\Models\Autoservice;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;

class AutoserviceForm extends FormAbstract
{
    public function setup(): void
    {
        $model = $this->getModel();

        $this
            ->model(Autoservice::class)
            ->setValidatorClass(AutoserviceRequest::class)
            ->add('title', TextField::class, ['label' => 'عنوان مرکز'])
            ->add('code', TextField::class, ['label' => 'کد مرکز'])
            ->add('province_id', SelectField::class, [
                'label' => 'استان',
                'choices' => \App\Models\Province::pluck('name', 'id')->toArray(),
                'attr' => ['id' => 'province-select'],
            ])
            ->add('city_id', SelectField::class, [
                'label' => 'شهر',
                'choices' => $this->getCitiesChoices(),
                'attr' => ['id' => 'city-select'],
            ])
            ->add('area', TextField::class, ['label' => 'منطقه'])
            ->add('address', TextField::class, ['label' => 'آدرس'])
            ->add('pic', MediaImageField::class, MediaImageFieldOption::make())
            ->add('lat', TextField::class, ['label' => 'عرض جغرافیایی'])
            ->add('long', TextField::class, ['label' => 'طول جغرافیایی'])
            ->setBreakFieldPoint('pic');

        $this->addMetaBoxes([
            'dynamic_city_script' => [
                'title' => null,
                'content' => view('plugins/autoservice::dynamic-city', ['model' => $model])->render()
                    . view('plugins/autoservice::dynamic-city-fixes')->render(),
            ],
        ]);
    }

    protected function getCitiesChoices(): array
    {
        $provinceId = $this->getModel()->province_id;

        if (! $provinceId) {
            return [];
        }

        return \App\Models\Cities::where('province_id', $provinceId)->pluck('name', 'id')->toArray();
    }
}
