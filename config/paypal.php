<?php

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'),

    'sandbox' => [
        // Fallback to generic env names if sandbox-specific ones are not set
        'client_id'     => env('PAYPAL_SANDBOX_CLIENT_ID', env('PAYPAL_CLIENT_ID', '')),
        'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET', env('PAYPAL_SECRET', '')),
        'app_id'        => env('PAYPAL_SANDBOX_APP_ID', 'APP-80W284485P519543T'),
    ],

    'live' => [
        // Fallback to generic env names if live-specific ones are not set
        'client_id'     => env('PAYPAL_LIVE_CLIENT_ID', env('PAYPAL_CLIENT_ID', '')),
        'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET', env('PAYPAL_SECRET', '')),
        'app_id'        => env('PAYPAL_LIVE_APP_ID', ''),
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'vnd_to_usd_rate' => env('PAYPAL_VND_TO_USD_RATE', 24000),
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''),
    'locale'         => env('PAYPAL_LOCALE', 'en_US'),
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),
];

