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

    'facebook' => [
        'client_id' => '579483333633999', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'client_secret' => 'e0f93b2bb7c9a5799ae827131ccda886', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'redirect' => 'https://smeshinki.net/facebook/callback/'
    ],

    'instagram' => [
        'client_id' => env('INSTAGRAM_CLIENT_ID'),
        'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT_URI')
    ],

    'telegram' => [
        'bot' => 'smeshinki_login_bot',  // The bot's username
        'client_id' => null,
        'client_secret' => '5434944143:AAF5WtGl4LmrBXhWi1vKj4UfC2Kt5__xS2E',
        'redirect' => 'https://smeshinki.net/telegram/callback',
    ],

    'google' => [
        'client_id' => '536694418508-lboi6usjrcg61dr8p9gt5jusp2hiqqva.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://smeshinki.net/google/callback',
    ],


];
