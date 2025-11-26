<?php

namespace App\Services;

use App\Models\VnPaymentRequestModel;
use App\Models\VnPaymentResponseModel;
use Illuminate\Http\Request;

class VnPayService
{
    public function createPaymentUrl(Request $request, VnPaymentRequestModel $model): string
    {
        $vnpUrl = config('vnpay.endpoint');
        $vnpReturnUrl = config('vnpay.return_url');
        $vnpTmnCode = config('vnpay.tmn_code');
        $vnpHashSecret = config('vnpay.hash_secret');

        $params = [
            'vnp_Version' => config('vnpay.version'),
            'vnp_Command' => 'pay',
            'vnp_TmnCode' => $vnpTmnCode,
            'vnp_Amount' => $model->amount * 100,
            'vnp_CurrCode' => config('vnpay.currency'),
            'vnp_TxnRef' => (string) $model->orderId,
            'vnp_OrderInfo' => $model->description,
            'vnp_OrderType' => 'other',
            'vnp_Locale' => config('vnpay.locale'),
            'vnp_ReturnUrl' => $vnpReturnUrl,
            'vnp_IpAddr' => $request->ip(),
            'vnp_CreateDate' => $model->createdDate->format('YmdHis'),
        ];

        ksort($params);
        $query = http_build_query($params);
        $secureHash = hash_hmac('sha512', $query, $vnpHashSecret);
        return $vnpUrl . '?' . $query . '&vnp_SecureHash=' . $secureHash;
    }

    public function paymentExecute($query): ?VnPaymentResponseModel
    {
        $vnpHashSecret = config('vnpay.hash_secret');
        $params = [];
        foreach ($query as $k => $v) {
            $params[$k] = is_array($v) ? (string) reset($v) : (string) $v;
        }
        $receivedHash = $params['vnp_SecureHash'] ?? '';
        unset($params['vnp_SecureHash'], $params['vnp_SecureHashType']);
        if (empty($params)) {
            return null;
        }
        ksort($params);
        $hashData = http_build_query($params);
        $calcHash = hash_hmac('sha512', $hashData, $vnpHashSecret);
        $valid = hash_equals($calcHash, $receivedHash);
        $res = new VnPaymentResponseModel();
        $res->success = $valid;
        $res->vnp_TxnRef = $params['vnp_TxnRef'] ?? null;
        $res->vnp_TransactionNo = $params['vnp_TransactionNo'] ?? null;
        $res->vnp_ResponseCode = $params['vnp_ResponseCode'] ?? null;
        $res->message = $valid ? 'OK' : 'INVALID_CHECKSUM';
        return $res;
    }
}

