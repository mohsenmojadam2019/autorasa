<?php

namespace Botble\Ecommerce\Enums;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Supports\Enum;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Illuminate\Support\HtmlString;

/**
 * @method static ProductTypeEnum PHYSICAL()
 * @method static ProductTypeEnum DIGITAL()
 */
class ProductFitmentTypeEnum extends Enum
{
    public const CAR = 'car';

    public const SIZE = 'size';

    public const OTHER = 'other';

    public static function toArray(bool $includeDefault = false): array
    {
        return [
            self::CAR => __('Car'),
            self::SIZE => __('Size'),
            self::OTHER => __('Other'),
        ];
    }

}
