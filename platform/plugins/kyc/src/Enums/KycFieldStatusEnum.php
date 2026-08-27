<?php

namespace Botble\Kyc\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

/**
 * @method static KycStatusEnum ACTIVATE()
 * @method static KycStatusEnum DEACTIVATE()
 */
class KycFieldStatusEnum extends Enum
{
    public const ACTIVATE = 'activate';
    public const DEACTIVATE = 'deactivate';

    public static $langPath = 'plugins/kyc::kyc.statuses';

    public function toHtml(): string|HtmlString
    {
        return match ($this->value) {
            self::ACTIVATE => Html::tag('span', self::ACTIVATE()->label(), ['class' => 'badge bg-warning text-warning-fg']),
            self::DEACTIVATE => Html::tag('span', self::DEACTIVATE()->label(), ['class' => 'badge bg-success text-success-fg']),
            default => parent::toHtml(),
        };
    }
}
