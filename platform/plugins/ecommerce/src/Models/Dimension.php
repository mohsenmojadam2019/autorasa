<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Dimension extends BaseModel
{
    protected $table = 'ec_dimensions';

    protected $fillable = [
        'name',
        'logo',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    protected static function booted(): void
    {
        self::deleted(function (Dimension $dimension): void {
            $dimension->categories()->detach();
        });
    }

    public function products(): HasMany
    {
        return $this
            ->hasMany(Product::class, 'dimension_id')
            ->where('is_variation', 0)
            ->wherePublished();
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(ProductCategory::class, 'reference', 'ec_product_categorizables', 'reference_id', 'category_id');
    }
}
