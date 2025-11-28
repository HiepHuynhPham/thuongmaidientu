<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\VnPayService;

class PaymentController extends Controller
{
    protected CartService $cartService;
    protected OrderService $orderService;
    protected VnPayService $vnPayService;

    public function __construct(CartService $cartService, OrderService $orderService, VnPayService $vnPayService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->vnPayService = $vnPayService;
    }

    /**
     * Server-side redirect flow: create PayPal order and redirect buyer to approval URL
     */
    public function redirectToPayPal(Request $request)
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $receiverName = $request->input('receiverName');
        $receiverAddress = $request->input('receiverAddress');
        $receiverPhone = $request->input('receiverPhone');

        $cartData = $this->cartService->fetchCartByUser($userId);
        $amount = $this->formatPaypalAmount($cartData['totalPrice'] ?? 0);

        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Giỏ hàng trống hoặc không hợp lệ để thanh toán.');
        }

        Session::put('pending_order', [
            'user_id' => $userId,
            'receiverName' => $receiverName,
            'receiverAddress' => $receiverAddress,
            'receiverPhone' => $receiverPhone,
            'total' => $cartData['totalPrice'],
            'paymentMethod' => 'PAYPAL',
        ]);

        $provider = $this->buildProvider();

        $createData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => strtoupper(config('paypal.currency', 'USD')),
                    'value' => number_format($amount, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'return_url' => route('payment.return'),
                'cancel_url' => route('payment.cancel'),
            ],
        ];

        $response = $provider->createOrder($createData);

        if (!isset($response['id']) || empty($response['links'])) {
            Log::error('PayPal createOrder failed (redirect flow)', ['response' => $response]);
            return redirect()->back()->with('error', 'Không thể khởi tạo thanh toán PayPal, vui lòng thử lại.');
        }

        $approveUrl = null;
        foreach ($response['links'] as $link) {
            if (isset($link['rel']) && strtolower($link['rel']) === 'approve') {
                $approveUrl = $link['href'];
                break;
            }
        }

        if (!$approveUrl) {
            Log::error('PayPal approve link missing', ['response' => $response]);
            return redirect()->back()->with('error', 'Không tìm được đường dẫn chuyển hướng tới PayPal.');
        }

        return redirect()->away($approveUrl);
    }

    /**
     * PayPal return URL (after buyer approves on PayPal)
     */
    public function handlePayPalReturn(Request $request)
    {
        $orderId = $request->query('token') ?? $request->query('orderId');
        if (!$orderId) {
            return redirect()->route('cart.show')->with('error', 'Thiếu orderId từ PayPal.');
        }

        $provider = $this->buildProvider();
        $captureResponse = $provider->capturePaymentOrder($orderId);

        if (!isset($captureResponse['status']) || strtoupper($captureResponse['status']) !== 'COMPLETED') {
            Log::warning('PayPal capture incomplete', ['orderId' => $orderId, 'response' => $captureResponse]);
            return redirect()->route('cart.show')->with('error', 'Giao dịch PayPal chưa hoàn tất.');
        }

        $pending = Session::pull('pending_order');
        if (empty($pending) || empty($pending['user_id'])) {
            Log::warning('No pending order found in session after PayPal capture', ['capture' => $captureResponse]);
            return redirect()->route('paypal.success')->with('warning', 'Thanh toán thành công nhưng không tìm thấy thông tin đơn hàng tạm.');
        }

        $userId = $pending['user_id'];
        $cartData = $this->cartService->fetchCartByUser($userId);
        $cartDetails = $cartData['cartDetails'];

        $orderData = [
            'receiverName' => $pending['receiverName'] ?? '',
            'receiverAddress' => $pending['receiverAddress'] ?? '',
            'receiverPhone' => $pending['receiverPhone'] ?? '',
            'totalPrice' => $cartData['totalPrice'] ?? 0,
            'paymentMethod' => 'PAYPAL',
        ];

        try {
            $order = $this->orderService->placeOrder($userId, $orderData, $cartDetails);
        } catch (\Throwable $e) {
            Log::error('Failed to create local order after PayPal capture', ['error' => $e->getMessage()]);
            return redirect()->route('cart.show')->with('error', 'Failed to create local order after PayPal payment.');
        }

        $order->status = 'paid';
        $order->pay = 1;
        $order->paypal_order_id = $orderId;
        $order->amount = $captureResponse['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? $orderData['totalPrice'];
        $order->currency = $captureResponse['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? config('paypal.currency', 'USD');
        $order->payer_id = $captureResponse['payer']['payer_id'] ?? null;
        $order->payer_email = $captureResponse['payer']['email_address'] ?? null;
        $order->save();

        Session::put('paypal_capture_details', $captureResponse);

        return redirect()->route('paypal.success');
    }

    public function handlePayPalCancel()
    {
        return redirect()->route('cart.show')->with('error', 'Bạn đã hủy giao dịch PayPal.');
    }

    /**
     * Record transaction sent from client after a popup flow capture.
     * Always verifies capture server-side.
     */
    public function recordPayPalTransaction(Request $request)
    {
        $data = $request->validate([
            'orderID' => 'required|string',
            'receiverName' => 'nullable|string',
            'receiverAddress' => 'nullable|string',
            'receiverPhone' => 'nullable|string',
        ]);

        $orderId = $data['orderID'];

        $provider = $this->buildProvider();
        $captureResponse = $provider->capturePaymentOrder($orderId);

        if (!isset($captureResponse['status']) || strtoupper($captureResponse['status']) !== 'COMPLETED') {
            Log::warning('PayPal verification failed for client-reported transaction', ['orderId' => $orderId, 'response' => $captureResponse]);
            return response()->json(['success' => false, 'message' => 'Không thể xác thực giao dịch PayPal.'], 422);
        }

        $userId = Session::get('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Người dùng chưa đăng nhập.'], 401);
        }

        $cartData = $this->cartService->fetchCartByUser($userId);
        $cartDetails = $cartData['cartDetails'];

        $orderData = [
            'receiverName' => $data['receiverName'] ?? '',
            'receiverAddress' => $data['receiverAddress'] ?? '',
            'receiverPhone' => $data['receiverPhone'] ?? '',
            'totalPrice' => $cartData['totalPrice'] ?? 0,
            'paymentMethod' => 'PAYPAL',
        ];

        try {
            $order = $this->orderService->placeOrder($userId, $orderData, $cartDetails);
        } catch (\Throwable $e) {
            Log::error('Failed to create local order after PayPal client flow', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Không tạo đơn hàng nội bộ.'], 422);
        }
        $order->status = 'paid';
        $order->pay = 1;
        $order->paypal_order_id = $orderId;
        $order->amount = $captureResponse['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? $orderData['totalPrice'];
        $order->currency = $captureResponse['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? config('paypal.currency', 'USD');
        $order->payer_id = $captureResponse['payer']['payer_id'] ?? null;
        $order->payer_email = $captureResponse['payer']['email_address'] ?? null;
        $order->save();

        Session::put('paypal_capture_details', $captureResponse);

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }

    /**
     * Create PayPal order for JS SDK button (amount is server-side computed).
     */
    public function createOrder(Request $request)
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cartData = $this->cartService->fetchCartByUser($userId);
        $total = $this->formatPaypalAmount($cartData['totalPrice'] ?? 0);

        if ($total <= 0) {
            return response()->json(['message' => 'Cart is empty'], 422);
        }

        $provider = $this->buildProvider();

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => strtoupper(config('paypal.currency', 'USD')),
                    'value' => number_format($total, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
            ],
        ];

        $response = $provider->createOrder($payload);

        if (!isset($response['id'])) {
            Log::error('PayPal createOrder failed', ['response' => $response]);
            return response()->json([
                'message' => 'Không thể tạo đơn hàng PayPal',
                'error' => $response,
            ], 502);
        }

        return response()->json(['id' => $response['id']], 201);
    }

    /**
     * Capture PayPal order server-side (JS SDK completion).
     */
    public function captureOrder(Request $request)
    {
        $orderId = $request->input('orderId') ?? $request->query('orderId');

        if (!$orderId) {
            return response()->json([
                'message' => 'orderId is required',
            ], 422);
        }

        $userId = Session::get('user_id');
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $provider = $this->buildProvider();
        $response = $provider->capturePaymentOrder($orderId);

        if (!isset($response['status']) || strtoupper($response['status']) !== 'COMPLETED') {
            Log::error('PayPal capturePaymentOrder failed', ['orderId' => $orderId, 'response' => $response]);
            return response()->json([
                'message' => 'Unable to capture PayPal order',
            ], 502);
        }

        $cartData = $this->cartService->fetchCartByUser($userId);
        $cartDetails = $cartData['cartDetails'];

        $orderData = [
            'receiverName' => '',
            'receiverAddress' => '',
            'receiverPhone' => '',
            'totalPrice' => $cartData['totalPrice'] ?? 0,
            'paymentMethod' => 'PAYPAL',
        ];

        try {
            $order = $this->orderService->placeOrder($userId, $orderData, $cartDetails);
        } catch (\Throwable $e) {
            Log::error('Failed to create local order after PayPal capture (JS flow)', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Không tạo đơn hàng nội bộ sau khi thanh toán PayPal.'], 422);
        }
        $order->status = 'paid';
        $order->pay = 1;
        $order->paypal_order_id = $orderId;
        $order->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? $orderData['totalPrice'];
        $order->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? config('paypal.currency', 'USD');
        $order->payer_id = $response['payer']['payer_id'] ?? null;
        $order->payer_email = $response['payer']['email_address'] ?? null;
        $order->save();

        return response()->json($response);
    }

    public function createVnPayPayment(Request $request)
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return redirect()->route('login');
        }
        $cartData = $this->cartService->fetchCartByUser($userId);
        $amount = (int) ($cartData['totalPrice'] ?? 0);
        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Giỏ hàng trống hoặc không hợp lệ để thanh toán.');
        }
        $model = new \App\Models\VnPaymentRequestModel();
        $model->amount = $amount;
        $model->description = 'Thanh toan don hang';
        $model->orderId = (string) (time());
        $model->createdDate = new \DateTimeImmutable();
        $url = $this->vnPayService->createPaymentUrl($request, $model);
        return redirect()->away($url);
    }

    public function vnPayReturn(Request $request)
    {
        $res = $this->vnPayService->paymentExecute($request->query());
        if (!$res || !$res->success || $res->vnp_ResponseCode !== '00') {
            return redirect()->route('cart.show')->with('error', 'Thanh toán VNPay thất bại.');
        }
        return redirect()->route('thank');
    }

    public function vnPayIpn(Request $request)
    {
        $res = $this->vnPayService->paymentExecute($request->query());
        if ($res && $res->success && $res->vnp_ResponseCode === '00') {
            return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
        }
        return response()->json(['RspCode' => '97', 'Message' => 'Invalid Checksum'], 400);
    }

    protected function buildProvider(): PayPalClient
    {
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        return $provider;
    }

    protected function formatPaypalAmount(float $baseAmount): float
    {
        $rate = (float) (config('paypal.vnd_to_usd_rate') ?? 24000);
        if ($rate <= 0) { $rate = 24000; }
        $usd = $baseAmount / $rate;
        return max(0, round($usd, 2));
    }
}
