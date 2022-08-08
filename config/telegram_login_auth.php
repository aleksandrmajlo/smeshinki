<?php

return [
//    'token' => env('TELEGRAM_LOGIN_AUTH_TOKEN', ''),
    'token' => env('TELEGRAM_LOGIN_AUTH_TOKEN', '5434944143:AAF5WtGl4LmrBXhWi1vKj4UfC2Kt5__xS2E'),
    'validate' => [
        'signature' => env('TELEGRAM_LOGIN_AUTH_VALIDATE_SIGNATURE', true),
        'response_outdated' => env('TELEGRAM_LOGIN_AUTH_VALIDATE_RESPONSE_OUTDATED', true),
    ],
];
