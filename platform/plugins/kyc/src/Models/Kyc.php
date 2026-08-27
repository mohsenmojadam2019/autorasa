<?php

namespace Botble\Kyc\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Kyc\Services\KycCacheService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kyc extends BaseModel
{
    use SoftDeletes;

    protected $table = 'kyc_entries';
    protected $fillable = ['model','route_name_pattern','redirect_if_not_logged_in', 'is_verified', 'status'];

    public function groupfields():HasMany
    {
        return $this->hasMany(KYCGroupField::class,'kyc_entry_id')->orderBy('order');
    }
    public function fields():HasMany
    {
        return $this->hasMany(KYCField::class,'kyc_entry_id');
    }
    public function submissions()
    {
        return $this->hasMany(KYCSubmission::class, 'kyc_entry_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            app(KycCacheService::class)->clearCache();
        });

        static::deleted(function () {
            app(KycCacheService::class)->clearCache();
        });
    }
}
