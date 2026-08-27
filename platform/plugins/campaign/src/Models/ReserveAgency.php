<?php

namespace Botble\Campaign\Models;


use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Botble\Campaign\Http\Controllers\CampaignController;

class ReserveAgency extends BaseModel
{
    use HasFactory;
    protected $table = 'reserve_agencies';
    // private  $arraylist = [
    //     [
    //         'id' => 1,
    //         'title' => 'خدمات لاستیک سعید',
    //         'address' => 'تهران، چیتگر شمالی، خیابان جهاد، نبش قدس پانزدهم، پلاک 32',
    //         'img' => asset('campaignImages/1.png'),
    //         'city' => 'مرکز تهران'
    //     ],
    //     [
    //         'id' => 2,
    //         'title' => 'الماس تایر',
    //         'address' => 'تهران- مجیدیه شمالی، خیابان لاهیجانی، کوچه برادران محمدی، پلاک 3',
    //         'img' => asset('campaignImages/2.png'),
    //         'city' => 'مرکز تهران'
    //     ],
    // ];
    // Define the fillable attributes
    protected $fillable = [
        'agency_id',
        'fullname',
        'date',
        'carmodel',
        'time',
        'mobile',
        'reserve_code'
    ];
    public function toArray()
    {
        $array = parent::toArray();
            $array['agency_details'] = CampaignController::arrayList()[$this->agency_id - 1];

        return $array;
    }
    public function operator()
    {
        return $this->belongsTo(Operator::class, 'agency_id');
    }
}
