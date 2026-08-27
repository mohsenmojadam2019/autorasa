<?php

namespace Botble\Kyc\Http\Controllers;

use Botble\Base\Forms\MetaBox;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Kyc\Forms\KycFieldForm;
use Botble\Kyc\Http\Requests\KycFieldRequest;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Kyc\Models\KYCField;
use Botble\Kyc\Tables\KycFieldTable;

class KycFieldController extends BaseController
{
    public function index(KycFieldTable $dataTable)
    {
        return $dataTable->renderTable();
    }

    public function create()
    {
        $form = KycFieldForm::create()
            ->setUseInlineJs(true)
            ->renderForm();

        return $this
            ->httpResponse()
            ->setData([
                'title' => trans('plugins/kyc::kyc.create'),
                'content' => $form , // Append MetaBoxes to the form
            ]);
    }

    public function store(KycFieldRequest $request)
    {
        KycFieldForm::create()->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->withCreatedSuccessMessage();
    }

    public function edit(int|string $id)
    {
//        dd($id);
        $simpleSliderItem = KYCField::query()->findOrFail($id);
        $form = KycFieldForm::createFromModel($simpleSliderItem)
            ->setUseInlineJs(true)
            ->renderForm();

        return $this
            ->httpResponse()
            ->setData([
                'title' => trans('plugins/kyc::kyc.edit', ['id' => $simpleSliderItem->getKey()]),
                'content' => $form,
            ]);
    }
    public function update(int|string $id, KycFieldRequest $request)
    {
        $kycField = KYCField::query()->findOrFail($id);

        KycFieldForm::createFromModel($kycField)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage();
    }

    public function destroy(int|string $id)
    {
        $simpleSliderItem = KYCField::query()->findOrFail($id);

        return DeleteResourceAction::make($simpleSliderItem);
    }
}
