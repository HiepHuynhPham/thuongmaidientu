<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class VNPayController extends Controller
{
    public function createPayment(Request $request)
    {
        $vnpUrl        = env('VNPAY_ENDPOINT', env('VNP_URL'));
        $vnpReturnUrl  = env('VNPAY_RETURN_URL', env('VNP_RETURN_URL'));
        $vnpIpnUrl     = env('VNPAY_IPN_URL', env('VNP_IPN_URL'));
        $vnpTmnCode    = env('VNPAY_TMN_CODE', env('VNP_TMN_CODE'));
        $vnpHashSecret = env('VNPAY_HASH_SECRET', env('VNP_HASH_SECRET'));

        // Amount
        $amount = (int) $request->input('amount', 0);
        if ($amount <= 0) {
            $userId = Session::get('user_id');
            if ($userId) {
                try {
                    $cartService = app(\App\Services\CartService::class);
                    $cartData = $cartService->fetchCartByUser($userId);
                    $amount = (int) ($cartData['totalPrice'] ?? 0);
                } catch (\Throwable $e) {
                    $amount = 0;
                }
            }
        }
        if ($amount <= 0) abort(400, 'Invalid amount');

        $vnpTxnRef     = time(); 
        $vnpOrderInfo  = "Thanh toan don hang " . $vnpTxnRef;
        $vnpOrderType  = "other";
        $vnpAmount     = $amount * 100;
        $vnpLocale     = "vn";
        $vnpIpAddr     = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_Command" => "pay",
            "vnp_TmnCode" => $vnpTmnCode,
            "vnp_Amount" => $vnpAmount,
            "vnp_CurrCode" => "VND",
            "vnp_TxnRef" => $vnpTxnRef,
            "vnp_OrderInfo" => $vnpOrderInfo,
            "vnp_OrderType" => $vnpOrderType,
            "vnp_ReturnUrl" => $vnpReturnUrl,
            "vnp_IpAddr" => $vnpIpAddr,
            "vnp_CreateDate" => date("YmdHis"),
        ];


        ksort($inputData);

        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= $key . "=" . $value . "&";
        }
        $hashData = rtrim($hashData, "&");

        $query = http_build_query($inputData);

        $vnpSecureHash = hash_hmac("sha512", $hashData, $vnpHashSecret);

        $paymentUrl = $vnpUrl . "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

        return redirect()->away($paymentUrl);
    }

    public function paymentReturn(Request $request)
    {
        if ($request->vnp_ResponseCode == "00") {
            return view("payments.success")->with("transaction", $request->all());
        }
        return view("payments.fail")->with("transaction", $request->all());
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
