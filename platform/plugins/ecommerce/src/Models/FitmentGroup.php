<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Facades\AdminHelper;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FitmentGroup extends BaseModel
{
    protected $table = 'ec_fitment_groups';

    protected $fillable = [
        'author_type',
        'author_id',
        'name',
        'description',
        'type'
    ];

    protected static function booted(): void
    {
        if (AdminHelper::isInAdmin(true)) {
            static::addGlobalScope('admin', function ($query): void {
                $query->whereNull('author_id');
            });
        }

        static::deleting(function (self $group): void {
            $group->fitmentAttributes()->delete();
        });
    }

    public function fitmentAttributes(): HasMany
    {
        return $this->hasMany(FitmentAttribute::class, 'group_id')->orderBy('parent_id', 'asc');
    }

    public function getFitmentAttributeNameForProduct(int $productId): array
    {
        $attributes = $this->fitmentAttributes;
        $paths = [];

        foreach ($attributes as $attribute) {
            $pivot = DB::table('ec_product_fitment_attribute')
                ->where('attribute_id', $attribute->id)
                ->where('product_id', $productId)
                ->first();

            if (!$pivot || !$pivot->value) {
                continue;
            }

            $optionIds = json_decode($pivot->value, true);
            if (!is_array($optionIds)) {
                continue;
            }

            $options = FitmentAttributeOption::whereIn('id', $optionIds)->get();

            foreach ($options as $option) {
                if ($option->children()->count() > 0) {
                    continue; // Skip parent options
                }

                $chain = [$option->value];
                $parent = $option->parent;

                while ($parent) {
                    array_unshift($chain, $parent->value);
                    $parent = $parent->parent;
                }

                $paths[] = implode(' > ', $chain);
            }
        }

        return $paths;
    }


    public function getFitmentAttributeDetailsForProduct(int $productId): array
    {
        // Get all attributes for the given group
        $attributes = $this->fitmentAttributes; // $this اشاره به FitmentGroup دارد

        $results = [];

        foreach ($attributes as $attribute) {
            // Get the pivot row for this attribute and product
            $pivot = DB::table('ec_product_fitment_attribute')
                ->where('attribute_id', $attribute->id)
                ->where('product_id', $productId)
                ->first();

            if (!$pivot || !$pivot->value) {
                continue;
            }

            // Decode JSON value (should be an array of option IDs)
            $optionIds = json_decode($pivot->value, true);

            if (!is_array($optionIds)) {
                continue;
            }

            // Fetch option details
            $options = FitmentAttributeOption::whereIn('id', $optionIds)->get();

            foreach ($options as $option) {
                // Check if the option has children (i.e. is a parent)
//                if ($option->children()->count() > 0) {
//                    continue; // Skip options with children
//                }

                $results[] = [
                    'product_id'       => $productId,
                    'group_id'         => $this->id, // گروه فعلی
                    'attribute_name'   => $attribute->name,
                    'option_value'     => $option->value,
                    'option_id'        => $option->id,
                ];
            }
        }

        return $results;
    }

}
