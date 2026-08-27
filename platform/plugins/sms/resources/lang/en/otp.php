<?php

return [
    'settings' => [
        'description' => 'Configure OTP expiration time and phone verification requirements.',
        'form' => [
            'setup_guard_alert' => 'Please select a guard and save the settings before you can configure the OTP settings.',
            'guard' => 'Guard',
            'guard_help' => 'The guard that will be used for OTP verification.',
            'expires_in' => 'OTP Code Expire Time',
            'expires_in_help' => 'The time in minutes that the OTP code will expire. Default is 5 minutes.',
            'phone_verification' => 'Enable phone verification',
            'requires_phone_verification' => 'Require phone verification',
            'requires_phone_verification_help' => 'If enabled, users must verify their phone number before they can use the system.',
            'message' => 'OTP Message',
            'message_help' => 'The message that will be sent to the user. Use {code} to insert the OTP code.',
            'your_OTP_code_is'=>'Your OTP code is:code',
            "bodyidmessage"=>'Body id',
            'bodymessage_help' => 'The Body id that will be sent to the admin. Use to sent OTP code based on the SMS service pattern.',
        ],
    ],
    'enter_code' => 'Please enter the OTP code sent to :identifier.',
    'code_expiry' => 'The OTP code will expire in :time.',
    'did_not_receive_otp' => 'Did not receive the OTP?',
    'resend_otp' => 'Resend OTP',
    'otp_sent' => 'OTP code has been sent to your phone number.',
    'verify' => 'Verify',
    'back'=>'back'
];
