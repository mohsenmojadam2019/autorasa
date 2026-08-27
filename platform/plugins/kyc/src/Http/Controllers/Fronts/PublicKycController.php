<?php

namespace Botble\Kyc\Http\Controllers\Fronts;

use App\Models\RetailDocumentSubmission;
use App\Services\ShahkarService;
use App\Services\SubmitRetailService;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\Order;
use Botble\Kyc\Enums\KycEnum;
use Botble\Kyc\Enums\KycFieldTypeEnum;
use Botble\Kyc\Forms\Fronts\PublicKycFieldForm;
use Botble\Kyc\Forms\KycFieldForm;
use Botble\Kyc\Models\Kyc;
use Botble\Kyc\Models\KYCField;
use Botble\Kyc\Models\KYCGroupField;
use Botble\Kyc\Models\KYCSubmission;
use Botble\Kyc\Traits\DetectGuard;
use Botble\Media\Facades\RvMedia;
use Botble\Media\Models\MediaFile;
use Botble\Theme\Facades\Theme;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicKycController extends BaseController
{
    use DetectGuard;

    public function getKyc(Request $request,$redirect = null, $token = null,$order_type=null)
    {
//        dd($redirect,$token);
        $guard = $this->detectGuard();
        if ($redirect and $token)
            session()->put('redirect_back_url', route($redirect,['token'=>$token]));
//        dd($request->order_type);
        if ($request->order_type=='post')
            session()->put('order_type','post');
        abort_unless(EcommerceHelper::isCartEnabled(), 404);
        if (!EcommerceHelper::isEnabledGuestCheckout() && !auth($guard)->check()) {
            return $this->httpResponse()->setNextUrl('/');
        }

        $modelEntity = auth($guard)->user();
        $modelable_id=$modelEntity->id;
        $kyc = Kyc::query()
            ->where('model', strtolower(class_basename($modelEntity)))
            ->with(['groupfields.fields.groupfield',
                'groupfields.fields.submissions' => function ($query) use ($modelable_id) {
                    $query->where('modelable_id', $modelable_id);
                }
            ])
            ->first();

        if (!$kyc) {
            return redirect()->back()->withErrors('محصول موجود نیست');
        }


        $totalSteps = $kyc->groupFields()->count();

        $model=$modelEntity;
        $currentStep = session('kyc_current_step', 1);
        $currentStep=(($currentStep<1) or ($currentStep>$totalSteps))?1:$currentStep;
//        dd(session('order_type'));
        return Theme::scope(
            'plugins/kyc::theme.kyc',
            compact('kyc', 'model', 'currentStep', 'totalSteps'),
            'plugins/kyc::theme.kyc'
        )->render();
    }




//    public function nextStep(Request $request)
//    {
//        $rules = [
//            '_token' => 'required|string',
//            'fields' => 'required|array',
//        ];
//        $validator = Validator::make($request->all(), $rules);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'status' => 'error',
//                'message' => 'لطفاً اطلاعات مورد نیاز را تکمیل کنید.',
//            ]);
//        }
//
//        $guard = $this->detectGuard();
//        $user = auth($guard)->user();
//
//        $kyc_entry_id = '';
//        foreach ($request->fields as $field_id => $field_value) {
//            if ($field_value) {
//                $kycField = KYCField::findOrFail($field_id);
//                $kyc_entry_id = $kycField->kyc_entry_id;
//
//                $submission = KYCSubmission::where([
//                    'kyc_field_id' => $field_id,
//                    'modelable_id' => $user->id,
//                    'modelable_type' => $user::class
//                ])->first();
//
//                // بررسی کد ملی برای ارسال به سامانه تجارت
//                if ($kycField->field_type == KycFieldTypeEnum::NATIONALCODE) {
//
//                    $mobile = $user->phone; // یا هر فیلدی که شماره موبایل ذخیره شده
//                    $nationalCode = $field_value;
//
//                    $shahkarService = new ShahkarService();
//                    $result = $shahkarService->verifyMobileAndNationalCode($mobile, $nationalCode);
//
//                    if (!$result['success'] || ($result['data']['result']['IsOwner'] ?? false) !== true) {
//                        return response()->json([
//                            'status' => 'error',
//                            'message' => 'کاربر گرامی، کد ملی با شماره موبایل مطابقت ندارد.',
//                            'redirect_to' => session()->get('redirect_back_url')
//                        ]);
//                    }
//
//
////                    dd($user);
//                    $zipCode = $user->addresses; // گرفتن کدپستی از آدرس کاربر
//
//                    // ارسال درخواست به سامانه برای چک کردن سهمیه
//                    $response = (new SubmitRetailService())->sendRetailDocument([
//                        'username' => 'your_username',
//                        'srvPass' => 'your_password',
//                        'password_otpCode' => 'otp_code',
//                        'PersonNationalID' => $field_value,
//                        'DocumentDate' => now()->toDateString(),
//                        'BuyerDatiles' => 'details_here',
//                        'PostalCode' => $zipCode,
//                        'Stuffs_In' => 'stuff_info',
//                    ]);
//
//                    // اگر ریسپانس موفقیت‌آمیز بود
//                    if ($response['success'] && $response['result']->SubmitRetailResult->Status ?? false) {
//                        RetailDocumentSubmission::create([
//                            'customer_id'     => $user->id,
//                            'national_code'   => $field_value,
//                            'trace_code'      => $response['result']->SubmitRetailResult->TraceCode ?? null,
//                            'document_number' => $response['result']->SubmitRetailResult->DocumentNumber ?? null,
//                            'register_date'   => $response['result']->SubmitRetailResult->RegisterDate ?? null,
//                            'postal_code'     => $zipCode,
//                            'raw_response'    => json_encode($response['result']),
//                        ]);
//                    } else {
//                        // در صورتی که ریسپانس سامانه موفقیت‌آمیز نباشد
//                        return response()->json([
//                            'status' => 'error',
//                            'message' => 'کاربر گرامی، سهمیه خرید تایر دولتی شما متاسفانه به پایان رسیده است.',
//                            'redirect_to' => session()->get('redirect_back_url')
//                        ]);
//                    }
//                }
//
//                if ($field_value instanceof \Illuminate\Http\UploadedFile) {
//                    $result = RvMedia::handleUpload($field_value, 0, 'kyc/'.$user->id);
//                    if ($result['error']) {
//                        return response()->json([
//                            'status' => 'error',
//                            'message' => $result['message'],
//                            'redirect_to' => session()->get('redirect_back_url')
//                        ]);
//                    }
//                    $valuecol = $result['data']->url;
//                } else {
//                    $valuecol = $field_value;
//                }
//
//                // ذخیره اطلاعات در KYCSubmission
//                KYCSubmission::updateOrCreate(
//                    [
//                        'kyc_entry_id' => $kycField->kyc_entry_id,
//                        'kyc_field_id' => $field_id,
//                        'modelable_id' => $user->id,
//                        'modelable_type' => $user::class,
//                    ],
//                    ['value' => $valuecol]
//                );
//            }
//        }
//
//        // ارسال پاسخ موفقیت‌آمیز
//        return response()->json([
//            'status' => 'success',
//            'finished' => true,
//            'redirect_to' => session()->get('redirect_back_url')
//        ]);
//    }

    public function nextStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '_token' => 'required|string',
            'fields' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'لطفاً اطلاعات مورد نیاز را تکمیل کنید.',
            ]);
        }
        header('Access-Control-Allow-Origin: *');
        $guard = $this->detectGuard();
        $user = auth($guard)->user();

        foreach ($request->fields as $field_id => $field_value) {
            if (empty($field_value)) {
                continue;
            }

            $kycField = KYCField::find($field_id);
            if (!$kycField) {
                continue;
            }

            // اگر نوع فیلد کد ملی است
            if ($kycField->field_type === KycFieldTypeEnum::NATIONALCODE) {
                $nationalCode = $field_value;
                $mobile = $user->phone;

                $shahkarService = new ShahkarService();
                $result = $shahkarService->verifyMobileAndNationalCode($mobile, $nationalCode);

                if (!$result['success'] || ($result['data']['match']== false)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'کاربر گرامی، کد ملی با شماره موبایل مطابقت ندارد.',
                        'redirect_to' => session()->get('redirect_back_url')
                    ]);
                }

