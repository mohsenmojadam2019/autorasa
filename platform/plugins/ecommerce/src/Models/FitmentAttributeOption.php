<?php

namespace Botble\Ecommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FitmentAttributeOption extends Model
{
    protected $table = 'ec_fitment_attribute_options';

    protected $fillable = [
        'attribute_id',
        'options_parent_id',
        'value',
        'icon',
        'label',
        'order',
    ];
    protected $appends = ['name'];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(FitmentAttribute::class, 'attribute_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'option_parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'option_parent_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(FitmentAttributeOptionTranslation::class, 'option_id');
    }

    public function translation(string $langCode)
    {
        return $this->translations()->where('lang_code', $langCode)->first();
    }
    public function getNameAttribute(): string
    {
        $names = [$this->value];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($names, $parent->value);
            $parent = $parent->parent;
        }

        return implode(' - ', $names);
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'ec_product_fitment_attribute', 'option_id', 'product_id');
    }
    public function getFullNameAttribute(): string
    {
        $names = [$this->value];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($names, $parent->value);
            $parent = $parent->parent;
        }

        // اضافه کردن نام attribute به ابتدا اگر موجود باشد
        if ($this->attribute && $this->attribute->name) {
            array_unshift($names, $this->attribute->name);
        }

        return implode(' - ', $names);
    }


}
