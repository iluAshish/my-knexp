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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // 'smsglobal' => [
    //     'user' => env('SMSGLOBAL_API_USER'),
    //     'password' => env('SMSGLOBAL_API_PASSWORD'),
    //     'origin' => env('SMSGLOBAL_API_ORIGIN'),
    //     'api_url' => env('SMSGLOBAL_API_URL'),
    // ],
    'smsala' => [
        'api_id' => env('SMSAALA_API_ID'),
        'api_password' => env('SMSAALA_API_PASSWORD'),
        'sender_id' => env('SMSAALA_SENDER_ID'),
    ],

];
