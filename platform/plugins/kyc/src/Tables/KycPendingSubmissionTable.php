<?php

namespace Botble\Kyc\Tables;

use Botble\Kyc\Models\KYCSubmission;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\Actions\ViewAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class KycPendingSubmissionTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(KYCSubmission::class)
            ->addActions([
                ViewAction::make()
                    ->route('submissions.edit'),
            ])
            ->addColumns([
                IdColumn::make()
                    ->headerAttributes(['class' => 'text-center'])
                    ->rowAttributes(['class' => 'text-center']),

                // Customer Name column with translation
                Column::make('customer_name')
                    ->title(trans('plugins/kyc::kyc.customer_name'))
                    ->value(fn(KYCSubmission $submission) => $submission->customer_name ?? trans('N/A'))
                    ->headerAttributes(['class' => 'text-center'])
                    ->rowAttributes(['class' => 'text-center']),

                // Modelable Type column with translation
                Column::make('modelable_type')
                    ->title(trans('plugins/kyc::kyc.modelable_type'))
                    ->value(fn(KYCSubmission $submission) => class_basename($submission->modelable_type))
                    ->headerAttributes(['class' => 'text-center'])
                    ->rowAttributes(['class' => 'text-center']),

                // Phone Number column with translation
                Column::make('phone_number')
                    ->title(trans('plugins/kyc::kyc.phone_number'))
                    ->value(fn(KYCSubmission $submission) => $submission->phone_number ?? trans('N/A'))
                    ->headerAttributes(['class' => 'text-center'])
                    ->rowAttributes(['class' => 'text-center']),

                // Status column with safe relationship handling
//                StatusColumn::make()
//                    ->value(fn(KYCSubmission $submission) =>
//                        optional($submission->modelable)->status ?? trans('Inactive')
//                    )
//                    ->headerAttributes(['class' => 'text-center'])
//                    ->rowAttributes(['class' => 'text-center']),
            ])
            ->queryUsing(function (Builder $query) {
                try {
                    DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

                    $query->with(['modelable'])
                        ->select([
                            'kyc_submissions.id',
                            'kyc_submissions.modelable_id',
                            'kyc_submissions.modelable_type',
                            DB::raw('(SELECT name FROM ec_customers WHERE ec_customers.id = kyc_submissions.modelable_id) as customer_name'),
                            DB::raw('(SELECT phone FROM ec_customers WHERE ec_customers.id = kyc_submissions.modelable_id) as phone_number'),
                        ])
                        ->where('status','<>','approved')
                        ->groupBy('kyc_submissions.modelable_id');


                } catch (Exception $e) {
                    Log::error('Error in KycSubmissionTable query: ' . $e->getMessage());
                }
            });
    }
}
