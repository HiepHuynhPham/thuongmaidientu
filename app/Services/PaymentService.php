<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class PaymentService
{
    public function createPayment($paymentRequest)
{
    $url = 'https://test-payment.momo.vn/v2/gateway/api/create';

    // $partnerCode = env('MOMO');
    // $accessKey = env('F8BBA842ECF85');
    // $secretKey = env('MOMO_SECRET_KEY');
    $partnerCode = 'MOMO';
    $accessKey = 'F8BBA842ECF85';
    $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
    $requestType = 'payWithMethod';

    // Khởi tạo các biến
    $orderId = $paymentRequest['orderId'];
    $orderInfo = $paymentRequest['orderInfo'];
    $amount = $paymentRequest['amount'];
    $extraData = $paymentRequest['extraData'];
    $requestId = $paymentRequest['requestId'];
    // $redirectUrl = env('MOMO_REDIRECT_URL');
    // $ipnUrl = env('MOMO_IPN_URL');
    $redirectUrl = 'http://localhost:8000/thank';  // Hoặc lấy từ .env
    $ipnUrl = 'https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b'; // Hoặc lấy từ .env

    // Chuỗi để tạo chữ ký
    $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = [
        'partnerCode' => $partnerCode,
        'accessKey' => $accessKey,
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature,
        'lang' => 'vi',
    ];

    $client = new Client();
    $response = $client->post($url, [
        'headers' => ['Content-Type' => 'application/json'],
        'body' => json_encode($data),
    ]);

    return $response->getBody()->getContents();
}


public function queryTransactionStatus($orderId, $requestId)
{
    $url = 'https://test-payment.momo.vn/v2/gateway/api/query';

    // $partnerCode = env('MOMO_PARTNER_CODE');
    // $accessKey = env('MOMO_ACCESS_KEY');
    // $secretKey = env('MOMO_SECRET_KEY');

    $partnerCode = 'MOMO';
    $accessKey = 'F8BBA842ECF85';
    $secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';

    // Tạo chữ ký
    $rawHash = "accessKey=$accessKey&orderId=$orderId&partnerCode=$partnerCode&requestId=$requestId";
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = [
        'partnerCode' => $partnerCode,
        'accessKey' => $accessKey,
        'requestId' => $requestId,
        'orderId' => $orderId,
        'signature' => $signature,
        'lang' => 'vi',
    ];

    // Gửi yêu cầu truy vấn giao dịch đến MoMo
    $response = Http::post($url, $data);

    return $response->body();
}

}