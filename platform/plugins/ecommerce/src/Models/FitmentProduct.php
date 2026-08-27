<?php
namespace Botble\Ecommerce\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FitmentProduct extends BaseModel
{
    protected $table = 'ec_product_fitment_attribute';
    public $timestamps = false;
    protected $primaryKey = ['product_id', 'attribute_id', 'option_id'];
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'product_id',
        'attribute_id',
        'option_id',
        'attribute_name',
        'hidden',
        'order',
    ];
    protected function setKeysForSaveQuery($query)
    {
        foreach ($this->getKeyName() as $keyField) {
            $query->where($keyField, '=', $this->getAttribute($keyField));
        }

        return $query;
    }

    public function getKeyName()
    {
        return ['product_id', 'attribute_id', 'option_id'];
    }

    public function getKey()
    {
        return array_map(function ($keyName) {
            return $this->getAttribute($keyName);
        }, $this->getKeyName());
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(FitmentAttribute::class, 'attribute_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(FitmentAttributeOption::class, 'option_id');
    }
}
