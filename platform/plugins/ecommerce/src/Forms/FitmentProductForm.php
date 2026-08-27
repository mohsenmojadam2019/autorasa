<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Http\Requests\FitmentProductRequest;
use Botble\Ecommerce\Models\FitmentProduct;

class FitmentProductForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(FitmentProduct::class)
            ->setValidatorClass(FitmentProductRequest::class)
            ;
    }
}
