<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Supports\Breadcrumb;
use Botble\Ecommerce\Forms\FitmentGroupForm;
use Botble\Ecommerce\Http\Requests\FitmentGroupRequest;
use Botble\Ecommerce\Models\FitmentAttribute;
use Botble\Ecommerce\Models\FitmentGroup;
use Botble\Ecommerce\Tables\FitmentGroupTable;
use Botble\Table\Abstracts\TableAbstract;

class FitmentGroupController extends BaseController
{
    public function index()
    {
        $this->pageTitle(trans('plugins/ecommerce::product-fitment.fitment_groups.title'));
//dd($this->getTable());
        return app($this->getTable())->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/ecommerce::product-fitment.fitment_groups.create.title'));

        return $this->getForm()::create()->renderForm();
    }

    public function store(FitmentGroupRequest $request)
    {
        $form = $this->getForm()::create()->setRequest($request)->onlyValidatedData();

        $form->saving(function (FitmentGroupForm $form): void {
            $model = $form->getModel();
            if (! empty($this->getAdditionalDataForSaving())) {
                $model->fill($this->getAdditionalDataForSaving());
            }
            $form->save();
        });

        return $this
            ->httpResponse()
            ->withCreatedSuccessMessage()
            ->setPreviousRoute($this->getIndexRouteName())
            ->setNextRoute($this->getEditRouteName(), $form->getModel());
    }

    public function edit(string $group)
    {
        $group = $this->getFitmentGroup($group);

        $this->pageTitle(trans('plugins/ecommerce::product-fitment.fitment_groups.edit.title', [
            'name' => $group->name,
        ]));

        return $this->getForm()::createFromModel($group)->renderForm();
    }

    public function update(FitmentGroupRequest $request, string $group)
    {
        $model = FitmentGroup::find($group);

        if (! $model) {
            abort(404, 'Fitment group not found.');
        }

        $model->update($request->input());
//dd($model);

//        $group = $this->getFitmentGroup($group);
//
//        $form = $this->getForm()::createFromModel($group)->setRequest($request)->onlyValidatedData();
//        $form->saving(function (FitmentGroupForm $form): void {
//            $model = $form->getModel();
//            if (! empty($this->getAdditionalDataForSaving())) {
//                $model->fill($this->getAdditionalDataForSaving());
//            }
//            $form->save();
//        });

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage()
            ->setPreviousRoute($this->getIndexRouteName())
            ->setNextRoute($this->getEditRouteName(), $model);
    }

    public function destroy(string $group)
    {
        $group = $this->getFitmentGroup($group);

        return DeleteResourceAction::make($group);
    }

    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/ecommerce::product-fitment.fitment_groups.title'), route($this->getIndexRouteName()));
    }

    /**
     * @return class-string<TableAbstract>
     */
    protected function getTable(): string
    {
        return FitmentGroupTable::class;
    }

    /**
     * @return class-string<FormAbstract>
     */
    protected function getForm(): string
    {
        return FitmentGroupForm::class;
    }

    protected function getAdditionalDataForSaving(): array
    {
        return [];
    }

    protected function getIndexRouteName(): string
    {
        return 'ecommerce.fitment-groups.index';
    }

    protected function getEditRouteName(): string
    {
        return 'ecommerce.fitment-groups.edit';
    }

    protected function getFitmentGroup(string $group)
    {
        return FitmentGroup::query()->findOrFail($group);
    }
}