//                $zipCode = optional($user->addresses->first())->postal_code;
//
//                if (!$zipCode) {
//                    return response()->json([
//                        'status' => 'error',
//                        'message' => 'کدپستی کاربر یافت نشد.',
//                        'redirect_to' => session()->get('redirect_back_url')
//                    ]);
//                }

                // ارسال به سامانه تجارت
//                $response = (new SubmitRetailService())->sendRetailDocument([
//                    'username' => config('services.retail.username'),
//                    'srvPass' => config('services.retail.password'),
//                    'password_otpCode' => 'otp_code', // بررسی شود که این مقدار چگونه مدیریت می‌شود
//                    'PersonNationalID' => $nationalCode,
//                    'DocumentDate' => now()->toDateString(),
//                    'BuyerDatiles' => 'details_here', // جایگزین شود با اطلاعات واقعی
////                    'PostalCode' => $zipCode,
//                    'Stuffs_In' => 'stuff_info', // جایگزین شود با اطلاعات واقعی
//                ]);

//                if ($response['success'] && $response['result']->SubmitRetailResult->Status ?? false) {
//                    RetailDocumentSubmission::create([
//                        'customer_id'     => $user->id,
//                        'national_code'   => $nationalCode,
//                        'trace_code'      => $response['result']->SubmitRetailResult->TraceCode ?? null,
//                        'document_number' => $response['result']->SubmitRetailResult->DocumentNumber ?? null,
//                        'register_date'   => $response['result']->SubmitRetailResult->RegisterDate ?? null,
////                        'postal_code'     => $zipCode,
//                        'raw_response'    => json_encode($response['result']),
//                    ]);
//                } else {
//                    return response()->json([
//                        'status' => 'error',
//                        'message' => 'کاربر گرامی، سهمیه خرید تایر دولتی شما متاسفانه به پایان رسیده است.',
//                        'redirect_to' => session()->get('redirect_back_url')
//                    ]);
//                }
            }

            // مدیریت آپلود فایل یا داده متنی
            $value = $this->processKycFieldValue($field_value, $user->id);
            if ($value === false) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'خطا در بارگذاری فایل.',
                    'redirect_to' => session()->get('redirect_back_url')
                ]);
            }

            // ذخیره اطلاعات در KYCSubmission
            KYCSubmission::updateOrCreate(
                [
                    'kyc_entry_id' => $kycField->kyc_entry_id,
                    'kyc_field_id' => $field_id,
                    'modelable_id' => $user->id,
                    'modelable_type' => $user::class,
                ],
                ['value' => $value]
            );
        }

        return response()->json([
            'status' => 'success',
            'finished' => true,
            'redirect_to' => session()->get('redirect_back_url')
        ]);
    }
    private function processKycFieldValue($field_value, $userId)
    {
        if ($field_value instanceof \Illuminate\Http\UploadedFile) {
            $result = RvMedia::handleUpload($field_value, 0, 'kyc/' . $userId);
            return $result['error'] ? false : $result['data']->url;
        }

        return $field_value;
    }

    public function prevStep(Request $request)
    {
        $currentStep = session('kyc_current_step', 1);
        // Move to the previous step
        $newStep = max($currentStep - 1, 1);
        session(['kyc_current_step' => $newStep]);

        return response()->json([
            'status' => 'success',
            'currentStep' => $newStep,
            'finished' => false,
        ]);
    }
    public function showKycs(Request $request)
    {
        $guard = $this->detectGuard();
        session()->put('redirect_back_url', url()->previous());
        if ($request->order_type=='post')
            session()->put('order_type','post');
        abort_unless(EcommerceHelper::isCartEnabled(), 404);
        if (!EcommerceHelper::isEnabledGuestCheckout() && !auth($guard)->check()) {
            return $this->httpResponse()->setNextUrl('/');
        }

        $modelEntity = auth($guard)->user();
        $modelable_id=$modelEntity->id;
        $kyc = Kyc::query()
            ->where('model', strtolower(class_basename($modelEntity)))
            ->with(['groupfields.fields.groupfield',
                'groupfields.fields.submissions' => function ($query) use ($modelable_id) {
                    $query->where('modelable_id', $modelable_id);
                }
            ])
            ->first();

        if (!$kyc) {
            return redirect()->back()->withErrors('محصول موجود نیست');
        }


        $totalSteps = $kyc->groupFields()->count();

        $model=$modelEntity;
        $currentStep = session('kyc_current_step', 1);
        $currentStep=(($currentStep<1) or ($currentStep>$totalSteps))?1:$currentStep;
//        dd(session('order_type'));
        return Theme::scope(
            'plugins/kyc::theme.kyc',
            compact('kyc', 'model', 'currentStep', 'totalSteps'),
            'plugins/kyc::theme.kyclist'
        )->render();

    }

    public function showgroupfield($id)
    {
        // dd(auth('customer')->user());
        $fields=KYCField::where('kyc_group_field_id',$id)->with(['submissions' => function($query) {
            $query->where('modelable_id', auth('customer')->user()->id);
        }])->get();
        return Theme::scope(
            'plugins/kyc::theme.kycgroupfields',
            compact(['fields']),
            'plugins/kyc::theme.kycgroupfields'
        )->render();
    }

    public function showField($id)
    {
        $field=KYCField::where('id',$id)->with(['submissions' => function($query) {
            $query->where('modelable_id', auth('customer')->user()->id);
        }])->first();
        return Theme::scope(
            'plugins/kyc::theme.kycForm',
            compact(['field']),
            'plugins/kyc::theme.kycForm'
        )->render();
    }

    public function storekyc(Request $request)
    {
        $guard = $this->detectGuard();
        $modelEntity = auth($guard)->user();
        $kycField = KYCField::findOrFail($request->kyc_field_id);
        $submission = KYCSubmission::where([
            'kyc_field_id' => $request->kyc_field_id,
            'modelable_id' => $modelEntity->id,
            'modelable_type' => $modelEntity::class
        ])->first();

        if ($request->hasFile('value')) {
            $image=$request->file('value');
//            dd(RvMedia::handleUpload($image, 0, 'kyc'));
            $result = RvMedia::handleUpload($image, 0, 'kyc/'.$modelEntity->id);
            if ($result['error']) {
                return $this
                    ->httpResponse()
                    ->setError()
                    ->setMessage($result['message']);
            }
//            $folder = 'kyc/' . $modelEntity->id;
//            $filePath = $request->file('value')->store($folder, 'local'); // Saved in storage/app/kyc/{user_id}
//
//            // Delete old file if exists
//            if ($submission && $submission->value) {
//                Storage::disk('local')->delete($submission->value);
//            }
//
            $valuecol = $result['data']->url;
        } else {
            // Handle text/number field
            $valuecol = $request->value;
        }

//        dd(KycEnum::KYC_PENDING()->getValue());
        KYCSubmission::updateOrCreate(
            [
                'kyc_entry_id' => $kycField->kyc_entry_id,
                'kyc_field_id' => $request->kyc_field_id,
                'modelable_id' => $modelEntity->id,
                'modelable_type' => $modelEntity::class,
            ],
            ['value' => $valuecol,'status'=>'pending']
        );
        return redirect()->route('public.kyc.showgroupfield', ['id' => $kycField->kyc_group_field_id])
            ->with('success', 'KYC information saved successfully.');

        return redirect()->back()->with('success', 'KYC information saved successfully.');
    }



    public function deleteFile(Request $request)
    {
        $validatedData = $request->validate([
            'field_id' => 'required|exists:kyc_fields,id',
        ]);
        $guard = $this->detectGuard();
        $modelEntity = auth($guard)->user();
        $submission = KYCSubmission::where([
            'kyc_field_id' => $validatedData['field_id'],
            'modelable_id' => $modelEntity->id,
            'modelable_type' => $modelEntity::class,
        ])->first();

        if ($submission && $submission->value) {
            // Delete the file using RvMedia
            RvMedia::deleteFile($submission->value);

            // Remove the submission record
            $submission->delete();

            return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'No file found to delete.']);
    }
}
