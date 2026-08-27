<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use FriendsOfBotble\Sms\Facades\Sms;

class RemoteSmsService
{
    public function handle(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
            'secret' => 'required|string',
        ]);

        if ($request->secret !== env('REMOTE_SMS_SECRET')) {
            return Response::json(['message' => 'Unauthorized'], 401);
        }

        Sms::send($request->phone, $request->message);
        return Response::json(['message' => 'SMS sent successfully']);
    }
}
