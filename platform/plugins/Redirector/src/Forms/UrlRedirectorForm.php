<?php

namespace ArchiElite\UrlRedirector\Forms;

use Botble\Base\Forms\FormAbstract;
use ArchiElite\UrlRedirector\Http\Requests\StoreUrlRedirectorRequest;
use ArchiElite\UrlRedirector\Models\UrlRedirector;

class UrlRedirectorForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new UrlRedirector())
            ->setValidatorClass(StoreUrlRedirectorRequest::class)
            ->withCustomFields()
            ->add('original', 'text', [
                'label' => trans('plugins/url-redirector::url-redirector.original'),
                'required' => true,
                'attr' => ['placeholder' => 'https://www.example-original.com'],
            ])
            ->add('target', 'text', [
                'label' => trans('plugins/url-redirector::url-redirector.target'),
//                'required' => true,
                'attr' => ['placeholder' => 'https://www.example-target.com'],
            ])
            ->add('is_410', 'onOff', [
                'label' => 'نمایش نده',
                'default_value' => false,
            ])
            ->add('is_nofollow', 'onOff', [
                'label' => 'باشد؟ nofollow',
                'default_value' => false,
            ])
            ->add('is_noindex', 'onOff', [
                'label' => 'باشد؟ noindex',
                'default_value' => false,
            ])
            ->add('is_canonical', 'onOff', [
                'label' => 'باشد؟ canonical',
                'default_value' => false,
            ])
            ->add('404', 'onOff', [
                'label' => ' 404',
                'default_value' => false,
            ]) ->add('500', 'onOff', [
                'label' => ' 500',
                'default_value' => false,
            ])
        ;
    }
}
