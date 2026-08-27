<?php

namespace Botble\Campaign\Tables;

use Botble\Campaign\Models\Operator;
use Botble\Campaign\Models\ReserveAgency;
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

class SubmissionTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Operator::class)
            ->addActions([
                ViewAction::make()->route('campaignsubmissions.edit'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('campaignsubmissions.edit'),
            ])
;
    }
}
