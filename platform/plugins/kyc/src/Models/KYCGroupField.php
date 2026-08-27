<?php

namespace Botble\Kyc\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class KYCGroupField extends BaseModel
{

    protected $table = 'kyc_group_fields';
    protected $fillable = ['kyc_entry_id', 'group_field_name', 'order','status'];
    use SoftDeletes;

    public function kyc():BelongsTo
    {
        return $this->belongsTo(Kyc::class,'kyc_entry_id');
    }
    public function fields():HasMany
    {
        return $this->hasMany(KYCField::class,'kyc_group_field_id');
    }
}
