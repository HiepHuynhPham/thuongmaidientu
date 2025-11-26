<?php

return [
    'tmn_code' => env('VNPAY_TMN_CODE', ''),
    'hash_secret' => env('VNPAY_HASH_SECRET', ''),
    'endpoint' => env('VNPAY_ENDPOINT', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'return_url' => env('VNPAY_RETURN_URL', env('APP_URL') . '/payment/vnpay/return'),
    'ipn_url' => env('VNPAY_IPN_URL', env('APP_URL') . '/payment/vnpay/ipn'),
    'version' => env('VNPAY_VERSION', '2.1.0'),
    'locale' => env('VNPAY_LOCALE', 'vn'),
    'currency' => env('VNPAY_CURRENCY', 'VND'),
    'debug' => env('VNPAY_DEBUG', false),
];

