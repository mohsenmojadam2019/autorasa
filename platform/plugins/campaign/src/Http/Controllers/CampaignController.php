<?php

namespace Botble\Campaign\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Campaign\Http\Requests\CampaignRequest;
use Botble\Campaign\Models\Campaign;
use Botble\Campaign\Models\ReserveAgency;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Campaign\Tables\CampaignTable;
use Botble\Campaign\Forms\CampaignForm;

class CampaignController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/campaign::campaign.name')), route('campaign.index'));
    }
    public static function arrayList(){
        return [
            [
                'id' => 1,
                'title' => 'خدمات لاستیک سعید',
                'address' => 'تهران، چیتگر شمالی، خیابان جهاد، نبش قدس پانزدهم، پلاک 32',
                'img' => asset('campaignImages/1.png'),
                'city' => 'مرکز تهران'
            ],
            [
                'id' => 2,
                'title' => 'الماس تایر',
                'address' => 'تهران- مجیدیه شمالی، خیابان لاهیجانی، کوچه برادران محمدی، پلاک 3',
                'img' => asset('campaignImages/2.png'),
                'city' => 'مرکز تهران'
            ],
        ];
    }
    public function index(CampaignTable $table)
    {
        $this->pageTitle(trans('plugins/campaign::campaign.name'));
        $data=ReserveAgency::all();
        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/campaign::campaign.create'));

        return CampaignForm::create()->renderForm();
    }

    public function store(CampaignRequest $request)
    {
        $form = CampaignForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('campaign.index'))
            ->setNextUrl(route('campaign.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Campaign $campaign)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $campaign->name]));

        return CampaignForm::createFromModel($campaign)->renderForm();
    }

    public function update(Campaign $campaign, CampaignRequest $request)
    {
        CampaignForm::createFromModel($campaign)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('campaign.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Campaign $campaign)
    {
        return DeleteResourceAction::make($campaign);
    }

    public function show(Campaign $campaign)
    {
        $form=CampaignForm::createFromModel($campaign)->renderForm();
        return view('plugins/campaign::show',compact(['campaign','form']))->render();
    }
}
