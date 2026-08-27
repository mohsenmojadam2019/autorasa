<?php

namespace Botble\Ecommerce\Models;
use App\Models\ServiceCenter;
use Morilog\Jalali\Jalalian;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Booking extends baseModel
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
    public function getBookingTimeFormattedAttribute()
    {
        if (!$this->booking_time) {
            return null;
        }

        try {
            return \Carbon\Carbon::createFromFormat('H:i:s', $this->booking_time)->format('H:i');
        } catch (\Exception $e) {
            return $this->booking_time;
        }
    }

    public function getBookingDateJalaliAttribute()
    {
        if (!$this->booking_date) {
            return null;
        }

        try {
            return Jalalian::fromDateTime($this->booking_date)->format('Y/m/d');
        } catch (\Exception $e) {
            return $this->booking_date;
        }
    }
    protected $casts = [

        'options' => 'array',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

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
        return $this->belongsTo(ServiceCenter::class);
    }
}
