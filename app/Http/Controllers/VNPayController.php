<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VNPayController extends Controller
{
    /**
     * Redirect user to VNPay payment page.
     */
    public function createPayment(Request $request)
    {
        $vnpUrl        = env('VNPAY_ENDPOINT', env('VNP_URL'));
        $vnpReturnUrl  = env('VNPAY_RETURN_URL', env('VNP_RETURN_URL'));
        $vnpIpnUrl     = env('VNPAY_IPN_URL', env('VNP_IPN_URL'));
        $vnpTmnCode    = env('VNPAY_TMN_CODE', env('VNP_TMN_CODE'));
        $vnpHashSecret = env('VNPAY_HASH_SECRET', env('VNP_HASH_SECRET'));

        // amount is expected in VND, integer
        $amount = (int) $request->input('amount', 0);
        if ($amount <= 0) {
            abort(400, 'Invalid amount for VNPay payment');
        }

        $vnpTxnRef    = time(); // TODO: replace with the local order_id to link the gateway txn to your order
        $vnpOrderInfo = 'Thanh toán đơn hàng #' . $vnpTxnRef;
        $vnpOrderType = 'billpayment';
        $vnpAmount    = $amount * 100; // VNPay amount = VND * 100
        $vnpLocale    = 'vn';
        $vnpIpAddr    = $request->ip();

        $inputData = [
            'vnp_Version'   => '2.1.0',
            'vnp_Command'   => 'pay',
            'vnp_TmnCode'   => $vnpTmnCode,
            'vnp_Amount'    => $vnpAmount,
            'vnp_CurrCode'  => 'VND',
            'vnp_TxnRef'    => $vnpTxnRef,
            'vnp_OrderInfo' => $vnpOrderInfo,
            'vnp_OrderType' => $vnpOrderType,
            'vnp_ReturnUrl' => $vnpReturnUrl,
            'vnp_IpAddr'    => $vnpIpAddr,
            'vnp_CreateDate'=> date('YmdHis'),
        ];

        if ($vnpIpnUrl) {
            $inputData['vnp_IpnUrl'] = $vnpIpnUrl;
        }

        ksort($inputData);

        $query    = '';
        $hashData = '';

        foreach ($inputData as $key => $value) {
            $query    .= urlencode($key) . '=' . urlencode($value) . '&';
            $hashData .= $key . '=' . $value . '&';
        }

        $query    = rtrim($query, '&');
        $hashData = rtrim($hashData, '&');

        $vnpSecureHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        $paymentUrl = $vnpUrl . '?' . $query . '&vnp_SecureHash=' . $vnpSecureHash;

        return redirect()->away($paymentUrl);
    }

    /**
     * User browser is redirected back here after payment.
     */
    public function paymentReturn(Request $request)
    {
        $vnpResponseCode = $request->input('vnp_ResponseCode');

        // TODO: optionally verify checksum again and update local order status by vnp_TxnRef
        if ($vnpResponseCode === '00') {
            return view('payments.success', [
                'transaction' => $request->all(),
            ]);
        }

        return view('payments.fail', [
            'transaction' => $request->all(),
        ]);
    }

    /**
     * IPN callback from VNPay (server-to-server notification).
     */
    public function ipnCallback(Request $request)
    {
        $vnpHashSecret = env('VNPAY_HASH_SECRET', env('VNP_HASH_SECRET'));

        $inputData = $request->all();

        if (!isset($inputData['vnp_SecureHash'])) {
            return response()->json(['RspCode' => '97', 'Message' => 'Missing signature'], 400);
        }

        $vnpSecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        ksort($inputData);

        $hashData = '';
        foreach ($inputData as $key => $value) {
            $hashData .= $key . '=' . $value . '&';
        }
        $hashData = rtrim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        if ($secureHash !== $vnpSecureHash) {
            Log::warning('VNPay IPN checksum failed', $request->all());
            return response()->json(['RspCode' => '97', 'Message' => 'Checksum failed'], 400);
        }

        Log::info('VNPay IPN received', $request->all());

        $responseCode = $request->input('vnp_ResponseCode');
        $txnRef       = $request->input('vnp_TxnRef');

        // TODO: update local order status by $txnRef based on $responseCode (00 = success)

        if ($responseCode === '00') {
            return response()->json(['RspCode' => '00', 'Message' => 'Success']);
        }

        return response()->json(['RspCode' => '01', 'Message' => 'Payment failed']);
    }
}
