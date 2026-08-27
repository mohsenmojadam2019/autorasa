<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use SoapClient;
use SoapFault;

class SubmitRetailService
{
    protected $wsdl = "https://pub-cix.ntsw.ir/services/InternalTradeServices?wsdl";

    public function sendRetailDocument(array $data): array
    {
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
                'username'           => config('services.tejarat.username'),
                'srvPass'            => config('services.tejarat.password'),
                'password_otpCode'   => $data['password_otpCode'],
                'PersonNationalID'   => $data['PersonNationalID']??4540092669,
                'UserRoleIDstr'      => $data['UserRoleIDstr'] ?? '',
                'UserRoleExtraFields' => $data['UserRoleExtraFields'] ?? [],
                'DocumentDate'       => $data['DocumentDate']??now()->format('Y-m-d'),
                'Description'        => $data['Description'] ?? '',
                'BuyerDatiles'       => $data['BuyerDatiles'],
                'PostalCode'         => $data['PostalCode'],
                'Stuffs_In'          => $data['Stuffs_In'],
                'DocNumber'          => $data['DocNumber'] ?? '',
                'statusAppointment'  => $data['statusAppointment'] ?? 0,
            ];

            // اگر تایر هست، اطلاعات اضافه شود
            if (!empty($data['tireCustomerInfo'])) {
                $params['tireCustomerInfo'] = $data['tireCustomerInfo'];
            }

            if (!empty($data['TraceCode'])) {
                $params['TraceCode'] = $data['TraceCode'];
            }

            $response = $client->__soapCall('SubmitRetail', [$params]);

            return [
                'success' => true,
                'result'  => $response,
            ];

        } catch (SoapFault $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }


}

