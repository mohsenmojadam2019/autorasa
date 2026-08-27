<?php

namespace Botble\Kyc\Forms\Fronts;

use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\HiddenField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\CheckboxField;
use Botble\Base\Forms\FormAbstract;
use Botble\Kyc\Forms\Fields\UploadField;
use Botble\Kyc\Http\Requests\Fronts\PublicKycSubmissionRequest;
use Botble\Kyc\Http\Requests\KycFieldRequest;
use Botble\Kyc\Models\Kyc;
use Botble\Kyc\Models\KycField;
use Botble\Kyc\Models\KYCSubmission;

class PublicKycFieldForm extends FormAbstract
{
    public function setup(): void
    {
//        dd('sdf',$this);

        $field = KYCField::with('kyc')->find($this->getModel()['id']);

        $customer = auth('customer')->user();
        $submission = $this->getModel()['submission'];
        $this
            ->contentOnly()
//            ->setUrl(route('public.kyc.submit', session('tracked_start_checkout')))
            ->formClass('checkout-form payment-checkout-form kycform')
            ->setValidatorClass(PublicKycSubmissionRequest::class)
            ->add('kyc_entry_id', HiddenField::class, [
                'value' => $field['kyc_entry_id'],
            ])
            ->add('kyc_field_id', HiddenField::class, [
                'value' => $field['id'],
            ])
            ->add('modelable_type', HiddenField::class, [
                'value' => strtolower(class_basename($customer)),
            ])
            ->add('modelable_id', HiddenField::class, [
                'value' => $customer->id,
            ]);
        switch ($field['field_type']) {
            case 'file':
                $this->add('value',
                    UploadField::class,
                    [
                        'field' => $field,
                        'customer' => $customer,
                        'label' => ucfirst($field['field_name']),
                        'attr' => [  'class' => 'd-none kycuploader' . $field['id'] ,'required' => $field['is_required'],'value'=>$submission? $submission->value:''],
                    ]);
                break;
            case 'number':
                $this->add('value',
                    \Botble\Base\Forms\Fields\NumberField::class,
                    [
                        'field' => $field,
                        'label' => ucfirst($field['field_name']),
                        'attr' => ['required' => $field['is_required'],'value'=>$submission? $submission->value:''],
                    ]);
                break;
            default:
                $this->add('value',
                    TextField::class,
                    [
                        'field' => $field,
                        'label' => ucfirst($field['field_name']),
                        'attr' => ['placeholder' => $field['field_name'], 'required' => $field['is_required'],'value'=>$submission? $submission->value:''],
                    ]);
                break;
        }
    }
}
