<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Supports\Breadcrumb;
use Botble\Ecommerce\Forms\FitmentTableForm;
use Botble\Ecommerce\Http\Requests\FitmentTableRequest;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\FitmentTable;
use Botble\Ecommerce\Tables\FitmentTableTable;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FitmentTableController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET') && $request->ajax()) {
            $fitmentTable = FitmentTable::query()
                ->with(['groups.fitmentAttributes.options'])
                ->findOrFail($request->query('table'));

// Manually call getFitmentAttributeDetailsForProduct for each group

            $product = null;

            if ($request->query('product')) {
                $product = Product::query()
                    ->with('fitmentAttributes')
                    ->findOrFail($request->query('product'));
            }
            foreach ($fitmentTable->groups as $group) {
                $group->fitmentDetails = $group->getFitmentAttributeDetailsForProduct($product->id);
                $group->fitmentName = $group->getFitmentAttributeNameForProduct($product->id);
            }
//dd($fitmentTable[0]);
            return $this
                ->httpResponse()
                ->setData(view('plugins/ecommerce::products.partials.fitment-table.table', compact('fitmentTable', 'product'))->render());
        }

        $this->pageTitle(trans('plugins/ecommerce::product-fitment.fitment_tables.title'));

        return app($this->getTable())->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/ecommerce::product-fitment.fitment_tables.create.title'));

        return $this->getForm()::create()->renderForm();
    }

    public function store(FitmentTableRequest $request)
    {
//        dd($request);
        $form = $this->getForm()::create()->setRequest($request)->onlyValidatedData();

        $form->saving(function (FitmentTableForm $form): void {
            $model = $form->getModel();
            if (! empty($this->getAdditionalDataForSaving())) {
                $model->fill($this->getAdditionalDataForSaving());
            }

            $form->save();

            /** @var FitmentTable $model */
            $model = $form->getModel();

            $model->groups()->sync(Arr::get($form->getRequest(), 'groups', []));
        });

        return $this
            ->httpResponse()
            ->withCreatedSuccessMessage()
            ->setPreviousRoute($this->getIndexRouteName())
            ->setNextRoute($this->getEditRouteName(), $form->getModel());
    }

    public function edit(string $table)
    {

        $table = $this->getFitmentTable($table);

        $this->pageTitle(trans('plugins/ecommerce::product-fitment.fitment_tables.edit.title', [
            'name' => $table->name,
        ]));

        return $this->getForm()::createFromModel($table)->renderForm();
    }

    public function update(FitmentTableRequest $request, string $table)
    {
        $table = $this->getFitmentTable($table);

        $form = $this->getForm()::createFromModel($table)->setRequest($request)->onlyValidatedData();
        $form->saving(function (FitmentTableForm $form): void {
            $model = $form->getModel();
            if (! empty($this->getAdditionalDataForSaving())) {
                $model->fill($this->getAdditionalDataForSaving());
            }
            $form->save();
            /** @var FitmentTable $model */
            $model = $form->getModel();

            $orders = Arr::get($form->getRequest(), 'group_orders', []);
            $data = [];

            foreach (Arr::get($form->getRequest(), 'groups', []) as $index => $groupId) {
                $data[$groupId] = ['order' => $orders[$groupId] ?? $index];
            }

            $model->groups()->sync($data);
        });
        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage()
            ->setPreviousRoute($this->getIndexRouteName())
            ->setNextRoute($this->getEditRouteName(), $form->getModel());
    }

    public function destroy(string $table)
    {
        $table = $this->getFitmentTable($table);

        return DeleteResourceAction::make($table);
    }

    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/ecommerce::product-fitment.fitment_tables.title'), route($this->getIndexRouteName()));
    }

    /**
     * @return class-string<TableAbstract>
     */
    protected function getTable(): string
    {
        return FitmentTableTable::class;
    }

    /**
     * @return class-string<FormAbstract>
     */
    protected function getForm(): string
    {
        return FitmentTableForm::class;
    }

    protected function getAdditionalDataForSaving(): array
    {
        return [];
    }

    protected function getIndexRouteName(): string
    {
        return 'ecommerce.fitment-tables.index';
    }

    protected function getEditRouteName(): string
    {
        return 'ecommerce.fitment-tables.edit';
    }

    protected function getFitmentTable(string $table)
    {
        return FitmentTable::query()->findOrFail($table);
    }
}
