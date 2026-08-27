<?php

namespace Botble\Campaign\Tables;

use Botble\Campaign\Models\Campaign;
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

class CampaignTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Campaign::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('campaign.create'))
            ->addActions([
                EditAction::make()->route('campaign.edit'),
                DeleteAction::make()->route('campaign.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('campaign.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('campaign.destroy'),
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
