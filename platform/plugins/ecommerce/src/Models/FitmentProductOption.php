<?php
namespace Botble\Ecommerce\Models;

use Botble\Base\Models\BaseModel;

class FitmentProductOption extends BaseModel
{
    protected $table = 'ec_product_fitment_attribute_option';

    protected $fillable = [
        'product_id',
        'attribute_id',
        'option_id',
    ];

    public $timestamps = false;

    public function option()
    {
        return $this->belongsTo(FitmentAttributeOption::class, 'option_id');
    }

    public function fitment()
    {
        return $this->belongsTo(FitmentProduct::class, ['product_id', 'attribute_id']);
    }
}
