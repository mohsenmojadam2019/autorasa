<?php

namespace FriendsOfBotble\Sms\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use FriendsOfBotble\Sms\Http\Requests\SMSGatewayRequest;
use FriendsOfBotble\Sms\Models\SMSGateway;
use Botble\Base\Http\Controllers\BaseController;
use FriendsOfBotble\Sms\Tables\SMSGatewayTable;
use FriendsOfBotble\Sms\Forms\SMSGatewayForm;

class SMSGatewayController extends BaseController
{
    public function __construct()
    {
        $this
            ->breadcrumb()
            ->add(trans(trans('plugins/sms gateway::sms-gateway.name')), route('sms-gateway.index'));
    }

    public function index(SMSGatewayTable $table)
    {
        $this->pageTitle(trans('plugins/sms gateway::sms-gateway.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/sms gateway::sms-gateway.create'));

        return SMSGatewayForm::create()->renderForm();
    }

    public function store(SMSGatewayRequest $request)
    {
        $form = SMSGatewayForm::create()->setRequest($request);

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('sms-gateway.index'))
            ->setNextUrl(route('sms-gateway.edit', $form->getModel()->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(SMSGateway $sMSGateway)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $sMSGateway->name]));

        return SMSGatewayForm::createFromModel($sMSGateway)->renderForm();
    }

    public function update(SMSGateway $sMSGateway, SMSGatewayRequest $request)
    {
        SMSGatewayForm::createFromModel($sMSGateway)
            ->setRequest($request)
            ->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('sms-gateway.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(SMSGateway $sMSGateway)
    {
        return DeleteResourceAction::make($sMSGateway);
    }
}
