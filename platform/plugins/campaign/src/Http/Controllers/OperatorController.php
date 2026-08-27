<?php

namespace Botble\Campaign\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Campaign\Http\Requests\OperatorRequest;
use Botble\Campaign\Models\Operator;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Campaign\Tables\OperatorTable;
use Botble\Campaign\Forms\OperatorForm;

class OperatorController extends BaseController
{
    public function __construct()
    {

         $this
             ->breadcrumb()
             ->add(trans('plugins/campaign::operator.name'), route('operators.index'));
    }
    public function index(OperatorTable $table)
    {
        // dd(request()->route()->getName());
        $this->pageTitle(trans('plugins/campaign::operator.name'));
        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/campaign::operator.create'));

        return OperatorForm::create()->renderForm();
    }

    public function store(OperatorRequest $request)
    {
        $form = OperatorForm::create()->setRequest($request);

        $form->save();
        return $this
            ->httpResponse()
            ->setPreviousUrl(route('operators.index'))
            ->setNextUrl(route('operators.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Operator $operator)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $operator->name]));

        return OperatorForm::createFromModel($operator)->renderForm();
    }

    public function update(Operator $operator, OperatorRequest $request)
    {
        OperatorForm::createFromModel($operator)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('operators.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Operator $operator)
    {
        return DeleteResourceAction::make($operator);
    }

    // public function show(Campaign $campaign)
    // {
    //     $form=CampaignForm::createFromModel($campaign)->renderForm();
    //     return view('plugins/campaign::show',compact(['campaign','form']))->render();
    // }
}
