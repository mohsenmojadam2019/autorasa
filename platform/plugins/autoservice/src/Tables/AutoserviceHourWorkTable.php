<?php

namespace Botble\Autoservice\Tables;

use Botble\Autoservice\Models\AutoserviceWorkingHour;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class AutoserviceHourWorkTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(AutoserviceWorkingHour::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('autoservicehourworks.create'))
            ->addActions([
                EditAction::make()->route('autoservicehourworks.edit'),
                DeleteAction::make()->route('autoservicehourworks.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make('day')->title('روز'),
                NameColumn::make('serviceCenter.title')
                    ->title('نام مرکز خدمات')
                    ->alignLeft(),
                CreatedAtColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('autoservicehourworks.destroy'),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'day',
                    'service_center_id',
                    'created_at',
                ])->with('serviceCenter');
            });
    }
}
