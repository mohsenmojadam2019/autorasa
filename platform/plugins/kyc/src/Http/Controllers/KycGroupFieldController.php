<?php

namespace Botble\Kyc\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Kyc\Forms\KycGroupFieldForm;
use Botble\Kyc\Http\Requests\KycGroupFieldRequest;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Kyc\Models\KYCGroupField;
use Botble\Kyc\Tables\KycGroupFieldTable;

class KycGroupFieldController extends BaseController
{
    public function index(KycGroupFieldTable $dataTable)
    {
        return $dataTable->renderTable();
    }

    public function create()
    {
        $form = KycGroupFieldForm::create()
            ->setUseInlineJs(true)
            ->renderForm();
        return $this
            ->httpResponse()
            ->setData([
                'title' => trans('plugins/kyc::kyc.create_group_field'),
                'content' => $form,
            ]);
    }

    public function store(KycGroupFieldRequest $request)
    {
        KycGroupFieldForm::create()->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->withCreatedSuccessMessage();
    }

    public function edit(int|string $id)
    {
        $simpleSliderItem = KYCGroupField::query()->findOrFail($id);

        $form = KycGroupFieldForm::createFromModel($simpleSliderItem)
            ->setUseInlineJs(true)
            ->renderForm();

        return $this
            ->httpResponse()
            ->setData([
                'title' => trans('plugins/kyc::kyc.edit_group_field', ['id' => $simpleSliderItem->group_field_name]),
                'content' => $form,
            ]);
    }
    public function update(int|string $id, KycGroupFieldRequest $request)
    {
        $kycField = KYCGroupField::query()->findOrFail($id);

        KycGroupFieldForm::createFromModel($kycField)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage();
    }

    public function destroy(int|string $id)
    {
        $simpleSliderItem = KYCGroupField::query()->findOrFail($id);

        return DeleteResourceAction::make($simpleSliderItem);
    }
}
