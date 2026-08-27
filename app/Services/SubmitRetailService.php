<?php

namespace App\Services;

use SoapClient;
use Throwable;

class SubmitRetailService
{
    protected $wsdl = 'https://pub-cix.ntsw.ir/services/InternalTradeServices?wsdl';

    public function sendRetailDocument(array $data): array
    {
        $required = [
            'password_otpCode',
            'PersonNationalID',
            'BuyerDatiles',
            'PostalCode',
            'Stuffs_In',
        ];

        foreach ($required as $key) {
            if (! array_key_exists($key, $data) || $data[$key] === '' || $data[$key] === null) {
                return [
                    'success' => false,
                    'error' => "Missing required field: {$key}",
                ];
            }
        }

        try {
            $client = new SoapClient($this->wsdl, [
                'trace' => true,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'exceptions' => true,
                'stream_context' => stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ]),
            ]);

            $params = [
                'username' => config('services.tejarat.username'),
                'srvPass' => config('services.tejarat.password'),
                'password_otpCode' => $data['password_otpCode'],
                'PersonNationalID' => $data['PersonNationalID'],
                'UserRoleIDstr' => $data['UserRoleIDstr'] ?? '',
                'UserRoleExtraFields' => $data['UserRoleExtraFields'] ?? [],
                'DocumentDate' => $data['DocumentDate'] ?? now()->format('Y-m-d'),
                'Description' => $data['Description'] ?? '',
                'BuyerDatiles' => $data['BuyerDatiles'],
                'PostalCode' => $data['PostalCode'],
                'Stuffs_In' => $data['Stuffs_In'],
                'DocNumber' => $data['DocNumber'] ?? '',
                'statusAppointment' => $data['statusAppointment'] ?? 0,
            ];

            if (! empty($data['tireCustomerInfo'])) {
                $params['tireCustomerInfo'] = $data['tireCustomerInfo'];
            }

            if (! empty($data['TraceCode'])) {
                $params['TraceCode'] = $data['TraceCode'];
            }

            $response = $client->__soapCall('SubmitRetail', [$params]);

            return [
                'success' => true,
                'result' => $response,
            ];
        } catch (Throwable $e) {
            report($e);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
