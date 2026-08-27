<?php

namespace App\Models;

use Botble\Autoservice\Models\Autoservice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function cities()
    {
        return $this->hasMany(Cities::class);
    }

    public function serviceCenters()
    {
        return $this->hasMany(Autoservice::class, 'province_id');
    }
}
