<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VNPayController extends Controller
{
    public function createPayment(Request $request)
    {
        // CHỈ DÙNG BỘ ENV CHUẨN – KHÔNG DÙNG VNPAY_*
        $vnpUrl        = env('VNP_URL');
        $vnpReturnUrl  = env('VNP_RETURN_URL');
        $vnpTmnCode    = env('VNP_TMN_CODE');
        $vnpHashSecret = env('VNP_HASH_SECRET');

        // Amount
        $amount = (int) $request->input('amount', 0);
        if ($amount <= 0) abort(400, 'Invalid amount');

        $vnpTxnRef     = time();
        $vnpOrderInfo  = "Thanh toán đơn hàng #" . $vnpTxnRef;
        $vnpOrderType  = "billpayment";
        $vnpAmount     = $amount * 100; // nhân đúng theo quy định
        $vnpLocale     = "vn";
        $vnpIpAddr     = $request->ip();

        $inputData = [
            "vnp_Version"   => "2.1.0",
            "vnp_Command"   => "pay",
            "vnp_TmnCode"   => $vnpTmnCode,
            "vnp_Amount"    => $vnpAmount,
            "vnp_CurrCode"  => "VND",
            "vnp_TxnRef"    => $vnpTxnRef,
            "vnp_OrderInfo" => $vnpOrderInfo,
            "vnp_OrderType" => $vnpOrderType,
            "vnp_ReturnUrl" => $vnpReturnUrl,
            "vnp_IpAddr"    => $vnpIpAddr,
            "vnp_CreateDate"=> date('YmdHis'),
        ];

        // BẮT BUỘC: KHÔNG ĐƯỢC THÊM vnp_IpnUrl!!! VNPay không hỗ trợ
        // IPN URL CHỈ ĐƯỢC CẤU HÌNH TRONG MERCHANT SYSTEM

        ksort($inputData);

        $hashData = '';
        $query = '';

        foreach ($inputData as $key => $value) {
            $hashData .= $key . "=" . $value . "&";
            $query    .= urlencode($key) . "=" . urlencode($value) . "&";
        }

        $hashData = rtrim($hashData, "&");
        $query    = rtrim($query, "&");

        $vnpSecureHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        $paymentUrl = $vnpUrl . "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

        return redirect()->away($paymentUrl);
    }

    public function paymentReturn(Request $request)
    {
        if ($request->vnp_ResponseCode == "00") {
            return view("payments.success", ["transaction" => $request->all()]);
        }
        return view("payments.fail", ["transaction" => $request->all()]);
    }

    public function ipnCallback(Request $request)
    {
        $vnpHashSecret = env("VNP_HASH_SECRET");

        $inputData = $request->all();

        if (!isset($inputData["vnp_SecureHash"])) {
            return response()->json(["RspCode" => "97", "Message" => "Missing signature"]);
        }

        $vnpSecureHash = $inputData["vnp_SecureHash"];
        unset($inputData["vnp_SecureHash"], $inputData["vnp_SecureHashType"]);

        ksort($inputData);

        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= $key . "=" . $value . "&";
        }
        $hashData = rtrim($hashData, "&");

        $secureHash = hash_hmac("sha512", $hashData, $vnpHashSecret);

        if ($secureHash !== $vnpSecureHash) {
            return response()->json(["RspCode" => "97", "Message" => "Checksum failed"]);
        }

        if ($request->vnp_ResponseCode == "00") {
            return response()->json(["RspCode" => "00", "Message" => "Success"]);
        }

        return response()->json(["RspCode" => "01", "Message" => "Payment failed"]);
    }
}
