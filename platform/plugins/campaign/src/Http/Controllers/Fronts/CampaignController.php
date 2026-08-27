<?php
//
//namespace Botble\Campaign\Http\Controllers\Fronts;
//
//use Botble\Base\Http\Actions\DeleteResourceAction;
//use Botble\Campaign\Http\Requests\CampaignRequest;
//use Botble\Campaign\Models\Campaign;
//use Botble\Base\Http\Controllers\BaseController;
//use Botble\Campaign\Models\ReserveAgency;
//use Botble\Campaign\Tables\CampaignTable;
//use Botble\Campaign\Forms\CampaignForm;
//use Illuminate\Http\Request;
//use Morilog\Jalali\Jalalian;
//use Throwable;
//
//class CampaignController extends BaseController
//{
//    public function __construct()
//    {
//        $this
//            ->breadcrumb()
//            ->add(trans(trans('plugins/campaign::campaign.name')), route('campaign.index'));
//    }
//
//    public function show()
//    {
//        $arraylist=[
//            [
//                'id'=>1,
//                'title'=>'خدمات لاستیک سعید',
//                'address'=>'تهران، چیتگر شمالی، خیابان جهاد، نبش قدس پانزدهم، پلاک 32',
//                'img'=>asset('campaignImages/1.png'),
//                'city'=>'مرکز تهران'
//            ],
//            [
//                'id'=>2,
//                'title'=>'الماس تایر',
//                'address'=>'تهران- مجیدیه شمالی، خیابان لاهیجانی، کوچه  برادران محمدی، پلاک 3',
//                'img'=>asset('campaignImages/2.png'),
//                'city'=>'مرکز تهران'
//            ],
//            [
//                'id'=>3,
//                'title'=>'خدمات لاستیک سعید',
//                'address'=>'تهران، چیتگر شمالی، خیابان جهاد، نبش قدس پانزدهم، پلاک 32',
//                'img'=>asset('campaignImages/3.png'),
//                'city'=>'مرکز تهران'
//            ],
//            [
//                'id'=>4,
//                'title'=>'الماس تایر',
//                'address'=>'تهران- مجیدیه شمالی، خیابان لاهیجانی، کوچه  برادران محمدی، پلاک 3',
//                'img'=>asset('campaignImages/4.png'),
//                'city'=>'مرکز تهران'
//            ],
//        ];
//        return view('plugins/campaign::show',compact('arraylist'));
//    }
//
//    public function agency($id)
//    {
////        dd(1);
//        $weekDays=$this->weekdays();
//        $timeSlots=$this->timeSlots();
//        return view('plugins/campaign::reserve-form',compact(['id','weekDays','timeSlots']));
//
//    }
//    private function timeSlots()
//    {
//        $timeSlots = [];
//        for ($i = 9; $i <= 19; $i += 2) { // Corrected increment
//            array_push($timeSlots, 'ساعت ' . $i . ' تا ' . ($i + 2));
//        }
//        return $timeSlots;
//    }
//
//    private function weekdays(){
//        $now=Jalalian::now();
//        $startday=$now->getDayOfWeek();
//        $days=[];
//        for ($i=$startday; $i<=6;$i++){
//            array_push($days,$this->day($i).' ('.$now->format('d-m-Y').')');
//            $now=$now->addDay();
//        }
//        return $days;
//    }
//    private function day($dayIndex)
//    {
//        $days = [
//            0 => 'شنبه',
//            1 => 'یک‌شنبه',
//            2 => 'دوشنبه',
//            3 => 'سه‌شنبه',
//            4 => 'چهارشنبه',
//            5 => 'پنج‌شنبه',
//            6 => 'جمعه',
//        ];
//
//        return $days[$dayIndex] ?? '';
//    }
//
//    public function reserve(Request $request)
//    {
//        $data=$request->all();
//        $data['reserve_code']=$this->generateUniqueCode($data);
////        dd($data);
//        try {
//            ReserveAgency::create($data);
//            $message='success';
//            return view('plugins/campaign::result',compact('message'));
//        }catch (Throwable $exception){
//            $message='error';
//            return view('plugins/campaign::result',compact('message'));
//        }
//    }
//    private function generateUniqueCode(array $data): string
//    {
//        // Convert the array to a JSON string and hash it
//        $hash = md5(json_encode($data));
//
//        // Extract a unique 7-digit numeric code from the hash
//        return substr(preg_replace('/[^0-9]/', '', $hash), 0, 7) ?: '1234567';
//    }
//
//}


