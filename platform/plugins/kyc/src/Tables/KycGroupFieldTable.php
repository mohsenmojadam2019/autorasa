<?php

namespace Botble\Kyc\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Kyc\Models\KYCField;
use Botble\Kyc\Models\KYCGroupField;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class KycGroupFieldTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(KYCGroupField::class)
            ->setView('plugins/kyc::items')
            ->setDom($this->simpleDom())
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('group_field_name')
                    ->title(trans('plugins/kyc::kyc.group_field_name'))
                    ->alignStart()
                    ->getValueUsing(function (FormattedColumn $column) {
                        $item = $column->getItem();

                        $name = BaseHelper::clean($item->group_field_name);
                        return $name ? Html::link(route('kyc-group-fields.edit', $item->getKey()), $name, [
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#kyc-group-field-modal',
                        ]) : '&mdash;';
                    }),
                Column::make('order')
                    ->title(trans('plugins/kyc::kyc.field_order'))
                    ->className('text-start order-column'),
                Column::make('status')
                    ->title(trans('plugins/kyc::kyc.status'))
                    ->className('text-start status-column'),
                CreatedAtColumn::make(),
            ])
            ->addActions([
                EditAction::make()
                    ->route('kyc-group-fields.edit')
                    ->attributes([
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#kyc-group-field-modal',
                    ])
                    /*->permission('simple-slider-item.edit')*/,
                DeleteAction::make()
                    ->route('kyc-group-fields.destroy')
                    /*->permission('simple-slider-item.destroy')*/,
            ])
            ->queryUsing(function (Builder $query) {
                $query = $query->select([
                    'id',
                    'group_field_name',
                    'status',
                    'order',
                    'created_at',
                ]);

                // Execute the query and get results
                $results = $query->get();

                // Log the SQL query
                Log::info('SQL Query:', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

                // Log the retrieved results
                Log::info('Query Results:', ['results' => $results->toArray()]);

                return $query;
            });
    }
}
