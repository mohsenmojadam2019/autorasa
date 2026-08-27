<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShahkarController extends Controller
{
    public function submitNationalCode(Request $request)
    {
        $data = [
            'Username' => 'autorasa',
            'password' => 'Rasa@123',
            'mobile' => '09352673656',
            'national_code' => '0082205388',
            ];

        // هدرهای درخواست
        $headers = [
            'Accept-Language' => 'fa',
            'App-Key' => '14476',
            'Device-Id' => '192.168.1.1',
            'Token-Id' => 'vKJUIx32cpDmdnvtBcYvS2AtFcmGDnNrhTUalktByUPenkkdY4nn4d2Z4gUN7jGBCCW2nP3WRjzWRk3t7vZdqVHY',
            'CLIENT-DEVICE-ID' => '127.0.0.1',
            'CLIENT-IP-ADDRESS' => '127.0.0.1',
            'CLIENT-USER-AGENT' => 'User Agent',
            'CLIENT-USER-ID' => '09034325329',
            'CLIENT-PLATFORM-TYPE' => 'WEB',
        ];

        $response = Http::withHeaders($headers)
            ->withoutVerifying()
            ->acceptJson()
            ->post('https://api.sandbox.faraboom.co/v1/mobile/national-code', $data);

        // بررسی پاسخ
        if ($response->successful()) {
            return response()->json([
                'message' => 'درخواست با موفقیت ارسال شد.',
                'data' => $response->json()
            ]);
        } else {
            return response()->json([
                'error' => 'خطا در ارسال درخواست.',
                'details' => $response->body()
            ], 400);
        }
    }

    public function inquiryBirthDate(Request $request)
    {
        $url = 'https://api.sandbox.faraboom.co/v1/identity/inquiry/birthDate';

        $headers = [
            'accept-language' => 'fa',
            'app-key' => '14476',
            'device-id' => '192.168.1.1',
            'token-id' => 'vKJUIx32cpDmdnvtBcYvS2AtFcmGDnNrhTUalktByUPenkkdY4nn4d2Z4gUN7jGBCCW2nP3WRjzWRk3t7vZdqVHY',
            'client-device-id' => '127.0.0.1',
            'client-ip-address' => '127.0.0.1',
            'client-user-agent' => 'User Agent',
            'client-user-id' => '1810037492',
            'client-platform-type' => 'WEB',
            'Content-Type' => 'application/json',
        ];

        $body = [
            'national_code' => $request->input('national_code'),//'1810037492'
            'birth_date' => $request->input('birth_date'),//1990-06-04T00:00:00 // تبدیل 14/03/1369 به میلادی
        ];

        try {
            $response = Http::withOptions([
                'verify' => false, // فقط برای sandbox در صورت خطای SSL
            ])->withHeaders($headers)->post($url, $body);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            } else {
                $responseData = json_decode($response->body(), true);
                $errorMessages = [];

                if (isset($responseData['errors']) && is_array($responseData['errors'])) {
                    foreach ($responseData['errors'] as $error) {
                        $errorMessages[] = [
                            'code' => $error['code'] ?? '',
                            'message_fa' => $error['message'] ?? '',
                            'message_en' => $error['info'] ?? '',
                        ];
                    }
                }

                return response()->json([
                    'error' => true,
                    'ref_id' => $responseData['ref_id'] ?? null,
                    'errors' => $errorMessages,
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Exception: ' . $e->getMessage()
            ], 500);
        }
    }
}
