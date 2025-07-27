<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'khalti' => [
        'public_key' => env('KHALTI_PUBLIC_KEY'),
        'test_public_key' => env('KHALTI_TEST_PUBLIC_KEY'),
        'secret_key' => env('KHALTI_SECRET_KEY'),
        'test_secret_key' => env('KHALTI_TEST_SECRET_KEY'),
        'merchant_code' => env('KHALTI_MERCHANT_CODE'),
        // 'base_url' => env('KHALTI_BASE_URL', 'https://dev.khalti.com/api/v2/'),
        'base_url' => env('KHALTI_BASE_URL'),
        'test_base_url' => env('KHALTI_TEST_BASE_URL'),

    ],
];
