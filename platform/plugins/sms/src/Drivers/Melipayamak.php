<?php

namespace FriendsOfBotble\Sms\Drivers;

use Botble\Base\Forms\FormAbstract;
use FriendsOfBotble\Sms\DataTransferObjects\SmsResponse;
use FriendsOfBotble\Sms\Facades\Sms;
use FriendsOfBotble\Sms\Forms\MelipayamakGatewayForm;
use Melipayamak\MelipayamakApi;

class Melipayamak extends AbstractDriver
{
    protected MelipayamakApi $client;

    public function __construct()
    {
        $username = Sms::getSetting('username', 'melipayamak');
        $password = Sms::getSetting('password', 'melipayamak');

        if (empty($username) || empty($password)) {
            return;
        }

        $this->client = new MelipayamakApi($username, $password);
    }

    protected function performSend(string $to, string $message,$body_id=null): SmsResponse
    {
        if (! isset($this->client)) {
            return new SmsResponse(success: false);
        }
        if ($body_id!=null){
//            dd($to,  $message,$body_id);
//dd(1);
            $response=$this->sendOtpByConsole($to,$body_id, $message);
//            dd($response);
            $status=json_decode($response)->status=="ارسال موفق بود"?true:false;
//            dd($status,json_decode($response)->status,[json_decode($response)->recId[0]]);
            return new SmsResponse(
                success: $status,
                messageId: json_decode($response)->status,
                response: $status?["ok"]:[json_decode($response)->recId[0]],
            );
            return new SmsResponse(
                success: $status,
                messageId: json_decode($response)->status,
                response: [json_decode($response)->recId[0]],
            );
        }else{
            $sms=$this->client->sms();
            $response = $sms->send($to,
                $this->getFrom(),
                $message
            );
        }
//        dd(new SmsResponse(
//            success: ! empty(json_decode($response)->Value),
//            messageId: json_decode($response)->RetStatus,
//            response: [json_decode($response)->StrRetStatus],
//        ));
        return new SmsResponse(
            success: ! empty(json_decode($response)->Value),
            messageId: json_decode($response)->RetStatus,
            response: [json_decode($response)->StrRetStatus],
        );
    }

    public function sendOtpByConsole($to, $body_id,$message)
    {
//        dd($to, $body_id,$message);
        $url = 'https://console.melipayamak.com/api/send/shared/3bc90360d1fd4c0bbe390e3be366d93c';
        $data = array('bodyId' => $body_id, 'to' => $to, 'args' => [$message]);
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

// Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Use it when you have trouble installing local issuer certificate
// See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        curl_close($ch);
//        dd($result);
        return $result;
    }
//inja
//    public function normalizePhoneNumber(string $phone): string
//    {
//        if (! isset($this->client)) {
//            return new Exception('melipayamak is not setup yet. Please setup credentials first.');
//        }
//
//        try {
//            $phoneNumber = $this->client->lookups->v2->phoneNumbers($phone)->fetch();
//
//            return $phoneNumber->phoneNumber;
//        } catch (Exception $e) {
//            BaseHelper::logError($e);
//
//            return $phone;
//        }
//    }

    public function getLogo(): string
    {
        return asset('vendor/core/plugins/sms/images/melipayamak.svg');
    }

    public function getInstructions(): string
    {
        return view('plugins/sms::instructions.melipayamak');
    }

    public function getSettingForm(): FormAbstract
    {
        return MelipayamakGatewayForm::create();
    }
}
