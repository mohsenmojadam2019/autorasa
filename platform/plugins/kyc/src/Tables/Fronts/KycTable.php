<?php

namespace Botble\Kyc\Tables\Fronts;

use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Botble\Kyc\Models\Kyc;
use Botble\Kyc\Models\KYCField;
use Botble\Kyc\Models\KYCSubmission;

class KycTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->queryUsing(function (Builder $query) {
                try {
                    $guard = $this->detectGuard();
                    DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

                    $query->with([
                        'fields' => function ($query) {
                            $query->select('kyc_fields.*')
                                ->with([
                                    'submissions' => function ($subQuery) {
                                        $subQuery->select('kyc_submissions.*');
                                    }
                                ]);
                        }
                    ])
                        ->select('kyc_entries.id') // Selecting only necessary columns
                        ->where('kyc_entries.model', $guard);
                } catch (Exception $e) {
                    Log::error('Error in KycTable query: ' . $e->getMessage());
                }
            })
            ->columns([
                'id' => [
                    'title' => 'ID',
                    'class' => 'text-center',
                    'sortable' => true,
                ],
                'submission_status' => [
                    'title' => 'Submission Status',
                    'class' => 'text-center',
                    'sortable' => false,
                ],
            ]);
    }
}
