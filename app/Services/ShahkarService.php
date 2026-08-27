<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShahkarService
{

    public function inquire(string $nationalCode, string $mobile)
    {
        $mobile='090343253269';
        $nationalCode='1810037492';
        $response = Http::withHeaders([
            'Accept-Language' => 'fa',
            'App-Key' => '14476',
            'Device-Id' => '192.168.1.1',
            'Token-Id' => 'vKJUIx32cpDmdnvtBcYvS2AtFcmGDnNrhTUalktByUPenkkdY4nn4d2Z4gUN7jGBCCW2nP3WRjzWRk3t7vZdqVHY',
            'CLIENT-DEVICE-ID' => '127.0.0.1',
            'CLIENT-IP-ADDRESS' => '127.0.0.1',
            'CLIENT-USER-AGENT' => 'User Agent',
            'CLIENT-USER-ID' => $mobile,
            'CLIENT-PLATFORM-TYPE' => 'WEB',
            'Content-Type' => 'application/json',
        ])->post('https://api.portal.sandbox.faraboom.co/v1/identity/inquiry/birthDate', [
            'national_code' => $nationalCode,
            'birth_date' => '0001-01-01T00:00:00',
            'Username' => config('services.shahkar.username'),
            'password' => config('services.shahkar.password'),
        ]);

        return $response->body();
    }
    public function verifyMobileAndNationalCode(string $mobile, string $nationalCode): array
    {
        $data = [
            'Username' => config('services.shahkar.username'),
            'password' => config('services.shahkar.password'),
            'mobile' => $mobile,
            'national_code' => $nationalCode,
        ];

        $headers = [
            'Accept-Language' => 'fa',
            'App-Key' => '14476',
            'Device-Id' => '192.168.1.1',
            'Token-Id' => 'vKJUIx32cpDmdnvtBcYvS2AtFcmGDnNrhTUalktByUPenkkdY4nn4d2Z4gUN7jGBCCW2nP3WRjzWRk3t7vZdqVHY',
            'CLIENT-DEVICE-ID' => '127.0.0.1',
            'CLIENT-IP-ADDRESS' => '127.0.0.1',
            'CLIENT-USER-AGENT' => 'User Agent',
            'CLIENT-USER-ID' => $mobile,
            'CLIENT-PLATFORM-TYPE' => 'WEB',
        ];

        $response = Http::withHeaders($headers)
            ->withoutVerifying()
            ->acceptJson()
            ->post('https://api.sandbox.faraboom.co/v1/mobile/national-code', $data);

        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json()
            ];
        }

        return [
            'success' => false,
            'error' => $response->body()
        ];
    }


}
