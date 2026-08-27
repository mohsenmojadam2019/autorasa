<?php

namespace Botble\Kyc\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class KYCField extends BaseModel
{
    use SoftDeletes;

    protected $table = 'kyc_fields';
    protected $fillable = ['kyc_entry_id', 'kyc_group_field_id', 'field_name', 'field_type', 'status', 'is_required'];

    public const FILE = 'file';
    public const NUMBER = 'number';
    public const TEXT = 'text';
    public const SELECT = 'select';
    public const CAR = 'car';
    public const NATIONALCODE = 'nationalcode';
    public const RADIO = 'radio';
    public const VIN = 'vin';

    public static array $field_types = [
        self::FILE,
        self::NUMBER,
        self::TEXT,
        self::SELECT,
        self::CAR,
        self::NATIONALCODE,
        self::RADIO,
        self::VIN,
    ];

    public function kyc(): BelongsTo
    {
        return $this->belongsTo(Kyc::class, 'kyc_entry_id');
    }

    public function groupfield(): BelongsTo
    {
        return $this->belongsTo(KYCGroupField::class, 'kyc_group_field_id');
    }

    public function submissions()
    {
        $relation = $this->hasOne(KYCSubmission::class, 'kyc_field_id');

        $model = Auth::guard('customer')->user() ?: Auth::user();

        if ($model) {
            return $relation
                ->where('modelable_id', $model->getKey())
                ->where('modelable_type', $model::class);
        }

        return $relation;
    }
}
