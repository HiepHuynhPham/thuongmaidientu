<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class VnPayService
{
    /**
     * Generate VNPAY payment URL for redirecting buyer.
     */
    public function generatePaymentUrl(array $params): string
    {
        $endpoint = env('VNPAY_ENDPOINT', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $tmnCode = env('VNPAY_TMN_CODE');
        $hashSecret = env('VNPAY_HASH_SECRET');

        $returnUrl = trim((string) env('VNPAY_RETURN_URL', route('thank')));
        $version = env('VNPAY_VERSION', '2.1.0');
        $rawLocale = env('VNPAY_LOCALE', 'vn');
        // VNPAY chỉ chấp nhận 'vn' hoặc 'en'
        $localeLower = strtolower($rawLocale);
        $locale = in_array($localeLower, ['vn', 'en']) ? $localeLower : 'vn';
        $currency = env('VNPAY_CURRENCY', 'VND');

        $amountVnd = (int) ($params['amount'] ?? 0);
        $orderId = $params['orderId'] ?? (string) time();
        // vnp_TxnRef: tạo mới cho mỗi lần thanh toán để tránh trùng lặp / timeout
        // 17 ký tự: YYYYMMDDHHMMSS + rand(3)
        $txnRef = now()->format('YmdHis') . mt_rand(100, 999);
        $orderInfo = $params['orderInfo'] ?? ("Payment for order " . $orderId);
        $ipAddr = $params['ipAddr'] ?? request()->ip();
        // Chuẩn hóa IP: nếu là IPv6 (ví dụ ::1), dùng 127.0.0.1 để tránh lỗi định dạng.
        if (strpos((string) $ipAddr, ':') !== false) {
            $ipAddr = '127.0.0.1';
        }
        $bankCode = $params['bankCode'] ?? null; // Optional for quick testing

        // Đảm bảo số tiền hợp lệ (>0) và nhân 100 theo đơn vị nhỏ nhất yêu cầu bởi VNPAY
        $amountSmallestUnit = max(0, (int) $amountVnd) * 100;

        $vnpParams = [
            'vnp_Version'   => $version,
            'vnp_Command'   => 'pay',
            'vnp_TmnCode'   => $tmnCode,
            'vnp_Amount'    => $amountSmallestUnit, // amount in smallest unit
            'vnp_CurrCode'  => $currency,
            'vnp_TxnRef'    => $txnRef,
            'vnp_OrderInfo' => $orderInfo,
            'vnp_OrderType' => 'billpayment',
            'vnp_ReturnUrl' => $returnUrl,
            'vnp_Locale'    => $locale,
            'vnp_IpAddr'    => $ipAddr,
            'vnp_CreateDate'=> now()->format('YmdHis'),
            'vnp_ExpireDate'=> now()->addMinutes(15)->format('YmdHis'),
        ];

        if (!empty($bankCode)) {
            $vnpParams['vnp_BankCode'] = $bankCode;
        }

        // Build data for hash
        ksort($vnpParams);
        $query = [];
        $hashData = '';
        foreach ($vnpParams as $key => $value) {
            $query[] = urlencode($key) . '=' . urlencode((string)$value);
            $hashData .= ($hashData ? '&' : '') . $key . '=' . $value;
        }

        $secureHash = hash_hmac('sha512', $hashData, (string)$hashSecret);
        $paymentUrl = $endpoint . '?' . implode('&', $query) . '&vnp_SecureHash=' . $secureHash;

        // Ghi log debug tham số gửi đi (ẩn secure hash) nếu bật VNPAY_DEBUG=true
        if (env('VNPAY_DEBUG', false)) {
            Log::info('VNPAY Request Params', [
                'params' => $vnpParams,
                'endpoint' => $endpoint,
                'payment_url' => $paymentUrl,
                'signed' => true,
            ]);
        }

        return $paymentUrl;
    }

    /**
     * Validate VNPAY return parameters integrity via vnp_SecureHash.
     */
    public function validateReturn(array $query): bool
    {
        $hashSecret = env('VNPAY_HASH_SECRET');

        if (!isset($query['vnp_SecureHash'])) {
            return false;
        }
        $receivedHash = $query['vnp_SecureHash'];

        // Remove hash before building data
        $data = $query;
        unset($data['vnp_SecureHash']);
        unset($data['vnp_SecureHashType']);

        ksort($data);
        $hashData = '';
        foreach ($data as $key => $value) {
            $hashData .= ($hashData ? '&' : '') . $key . '=' . $value;
        }

        $calcHash = hash_hmac('sha512', $hashData, (string)$hashSecret);
        return hash_equals($calcHash, $receivedHash);
    }
}