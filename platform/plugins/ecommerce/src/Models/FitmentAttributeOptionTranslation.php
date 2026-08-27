<?php

namespace Botble\Ecommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FitmentAttributeOptionTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'ec_fitment_attribute_options_translations';

    protected $fillable = [
        'lang_code',
        'option_id',
        'label',
    ];

    protected $primaryKey = null;
    public $incrementing = false;

    public function option(): BelongsTo
    {
        return $this->belongsTo(FitmentAttributeOption::class, 'option_id');
    }
}
