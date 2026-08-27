<?php

namespace Botble\Kyc\Http\Controllers;

use Botble\Base\Facades\Assets;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Kyc\Http\Requests\KycFieldRequest;
use Botble\Kyc\Http\Requests\KycRequest;
use Botble\Kyc\Models\Kyc;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Kyc\Models\KYCField;
use Botble\Kyc\Tables\KycTable;
use Botble\Kyc\Forms\KycForm;
use Illuminate\Http\Request;
use Botble\Base\Http\Responses\BaseHttpResponse;


class KycController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/kyc::kyc.name')), route('kyc.index'));
    }

    public function index(KycTable $table)
    {
        $this->pageTitle(trans('plugins/kyc::kyc.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/kyc::kyc.create'));
        return KycForm::create()->renderForm();
    }

    public function store(KycRequest $request)
    {
        $form = KycForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('kyc.index'))
            ->setNextUrl(route('kyc.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Kyc $kyc)
    {
        Assets::addScripts('sortable')
            ->addScriptsDirectly('vendor/core/plugins/kyc/js/kyc-admin.js');

        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $kyc->model]));
//dd(KycForm::createFromModel($kyc)->renderForm());
        return KycForm::createFromModel($kyc)->renderForm();
    }

    public function update(Kyc $kyc, KycRequest $request)
    {
        KycForm::createFromModel($kyc)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('kyc.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Kyc $kyc)
    {
        return DeleteResourceAction::make($kyc);
    }

    /**
     * Display the form for creating or editing KYC fields.
     *
     * @param int|string $kycId
     * @param int|string|null $fieldId
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getVersionForm(Request $request, BaseHttpResponse $response, int|string $kycId = null, ?int $fieldId = null): BaseHttpResponse
    {
        // Fetch the existing KYC entry using $kycId
        $kyc = $kycId ? Kyc::findOrFail($kycId) : null;

        // If $fieldId is provided, fetch the specific KYC field for editing; otherwise, prepare for creation
        $kycField = $fieldId ? KYCField::where('kyc_entry_id', $kycId)->findOrFail($fieldId) : null;

        // Generate the form HTML using the Blade template
        $html = view(
            'plugins/kyc::partials.fields-form', // Update path as per your Blade file
            compact('kyc', 'kycField')
        )->render();

        // Return the generated HTML to the response
        return $response->setData($html);
    }

    public function postAddVersion(KycFieldRequest $request, int|string|null $id, BaseHttpResponse $response)
    {
        $kyc = Kyc::find($id);
        if (!$kyc) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/ecommerce::products.form.barcode_existed'));
        }
        $addedAttributes = KYCField::create([
            'kyc_entry_id' => $kyc->id,
            'field_name' => $request->field_name,
            'field_type' => $request->field_type,
            'is_required' => (bool)$request->is_required,
            'status' => $request->status,
        ]);

        return $response->setMessage(trans('plugins/ecommerce::products.form.added_variation_success'));

    }

}
