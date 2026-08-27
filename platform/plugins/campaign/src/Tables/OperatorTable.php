<?php

namespace Botble\Campaign\Tables;

use Botble\Campaign\Models\Operator;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\Actions\ViewAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class OperatorTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Operator::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('operators.create'))
            ->addActions([
                EditAction::make()->route('operators.edit'),
                DeleteAction::make()->route('operators.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('operators.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('operators.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'name',
                    'status',
                ])
                ;
            })
;
    }
}
