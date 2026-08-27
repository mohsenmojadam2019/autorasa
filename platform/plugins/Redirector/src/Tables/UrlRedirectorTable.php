<?php

namespace ArchiElite\UrlRedirector\Tables;

use ArchiElite\UrlRedirector\Models\UrlRedirector;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\LinkableColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class UrlRedirectorTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(UrlRedirector::class)
            ->addHeaderAction(CreateHeaderAction::make()->url(route('url-redirector.create')))
            ->addColumns([
                IdColumn::make(),
                LinkableColumn::make('original')
                    ->label(trans('plugins/url-redirector::url-redirector.original'))
                    ->externalLink()
                    ->limit(30)
                    ->copyable(),
                LinkableColumn::make('target')
                    ->label(trans('plugins/url-redirector::url-redirector.target'))
                    ->externalLink()
                    ->limit(30)
                    ->copyable(),
                Column::make('visits')
                    ->label(trans('plugins/url-redirector::url-redirector.visits')),


                FormattedColumn::make('is_410')
                    ->label('410')
                    ->getValueUsing(fn($record) => $record->is_410 ? 'بله' : 'خیر'),
                FormattedColumn::make('is_404')
                    ->label('404')
                    ->getValueUsing(fn($record) => $record->is_404 ? 'بله' : 'خیر'),
                FormattedColumn::make('is_500')
                    ->label('500')
                    ->getValueUsing(fn($record) => $record->is_500 ? 'بله' : 'خیر'),

                FormattedColumn::make('is_nofollow')
                    ->label('nofollow')
                    ->getValueUsing(fn($record) => $record->is_nofollow ? 'بله' : 'خیر'),

                FormattedColumn::make('is_noindex')
                    ->label('noindex')
                    ->getValueUsing(fn($record) => $record->is_noindex ? 'بله' : 'خیر'),

                FormattedColumn::make('is_canonical')
                    ->label('canonical')
                    ->getValueUsing(fn($record) => $record->is_canonical ? 'بله' : 'خیر'),


            ])
            ->addActions([
                EditAction::make()->route('url-redirector.edit'),
                DeleteAction::make()->route('url-redirector.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make())
            ->addBulkChanges([
                NameBulkChange::make()
                    ->name('original')
                    ->title(trans('plugins/url-redirector::url-redirector.original')),
                NameBulkChange::make()
                    ->name('target')
                    ->title(trans('plugins/url-redirector::url-redirector.target')),
            ])
            ->queryUsing(function (EloquentBuilder $query) {
                return $query
                    ->select([
                        'id',
                        'original',
                        'target',
                        'visits',
                        'is_410',
                        'is_500',
                        'is_404',
                        'is_nofollow',
                        'is_noindex',
                        'is_canonical',
                    ]);
            });
    }
}
