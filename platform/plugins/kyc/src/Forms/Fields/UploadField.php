<?php

namespace Botble\Kyc\Forms\Fields;

use Botble\Base\Forms\FormField;

class UploadField extends FormField
{

    protected function getTemplate(): string
    {
        return 'plugins/kyc::components.image-input';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true): string
    {
        $submission = $this->getOption('submission');
        $field = $this->getOption('field');
        $customer = $this->getOption('customer');

        return view('plugins/kyc::components.image-input', [
            'submission' => $submission,
            'field' => $field,
            'customer' => $customer,
            'options' => $this->getOptions(),
        ])->render();
    }
}
