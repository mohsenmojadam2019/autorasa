<?php

namespace Botble\Kyc\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Kyc\Models\KYCField;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Illuminate\Database\Eloquent\Builder;

class KycFieldTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(KYCField::class)
            ->setView('plugins/kyc::items')
            ->setDom($this->simpleDom())
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('field_name')
                    ->title(trans('plugins/kyc::kyc.field_name'))
                    ->alignStart()
                    ->getValueUsing(function (FormattedColumn $column) {
                        $item = $column->getItem();

                        $name = BaseHelper::clean($item->field_name);

                        //                        if (! $this->hasPermission('simple-slider-item.edit')) {
//                            return $name;
//                        }

                        return $name ? Html::link(route('kyc-fields.edit', $item->getKey()), $name, [
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#kyc-field-modal',
                        ]) : '&mdash;';
                    }),
                Column::make('field_type')
                    ->title(trans('plugins/kyc::kyc.field_type'))
                    ->className('text-start order-column'),
                Column::make('status')
                    ->title(trans('plugins/kyc::kyc.status'))
                    ->className('text-start order-column'),
                Column::make('is_required')
                    ->title(trans('plugins/kyc::kyc.is_required'))
                    ->className('text-start order-column'),
                CreatedAtColumn::make(),
            ])
            ->addActions([
                EditAction::make()
                    ->route('kyc-fields.edit')
                    ->attributes([
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#kyc-field-modal',
                    ])
                    /*->permission('simple-slider-item.edit')*/,
                DeleteAction::make()
                    ->route('kyc-fields.destroy')
                    /*->permission('simple-slider-item.destroy')*/,
            ])
            ->queryUsing(function (Builder $query) {
                return $query
                    ->select([
                        'id',
                        'field_name',
                        'field_type',
                        'status',
                        'is_required',
                        'created_at',
                    ])
                    ->where('kyc_entry_id', request()->route()->parameter('id'));
            });
    }
}
