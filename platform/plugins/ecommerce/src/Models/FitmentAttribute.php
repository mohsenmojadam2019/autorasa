<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Facades\AdminHelper;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FitmentAttribute extends BaseModel
{
    protected $table = 'ec_fitment_attributes';

    protected $fillable = [
        'author_type',
        'author_id',
        'group_id',
        'name',
        'icon',
//        'type',
//        'options',
        'default_value',
        'parent_id',
    ];

//    protected $casts = [
//        'options' => 'array',
//    ];

    protected static function booted(): void
    {
        if (AdminHelper::isInAdmin(true)) {
            static::addGlobalScope('admin', function ($query): void {
                $query->whereNull('author_id');
            });
        }

        static::deleted(function (self $attribute): void {
            $attribute->products()->detach();
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'ec_product_fitment_attribute', 'attribute_id', 'product_id');
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function group(): BelongsTo
    {
        return $this->belongsTo(FitmentGroup::class, 'group_id');
    }
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function child(): HasOne
    {
        return $this->hasOne(self::class, 'parent_id');
    }
    public function options(): HasMany
    {
        return $this->hasMany(FitmentAttributeOption::class, 'attribute_id');
    }
    public function latestOptions($offset)
    {
        return $this->hasMany(FitmentAttributeOption::class, 'attribute_id')
            ->latest('id')->skip($offset*10)->take(10)->get();
    }
    public function fitmentProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FitmentProduct::class, 'attribute_id')->with(['option','product']);
    }
}
