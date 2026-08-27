<?php

namespace Botble\Kyc\Tables;

use Botble\Kyc\Models\Kyc;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\LinkableColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class KycTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Kyc::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('kyc.create'))
            ->addActions([
                EditAction::make()->route('kyc.edit'),
                DeleteAction::make()->route('kyc.destroy'),
            ])
            ->addColumns([
                IdColumn::make(), // ID column
                LinkableColumn::make('model')
                    ->title('Model')
                    ->route('kyc.edit')
                , // Model column
                StatusColumn::make('status')->title('Status'), // Status column
                CreatedAtColumn::make(), // Created at timestamp
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('kyc.destroy'),
            ])
            ->addBulkChanges([
                StatusBulkChange::make()->title('Change Status')->choices([
                    'activate' => 'Activate',
                    'deactivate' => 'Deactivate',
                ]),
                CreatedAtBulkChange::make(),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'model',
                    'status',
                    'created_at',
                ]);
            });
    }
}
