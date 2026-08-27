<?php

return [
    'name' => 'SMS Gateways',
    'Your_password_changed_successfully'=>'Your password changed successfully',
    'settings' => [
        'title' => 'SMS',
        'description' => 'Configure the settings for sending SMS messages.',
        'form' => [
            'default_sms_provider' => 'Default SMS Provider',
            'default_sms_provider_help' => 'This is the default SMS provider that will be used to send SMS messages.',
        ],
    ],
    'configure_button' => 'Configure',
    'save_button' => 'Save',
    'activate_button' => 'Activate',
    'deactivate_button' => 'Deactivate',
    'test_button' => 'Send Test SMS',
    'test_modal' => [
        'title' => 'Send Test SMS',
        'description' => 'Enter message details to send a test SMS message.',
        'to' => 'Send To',
        'to_placeholder' => 'Enter the phone number to send the test SMS message to.',
        'message' => 'Message',
    ],
    'gateway_description' => 'Send SMS messages using :name.',
    'send_sms_failed' => 'An error occurred while sending the SMS message. Consider checking the response in SMS Logs section.',
    'sms_sent' => 'The SMS message has been sent successfully.',

    'enums' => [
        'log_statuses' => [
            'pending' => 'Pending',
            'success' => 'Success',
            'failed' => 'Failed',
        ],
    ],

    'logs' => [
        'title' => 'SMS Logs',
        'detail_title' => 'SMS Log #:id',
        'id' => 'ID',
        'message_id' => 'Message ID',
        'provider' => 'Provider',
        'from' => 'From',
        'to' => 'To',
        'message' => 'Message',
        'status' => 'Status',
        'sent_at' => 'Sent At',
        'response' => 'Response',
    ],
    'phone_number_verification'=>'Phone Number Verification',
    'your_OTP_is_invalid_or_expired'=>'Your OTP is invalid or expired.',
    'Your_phone_number_has_been_verified_successfully'=>'Your phone number has been verified successfully.',
    'phone_number_login'=>'Login by phone number',
    'forgot_password'=>'Forgot Password',
    'Your_logedin_successfully'=>'You are loged in successfully',
    'The :attribute has already been verified.'=>'The :attribute has already been verified.'

];
