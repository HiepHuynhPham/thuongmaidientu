<?php

namespace App\Services;

use App\Models\VnPaymentRequestModel;
use App\Models\VnPaymentResponseModel;
use Illuminate\Http\Request;

class VnPayService
{
    public function createPaymentUrl(Request $request, VnPaymentRequestModel $model): string
    {
        $vnpUrl        = config('vnpay.endpoint');
        $vnpReturnUrl  = config('vnpay.return_url');
        $vnpTmnCode    = config('vnpay.tmn_code');
        $vnpHashSecret = config('vnpay.hash_secret');

        // Không có IpnUrl trong URL gửi đi
        $params = [
            'vnp_Version'    => config('vnpay.version'),
            'vnp_Command'    => 'pay',
            'vnp_TmnCode'    => $vnpTmnCode,
            'vnp_Amount'     => $model->amount * 100,
            'vnp_CurrCode'   => 'VND',
            'vnp_TxnRef'     => $model->orderId,
            'vnp_OrderInfo'  => $model->description,
            'vnp_OrderType'  => 'other',
            'vnp_ReturnUrl'  => $vnpReturnUrl,
            'vnp_Locale'     => 'vn',
            'vnp_IpAddr'     => $request->ip(),
            'vnp_CreateDate' => $model->createdDate->format('YmdHis'),
        ];

        // Sort tên tham số
        ksort($params);

        // Build phần hashData đúng chuẩn
        $hashData = '';
        foreach ($params as $key => $value) {
            $hashData .= $key . '=' . $value . '&';
        }
        $hashData = rtrim($hashData, '&');

        // Tạo secureHash chuẩn
        $vnpSecureHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        // Build query cho URL redirect
        $query = http_build_query($params);

        return $vnpUrl . '?' . $query . '&vnp_SecureHash=' . $vnpSecureHash;
    }


    public function paymentExecute($query): ?VnPaymentResponseModel
    {
        $vnpHashSecret = config('vnpay.hash_secret');

        $params = [];
        foreach ($query as $key => $value) {
            if (str_starts_with($key, 'vnp_')) {
                $params[$key] = $value;
            }
        }

        if (!isset($params['vnp_SecureHash'])) {
            return null;
        }

        $receivedHash = $params['vnp_SecureHash'];
        unset($params['vnp_SecureHash'], $params['vnp_SecureHashType']);

        ksort($params);

        // Build hashData chuẩn
        $hashData = '';
        foreach ($params as $key => $value) {
            $hashData .= $key . '=' . $value . '&';
        }
        $hashData = rtrim($hashData, '&');

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
