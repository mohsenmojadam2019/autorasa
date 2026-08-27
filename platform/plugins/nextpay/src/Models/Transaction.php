<?php

namespace Botble\Nextpay\Models;

use Botble\Base\Models\BaseModel;
use Botble\Ecommerce\Models\Customer;

class Transaction extends BaseModel
{
    protected $table = 'nextpay_transactions';

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
        'message',
        'code',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
