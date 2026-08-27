<?php

namespace Botble\Kyc\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class KYCSubmission extends BaseModel
{
    use SoftDeletes;

    protected $table = 'kyc_submissions';
    protected $fillable = ['kyc_entry_id', 'modelable_id','modelable_type', 'kyc_field_id', 'value','status'];

    public function field()
    {
        return $this->belongsTo(KYCField::class, 'kyc_field_id');
    }

    public function kyc()
    {
        return $this->belongsTo(KYC::class, 'kyc_entry_id');
    }
    public function modelable()
    {
        return $this->morphTo();
    }
}
