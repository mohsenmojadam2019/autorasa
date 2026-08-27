<?php

namespace Botble\Campaign\Forms;

use Botble\Base\Forms\FieldOptions\ImageFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\FileField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Campaign\Http\Requests\OperatorRequest;
use Botble\Campaign\Models\Operator;
use Botble\Kyc\Forms\Fields\UploadField;

class OperatorForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Operator::class)
            ->setValidatorClass(OperatorRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required()->label(trans('plugins/campaign::operator.name')))
            ->add('city', TextField::class, NameFieldOption::make()->required()->label(trans('plugins/campaign::operator.city')))  // Fixed duplicate label
            ->add('address', TextField::class, NameFieldOption::make()->required()->label(trans('plugins/campaign::operator.address')))  // Fixed duplicate label
            ->add('img', MediaImageField::class, MediaImageFieldOption::make()->required()->label(trans('plugins/campaign::operator.image')))  // **Fixed missing parenthesis**
            ->add('status', SelectField::class, StatusFieldOption::make()->label(trans('plugins/campaign::operator.status')))
            ->setBreakFieldPoint('status');
    }
}
