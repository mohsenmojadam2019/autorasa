<?php

namespace Botble\Demo\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Demo\Http\Requests\DemoRequest;
use Botble\Demo\Models\Demo;

class DemoForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Demo::class)
            ->setValidatorClass(DemoRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
