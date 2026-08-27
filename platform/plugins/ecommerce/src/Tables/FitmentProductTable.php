<?php

namespace Botble\Ecommerce\Tables;

use Botble\Ecommerce\Models\FitmentProduct;
use Botble\Ecommerce\Models\FitmentTable;
use Botble\Ecommerce\Models\Product;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\Actions\ViewAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class FitmentProductTable extends TableAbstract
{

    public function setup(): void
    {
        $this
            ->model(Product::class);
        $this->isHasTranslation = false;

//            ->addHeaderAction(CreateHeaderAction::make()->route($this->getCreateRouteName()))
            $this->addColumns([
                IdColumn::make(),
                NameColumn::make()->route($this->getEditRouteName()),
//                FormattedColumn::make('description')
//                    ->label(trans('core/base::forms.description'))
//                    ->withEmptyState()
//                    ->limit(50),
                CreatedAtColumn::make(),
            ])
            ->addActions([
                ViewAction::make()
                    ->route($this->getEditRouteName()),
//                EditAction::make()->route($this->getEditRouteName()),
//                DeleteAction::make()->route($this->getDeleteRouteName()),
            ]);
    }

    protected function getCreateRouteName(): string
    {
        return 'ecommerce.fitment-products.create';
    }

    protected function getEditRouteName(): string
    {
        return 'ecommerce.fitment-products.edit';
    }

    protected function getDeleteRouteName(): string
    {
        return 'ecommerce.fitment-products.destroy';
    }
}
