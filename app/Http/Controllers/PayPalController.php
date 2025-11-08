<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;
use App\Services\CartService;

class PayPalController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function checkout()
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $cartData = $this->cartService->fetchCartByUser($userId);
        $amount = (float) ($cartData['totalPrice'] ?? 0);

        if ($amount <= 0) {
            return redirect()->route('cart.show')->with('error', 'Giỏ hàng của bạn đang trống hoặc không hợp lệ cho thanh toán.');
        }

        Session::put('paypal_amount', $amount);

        $config = config('paypal');
        $mode = Str::lower($config['mode'] ?? 'sandbox');
        $clientId = $mode === 'live'
            ? ($config['live']['client_id'] ?? '')
            : ($config['sandbox']['client_id'] ?? '');

        return view('paypal.checkout', [
            'paypalClientId' => $clientId,
            'paypalCurrency' => $config['currency'] ?? 'USD',
            'paypalAmount' => $amount,
        ]);
    }

    public function createTransaction()
    {
        return $this->checkout();
    }

    public function createOrder(Request $request)
    {
        $data = $request->validate([
            'value' => 'required|numeric|min:0.1',
            'currency_code' => 'required|string|size:3',
        ]);

        $provider = $this->buildProvider();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => strtoupper($data['currency_code']),
                    'value' => number_format($data['value'], 2, '.', ''),
                ],
            ]],
        ]);

        if (!isset($response['id'])) {
            Log::error('PayPal createOrder failed', ['response' => $response]);
            return response()->json([
                'message' => 'Unable to create PayPal order',
            ], Response::HTTP_BAD_GATEWAY);
        }

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function captureOrder(Request $request)
    {
        $orderId = $request->input('orderId') ?? $request->query('orderId');

        if (!$orderId) {
            return response()->json([
                'message' => 'orderId is required',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $provider = $this->buildProvider();
        $response = $provider->capturePaymentOrder($orderId);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $order = new Order();
            $order->user_id = Session::get('user_id');
            $order->paypal_order_id = $orderId;
            $order->status = $response['status'];
            $order->payer_id = $response['payer']['payer_id'];
            $order->payer_email = $response['payer']['email_address'];
            $order->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $order->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            $order->save();

            return response()->json($response);
        }

        if (!isset($response['status'])) {
            Log::error('PayPal capturePaymentOrder failed', ['orderId' => $orderId, 'response' => $response]);
            return response()->json([
                'message' => 'Unable to capture PayPal order',
            ], Response::HTTP_BAD_GATEWAY);
        }
    }

    public function successTransaction(Request $request)
    {
        return view('paypal.success', [
            'details' => $request->all(),
        ]);
    }

    public function cancelTransaction()
    {
        return view('paypal.cancel');
    }

    protected function buildProvider(): PayPalClient
    {
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        return $provider;
    }
}
