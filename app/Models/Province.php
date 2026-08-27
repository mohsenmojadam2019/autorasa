<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * استان دارای چندین شهر است
     */
    public function cities()
    {
        return $this->hasMany(Cities::class);
    }

    /**
     * استان دارای چندین مرکز خدمات است
     */
    public function serviceCenters()
    {
        return $this->hasMany(ServiceCenter::class);
    }
}
