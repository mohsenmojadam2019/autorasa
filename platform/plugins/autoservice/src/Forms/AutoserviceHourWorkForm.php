<?php

namespace Botble\Autoservice\Forms;

use Botble\Autoservice\Models\Autoservice;
use Botble\Autoservice\Models\AutoserviceWorkingHour;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Autoservice\Http\Requests\AutoserviceHourWorkRequest;

class AutoserviceHourWorkForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(AutoserviceWorkingHour::class)
            ->setValidatorClass(AutoserviceHourWorkRequest::class)
            ->add('service_center_id', SelectField::class, [
                'label' => trans('plugins/autoservice::autoservice.service_center'),
                'choices' => Autoservice::pluck('title', 'id')->all(),
                'required' => true,
            ])
            ->add('day', TextField::class, [
                'label' => trans('plugins/autoservice::autoservice.day'),
                'required' => true,
            ])
            ->add('start_time', TextField::class, [
                'label' => trans('plugins/autoservice::autoservice.start_time'),
                'required' => true,
            ])
            ->add('end_time', TextField::class, [
                'label' => trans('plugins/autoservice::autoservice.end_time'),
                'required' => true,
            ])
            ->setBreakFieldPoint('end_time');
    }
}
