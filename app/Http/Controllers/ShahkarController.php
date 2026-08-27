<?php

namespace App\Http\Controllers;

use App\Services\ShahkarService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShahkarController extends Controller
{
    public function submitNationalCode(Request $request, ShahkarService $shahkarService)
    {
        $validated = $request->validate([
            'mobile' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'national_code' => ['required', 'digits:10'],
        ]);

        $result = $shahkarService->verifyMobileAndNationalCode(
            $validated['mobile'],
            $validated['national_code']
        );

        if ($result['success']) {
            return response()->json([
                'message' => 'درخواست با موفقیت ارسال شد.',
                'data' => $result['data'],
            ]);
        }

        return response()->json([
            'error' => 'خطا در ارسال درخواست.',
            'details' => $result['error'] ?? null,
        ], $result['status'] ?? 502);
    }

    public function inquiryBirthDate(Request $request)
    {
        $validated = $request->validate([
            'national_code' => ['required', 'digits:10'],
            'birth_date' => ['required', 'date'],
        ]);

        $url = 'https://api.sandbox.faraboom.co/v1/identity/inquiry/birthDate';

        $headers = [
            'accept-language' => 'fa',
            'app-key' => '14476',
            'device-id' => '192.168.1.1',
            'token-id' => 'vKJUIx32cpDmdnvtBcYvS2AtFcmGDnNrhTUalktByUPenkkdY4nn4d2Z4gUN7jGBCCW2nP3WRjzWRk3t7vZdqVHY',
            'client-device-id' => '127.0.0.1',
            'client-ip-address' => '127.0.0.1',
            'client-user-agent' => 'User Agent',
            'client-user-id' => $validated['national_code'],
            'client-platform-type' => 'WEB',
            'Content-Type' => 'application/json',
        ];

        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders($headers)
                ->post($url, $validated);
        } catch (ConnectionException $e) {
            report($e);

            return response()->json([
                'error' => true,
                'message' => 'ارتباط با سرویس استعلام برقرار نشد.',
            ], 503);
        }

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json(),
            ]);
        }

        $responseData = $response->json() ?: [];
        $errorMessages = [];

        foreach (($responseData['errors'] ?? []) as $error) {
            $errorMessages[] = [
                'code' => $error['code'] ?? '',
                'message_fa' => $error['message'] ?? '',
                'message_en' => $error['info'] ?? '',
            ];
        }

        return response()->json([
            'error' => true,
            'ref_id' => $responseData['ref_id'] ?? null,
            'errors' => $errorMessages,
        ], $response->status());
    }
}
