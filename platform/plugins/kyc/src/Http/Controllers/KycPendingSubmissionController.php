<?php

namespace Botble\Kyc\Http\Controllers;


use Botble\Base\Http\Controllers\BaseController;
use Botble\Kyc\Models\KYCSubmission;
use Botble\Kyc\Tables\KycPendingSubmissionTable;


class KycPendingSubmissionController extends BaseController
{
    public function __construct()
    {

        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/kyc::kyc.name')), route('submissions.index'));
    }

    public function index(KycPendingSubmissionTable $table)
    {
        $this->pageTitle(trans('plugins/kyc::kyc.userlist'));
        return $table->renderTable();
    }

//    public function edit($id)
//    {
//
//        $this->pageTitle(trans('plugins/kyc::kyc.usersubmissions'));
//        $submission = KYCSubmission::with('modelable')->find($id);
//        $modelable=$submission->modelable;
//        if (!$submission) {
//            abort(404, 'Submission not found');
//        }
//
//        $submissions = KYCSubmission::where('modelable_id', $submission->modelable_id)
//            ->with(['field'])
//            ->get();
//        return view('plugins/kyc::submisionlist', compact(['submissions','modelable']));
//
//    }
//
//
//    public function approve($id)
//    {
//        $item = KYCSubmission::find($id);
//
//        // Check if the item exists
//        if (!$item) {
//            return $this
//                ->httpResponse()
//                ->setPreviousUrl(route('kyc.index'))
//                ->setMessage(trans('plugins/kyc::kyc.item_not_found'));
//        }
//
//        // Update the status to 'approved'
//        $item->status = 'approved';
//        $item->save();
//
//        return $this
//            ->httpResponse()
//            ->setPreviousUrl(route('kyc.index'))
//            ->setMessage(trans('plugins/kyc::kyc.approved_message'));
//    }
//
//    public function reject($id)
//    {
//        $item = KYCSubmission::find($id);
//
//        // Check if the item exists
//        if (!$item) {
//            return $this
//                ->httpResponse()
//                ->setPreviousUrl(route('kyc.index'))
//                ->setMessage(trans('plugins/kyc::kyc.item_not_found'));
//        }
//
//        // Update the status to 'rejected'
//        $item->status = 'rejected';
//        $item->save();
//        return $this
//            ->httpResponse()
//            ->setPreviousUrl(route('kyc.index'))
//            ->setMessage(trans('plugins/kyc::kyc.rejected_message'));
//    }
}
