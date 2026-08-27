<?php

namespace Botble\Autoservice\Http\Controllers;

use Botble\Autoservice\Models\AutoserviceWorkingHour;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Autoservice\Forms\AutoserviceHourWorkForm;
use Botble\Autoservice\Tables\AutoserviceHourWorkTable;

class AutoserviceHourWorkController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/autoservice::autoservice.name')), route('autoservice.index'));
    }

    public function index(AutoserviceHourWorkTable $table)
    {
        $this->pageTitle(trans('plugins/autoservice::autoservice.hourwork'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/autoservice::autoservice.create'));

        return AutoserviceHourWorkForm::create()->renderForm();
    }

    public function store(AutoserviceHourWorkRequest $request)
    {
        $form = AutoserviceHourWorkForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('autoservicehourworks.index'))
            ->setNextUrl(route('autoservicehourworks.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(AutoserviceWorkingHour $autoservice)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $autoservice->day]));

        return AutoserviceForm::createFromModel($autoservice)->renderForm();
    }

    public function update(AutoserviceWorkingHour $autoservice, AutoserviceHourWorkRequest $request)
    {
        AutoserviceHourWorkForm::createFromModel($autoservice)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('autoservicehourworks.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(AutoserviceWorkingHour $autoservice)
    {
        return DeleteResourceAction::make($autoservice);
    }
}
