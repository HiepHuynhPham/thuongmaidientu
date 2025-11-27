<?php

namespace App\Services;

use App\Models\VnPaymentRequestModel;
use App\Models\VnPaymentResponseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VnPayService
{
    private function cleanAscii(string $str): string
    {
        $converted = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
        if ($converted === false || $converted === null) {
            $converted = $str;
        }
        return preg_replace('/[^A-Za-z0-9 ]/', '', $converted) ?? '';
    }

    private function getClientIp(Request $request): string
    {
        $xff = $request->server('HTTP_X_FORWARDED_FOR');
        if ($xff) {
            $parts = explode(',', $xff);
            return trim($parts[0]);
        }
        return $request->ip() ?? '127.0.0.1';
    }
    public function createPaymentUrl(Request $request, VnPaymentRequestModel $model): string
    {
        $vnpUrl        = config('vnpay.endpoint');
        $vnpReturnUrl  = config('vnpay.return_url');
        $vnpTmnCode    = config('vnpay.tmn_code');
        $vnpHashSecret = config('vnpay.hash_secret');

        // Không có IpnUrl trong URL gửi đi
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $orderInfo = $this->cleanAscii($model->description ?? ('Thanh toan don hang ' . $model->orderId));
        $expire = date('YmdHis', time() + 900);

        $params = [
            'vnp_Version'    => config('vnpay.version'),
            'vnp_Command'    => 'pay',
            'vnp_TmnCode'    => $vnpTmnCode,
            'vnp_Amount'     => $model->amount * 100,
            'vnp_CurrCode'   => 'VND',
            'vnp_TxnRef'     => $model->orderId,
            'vnp_OrderInfo'  => $orderInfo,
            'vnp_OrderType'  => 'other',
            'vnp_ReturnUrl'  => $vnpReturnUrl,
            'vnp_Locale'     => 'vn',
            'vnp_IpAddr'     => $this->getClientIp($request),
            'vnp_CreateDate' => $model->createdDate->format('YmdHis'),
            'vnp_ExpireDate' => $expire,
        ];

        // Sort và build hashData + query theo đúng encoding VNPay
        ksort($params);
        $i = 0;
        $hashData = '';
        $query = '';
        foreach ($params as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashData, trim((string)$vnpHashSecret));
        Log::info('VNPay create', [
            'vnp_TxnRef' => $model->orderId,
            'vnp_Amount' => $model->amount * 100,
            'hashData' => $hashData,
            'secureHash' => $vnpSecureHash,
            'tmn' => $vnpTmnCode,
        ]);
        return $vnpUrl . '?' . $query . 'vnp_SecureHash=' . $vnpSecureHash;
    }

    private function cleanUnicode($str) { return $this->cleanAscii($str); }


    public function paymentExecute($query): ?VnPaymentResponseModel
    {
        $vnpHashSecret = trim((string) config('vnpay.hash_secret'));

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

        $i = 0;
        $hashData = '';
        foreach ($params as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $calcHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        $valid = hash_equals($calcHash, $receivedHash);

        Log::info('VNPay verify', [
            'vnp_TxnRef' => $params['vnp_TxnRef'] ?? null,
            'vnp_Amount' => $params['vnp_Amount'] ?? null,
            'hashData' => $hashData,
            'receivedHash' => $receivedHash,
            'calculatedHash' => $calcHash,
            'valid' => $valid,
        ]);
        $res = new VnPaymentResponseModel();
        $res->success = $valid;
        $res->vnp_TxnRef = $params['vnp_TxnRef'] ?? null;
        $res->vnp_TransactionNo = $params['vnp_TransactionNo'] ?? null;
        $res->vnp_ResponseCode = $params['vnp_ResponseCode'] ?? null;
        $res->message = $valid ? 'OK' : 'INVALID_CHECKSUM';

        return $res;
    }
}
