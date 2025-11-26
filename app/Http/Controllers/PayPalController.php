<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
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
            return redirect()->route('cart.show')->with('error', 'Gi��? hA�ng c��a b���n �`ang tr��`ng ho���c khA'ng h���p l��� cho thanh toA�n.');
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

    public function successTransaction()
    {
        return view('paypal.success', [
            'details' => [],
        ]);
    }

    public function cancelTransaction()
    {
        return view('paypal.cancel');
    }
}
