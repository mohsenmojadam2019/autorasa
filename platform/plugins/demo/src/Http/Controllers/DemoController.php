<?php

namespace Botble\Demo\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Demo\Http\Requests\DemoRequest;
use Botble\Demo\Models\Demo;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Demo\Tables\DemoTable;
use Botble\Demo\Forms\DemoForm;

class DemoController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/demo::demo.name')), route('demo.index'));
    }

    public function index(DemoTable $table)
    {
        $this->pageTitle(trans('plugins/demo::demo.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/demo::demo.create'));

        return DemoForm::create()->renderForm();
    }

    public function store(DemoRequest $request)
    {
        $form = DemoForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('demo.index'))
            ->setNextUrl(route('demo.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Demo $demo)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $demo->name]));

        return DemoForm::createFromModel($demo)->renderForm();
    }

    public function update(Demo $demo, DemoRequest $request)
    {
        DemoForm::createFromModel($demo)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('demo.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Demo $demo)
    {
        return DeleteResourceAction::make($demo);
    }
}
