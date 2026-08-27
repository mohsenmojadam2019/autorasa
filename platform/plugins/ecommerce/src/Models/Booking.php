<?php

namespace Botble\Ecommerce\Models;

use Botble\Autoservice\Models\Autoservice;
use Botble\Base\Models\BaseModel;
use Morilog\Jalali\Jalalian;

class Booking extends BaseModel
{
    protected $table = 'bookings';

    protected $fillable = [
        'customer_id',
        'service_center_id',
        'booking_date',
        'booking_time',
        'product_id',
        'quantity',
        'price',
        'total',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function getBookingTimeFormattedAttribute()
    {
        if (! $this->booking_time) {
            return null;
        }

        try {
            return \Carbon\Carbon::createFromFormat('H:i:s', $this->booking_time)->format('H:i');
        } catch (\Exception) {
            return $this->booking_time;
        }
    }

    public function getBookingDateJalaliAttribute()
    {
        if (! $this->booking_date) {
            return null;
        }

        try {
            return Jalalian::fromDateTime($this->booking_date)->format('Y/m/d');
        } catch (\Exception) {
            return $this->booking_date;
        }
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function serviceCenter()
    {
        return $this->belongsTo(Autoservice::class, 'service_center_id');
    }
}
