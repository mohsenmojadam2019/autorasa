<?php

namespace Botble\Kyc\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

/**
 * @method static KycStatusEnum KYC_COMPLETED()
 * @method static KycStatusEnum KYC_PENDING()
 * @method static KycStatusEnum KYC_IN_PROGRESS()
 */
class KycEnum extends Enum
{
    public const KYC_COMPLETED = 'completed';
    public const KYC_PENDING = 'pending';
    public const KYC_IN_PROGRESS = 'in_progress';

    public static $langPath = 'plugins/kyc::kyc.statuses';

    public function toHtml(): string|HtmlString
    {
        return match ($this->value) {
            self::KYC_COMPLETED => Html::tag('span', self::ACTIVATE()->label(), ['class' => 'badge bg-success text-success-fg']),
            self::KYC_PENDING => Html::tag('span', self::DEACTIVATE()->label(), ['class' => 'badge bg-warning text-warning-fg']),
            self::KYC_IN_PROGRESS => Html::tag('span', self::DEACTIVATE()->label(), ['class' => 'badge bg-info text-info-fg']),
            default => parent::toHtml(),
        };
    }
}
