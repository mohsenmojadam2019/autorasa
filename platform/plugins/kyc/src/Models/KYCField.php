<?php

namespace Botble\Kyc\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KYCField extends BaseModel
{
    use SoftDeletes;

    protected $table = 'kyc_fields';
    protected $fillable = ['kyc_entry_id','kyc_group_field_id', 'field_name', 'field_type','status', 'is_required'];

    const FILE = 'file';
    const NUMBER = 'number';
    const TEXT = 'text';
    const SELECT = 'select';
    const CAR = 'car';
    const NATIONALCODE = 'nationalcode';
    const RADIO = 'radio';
    const VIN = 'vin';
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

    public function kyc():BelongsTo
    {
        return $this->belongsTo(Kyc::class,'kyc_entry_id');
    }
    public function groupfield():BelongsTo
    {
        return $this->belongsTo(KYCGroupField::class,'kyc_group_field_id');
    }
    public function submissions()
    {
        return $this->hasOne(KYCSubmission::class, 'kyc_field_id');
    }
}