namespace Botble\Campaign\Http\Controllers\Fronts;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Campaign\Http\Requests\ReserveRequest;
use Botble\Campaign\Models\Operator;
use Botble\Campaign\Models\ReserveAgency;
use FriendsOfBotble\Sms\Facades\Sms;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Throwable;

class CampaignController extends BaseController
{


    public function __construct()
    {
        $this->breadcrumb()
            ->add(trans('plugins/campaign::campaign.name'), route('campaign.index'));
    }

    public function show()
    {
        $arraylist = [
            [
                'id' => 1,
                'title' => 'خدمات لاستیک سعید',
                'address' => 'تهران، چیتگر شمالی، خیابان جهاد، نبش قدس پانزدهم، پلاک 32',
                'img' => asset('campaignImages/1.png'),
                'city' => 'مرکز تهران'
            ],
            [
                'id' => 2,
                'title' => 'الماس تایر',
                'address' => 'تهران- مجیدیه شمالی، خیابان لاهیجانی، کوچه برادران محمدی، پلاک 3',
                'img' => asset('campaignImages/2.png'),
                'city' => 'مرکز تهران'
            ],
        ];
        $operators=Operator::all();
        return view('plugins/campaign::show', compact('operators'));
    }

    public function agency(int $id)
    {
        return view('plugins/campaign::reserve-form', [
            'id' => $id,
            'weekDays' => $this->weekdays(),
            'timeSlots' => $this->timeSlots()
        ]);
    }

    private function timeSlots(): array
    {
        $slots = [];
        for ($i = 9; $i <= 19; $i += 2) {
            $slots[] = "ساعت $i تا " . ($i + 2);
        }
        return $slots;
    }

    private function weekdays(): array
    {
        $now = Jalalian::now();
        $startDay = $now->getDayOfWeek();
        $days = [];

        for ($i = $startDay; $i <= 6; $i++) {
            $days[] = $this->day($i) . " ({$now->format('d-m-Y')})";
            $now = $now->addDay();
        }

        return $days;
    }

    private function day(int $dayIndex): string
    {
        return [
                'شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'
            ][$dayIndex] ?? '';
    }

    public function reserve(Request $request)
    {
        // تبدیل اعداد فارسی به انگلیسی
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $request->merge([
            'mobile' => str_replace($persianNumbers, $englishNumbers, $request->mobile)
        ]);
//        dd($request->all());

        $request->validate([
            'agency_id' => 'required|integer|exists:operators,id',
            'fullname'  => 'required|string|max:255',
            'carmodel'  => 'required|string|max:255',
            'date'      => 'required|string',
            'time'      => 'required|string',
            'mobile'    => 'required|string',
        ]);
        $mobilePattern = '/^(09\d{9}|9\d{9})$/';

        // Check if the mobile number is valid
        if (!preg_match($mobilePattern, $request->mobile)) {
            return view('plugins/campaign::result', ['status'=>'error','message' => 'شماره موبایل معتبر نیست..']);
        }
        if (ReserveAgency::where('mobile', $request->mobile)->exists()) {
            return view('plugins/campaign::result', [
                'status' => 'error',
                'message' => 'شماره موبایل قبلاً ثبت شده است.'
            ]);
        }

        try {
            $reserveCode = $this->generateUniqueCode();

            $reserve = ReserveAgency::create([
                'agency_id'   => $request->agency_id,
                'fullname'    => $request->fullname,
                'carmodel'    => $request->carmodel,
                'date'        => $request->date,
                'time'        => $request->time,
                'mobile'      => $request->mobile,
                'reserve_code'=> $reserveCode,
            ]);

            $reserve->load('operator');

            $sms = Sms::driver($request->input('gateway'))->send(
                $request->mobile,
                'تبریک! رزرو شما انجام شد. تاریخ: ' . $reserve->date . ' ' . $reserve->time .
                ' کد رزرو: ' . $reserveCode . ' لطفا در زمان تعیین شده به آدرس ' .
                $reserve->operator->address . ' مراجعه فرمایید. فروشگاه اینترنتی اتوراسا'
            );

            return view('plugins/campaign::result', [
                'status' => 'success',
                'message' => 'رزرو نوبت با موفقیت انجام شد.',
                'reserve' => $reserve
            ]);
        } catch (Throwable $exception) {
            return view('plugins/campaign::result', [
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    private function generateUniqueCode(): string
    {
        do {
            $code = mt_rand(1000000, 9999999);
        } while (ReserveAgency::where('reserve_code', $code)->exists());

        return (string)$code;
    }
}
