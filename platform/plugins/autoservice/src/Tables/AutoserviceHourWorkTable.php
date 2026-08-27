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
use Botble\Table\Columns\TextColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class AutoserviceHourWorkTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(AutoserviceWorkingHour::class)
            ->addHeaderAction(CreateHeaderAction::make()->route('autoservicehourworks.autoservicehourworks.create'))
            ->addActions([
                EditAction::make()->route('autoservicehourworks.autoservicehourworks.edit'),
                DeleteAction::make()->route('autoservicehourworks.autoservicehourworks.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make('day')->title('روز'),
                NameColumn::make('start_time')->title('زمان شروع'),
                NameColumn::make('end_time')->title('زمان پایان'),

                // نمایش نام مرکز خدمات از رابطه
                NameColumn::make('serviceCenter.name')
                    ->title('نام مرکز خدمات')
                    ->alignLeft(),

                CreatedAtColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('autoservicehourworks.autoservicehourworks.destroy'),
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'day',
                    'start_time',
                    'end_time',
                    'service_center_id',
                    'created_at',
                ])->with('serviceCenter');
            });
    }
}
