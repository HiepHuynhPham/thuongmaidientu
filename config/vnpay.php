<?php

return [
    'version'    => env('VNP_VERSION', '2.1.0'),
    'tmn_code'   => env('VNP_TMN_CODE'),
    'hash_secret'=> env('VNP_HASH_SECRET'),
    'endpoint'   => env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'return_url' => env('VNP_RETURN_URL', env('APP_URL') . '/payment/vnpay/return'),
    'locale'     => env('VNP_LOCALE', 'vn'),
    'currency'   => env('VNP_CURR_CODE', 'VND'),
];
