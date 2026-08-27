<?php

namespace Botble\Campaign\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Campaign\Http\Requests\SubmissionRequest;
use Botble\Campaign\Models\Operator;
use Botble\Campaign\Models\ReserveAgency;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Campaign\Tables\SubmissionTable;
use Botble\Campaign\Forms\SubmissionForm;

class SubmissionController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/campaign::submission.name'), route('submissions.index'));
    }
    public function index(SubmissionTable $table)
    {
        $this->pageTitle(trans('plugins/campaign::submission.name'));
        return $table->renderTable();
    }
    public function edit($id)
    {
        $operator=Operator::find($id)->load('reserveAgencies');
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $operator->name]));
        return view('plugins/campaign::submissions', compact(['operator']));
    }
}
