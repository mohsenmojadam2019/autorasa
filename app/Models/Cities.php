<?php
// app/Models/ServiceCenter.php
// app/Models/Province.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
protected $table = 'cities';
    protected $fillable = [
        'name',
        'slug',
        'province_id',
    ];

    /**
     * هر شهر متعلق به یک استان است
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * هر شهر می‌تواند چند مرکز خدمات داشته باشد
     */
    public function serviceCenters()
    {
        return $this->hasMany(ServiceCenter::class);
    }
}
