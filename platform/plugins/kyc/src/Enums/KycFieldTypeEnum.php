<?php

namespace Botble\Kyc\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

/**
 * @method static KycStatusEnum ACTIVATE()
 * @method static KycStatusEnum DEACTIVATE()
 */
class KycFieldTypeEnum extends Enum
{
    public const FILE = 'file';
    public const NUMBER = 'number';
    public const TEXT = 'text';
    public const SELECT = 'select';
    public const CAR = 'car';
    public const NATIONALCODE = 'nationalcode';
    public const RADIO = 'radio';
    public const VIN = 'vin';
    public static function toArray(bool $includeDefault = false): array
    {
        $values = [
            self::FILE => 'file',
            self::NUMBER => 'number',
            self::TEXT => 'text',
            self::SELECT => 'select',
            self::CAR => 'car',
            self::NATIONALCODE => 'nationalcode',
            self::RADIO => 'radio',
            self::VIN => 'vin',
        ];

        if ($includeDefault) {
            // Optionally include the default value
            // Example: You could add a default "Please select" option if needed
            $values = ['' => 'Please select'] + $values;
        }

        return $values;
    }



}
