<?php

namespace Botble\Autoservice\Tables;

use Botble\Autoservice\Models\Autoservice;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\Columns\TitleColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class AutoserviceTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Autoservice::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('autoservice.create'))
            ->addActions([
                EditAction::make()->route('autoservice.edit'),
                DeleteAction::make()->route('autoservice.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                TitleColumn::make()->route('autoservice.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('autoservice.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'title',
                    'created_at',
                ]);
            });
    }
}
