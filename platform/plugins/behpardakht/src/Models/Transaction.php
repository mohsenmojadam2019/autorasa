<?php

namespace Botble\Behpardakht\Models;

use Botble\Base\Models\BaseModel;
use Botble\Ecommerce\Models\Customer;

class Transaction extends BaseModel
{
    protected $table = 'transactions';

    protected $fillable = [
        'customer_id',
        'amount',
        'order_id',
        'transaction_id',
        'token',
        'reference_id',
        'status',
        'currency',
        'metadata',
        'payment',
        'message',
        'code',
        'fee',
        'card_pan',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
