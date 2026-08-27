<?php

namespace FriendsOfBotble\Sms\Forms;

use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextField;

class MelipayamakGatewayForm extends SmsGatewayForm
{
    protected array $sensitiveFields = [
        'username',
        'password',
    ];

    public function setup(): void
    {
        parent::setup();

        $this
            ->add(
                'username',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/sms::melipayamak.username'))
                    ->required()
            )
            ->add(
                'password',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/sms::melipayamak.password'))
                    ->required()
            )
            ->add(
                'from',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/sms::melipayamak.from'))
                    ->helperText(trans('plugins/sms::melipayamak.from_help'))
                    ->required()
            );
    }
}
