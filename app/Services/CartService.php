<?php
// app/Services/CartService.php
namespace App\Services;

use App\Models\User;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function handleAddProductToCart($email, $productId, $quantity = 1)
    {
        $user = User::where('user_email', $email)->first();
        if (!$user) {
            return;
        }

        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user->id,
                'cart_sum' => 0,
            ]);
        }

        $product = Product::find($productId);
        if (!$product) {
            return;
        }

        $cartDetail = CartDetail::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if (!$cartDetail) {
            CartDetail::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'cartDetails_quantity' => $quantity,
                'cartDetails_checkbox' => false,
            ]);
        } else {
            $cartDetail->cartDetails_quantity += max(1, $quantity);
            $cartDetail->save();
        }

        $this->syncCartSum($cart->id);
    }

    public function getCartDetails($userId)
    {
        $cart = Cart::where('user_id', $userId)->with('cartDetails.product')->first();

        if (!$cart) {
            return [
                'cartDetails' => [],
                'totalPrice' => 0,
                'cart' => null
            ];
        }

        $cartDetails = $cart->cartDetails;
        $totalPrice = 0;

        foreach ($cartDetails as $cd) {
            $totalPrice += $cd->product->product_price * $cd->cartDetails_quantity;
        }

        return [
            'cartDetails' => $cartDetails,
            'totalPrice' => $totalPrice,
            'cart' => $cart
        ];
    }


    public function handleUpdateCartBeforeCheckout(array $cartDetails)
    {
        $touchedCartIds = [];
        foreach ($cartDetails as $cartDetail) {
            $currentCartDetail = CartDetail::find($cartDetail['id']);

            if ($currentCartDetail) {
                $currentCartDetail->setAttribute('cartDetails_quantity', $cartDetail['quantity']);
                $currentCartDetail->setAttribute('cartDetails_checkbox', $cartDetail['checkbox'] ?? 0);
                $currentCartDetail->save();
                $touchedCartIds[$currentCartDetail->cart_id] = true;
            }
        }

        foreach (array_keys($touchedCartIds) as $cartId) {
            $this->syncCartSum($cartId);
        }
    }

    public function fetchCartByUser($userId)
    {
        $cart = Cart::where('user_id', $userId)->with('cartDetails.product')->first();

        if (!$cart) {
            return [
                'cartDetails' => [],
                'totalPrice' => 0
            ];
        }

        $cartDetails = $cart->cartDetails->filter(function ($cd) {
            return $cd->cartDetails_checkbox != 0;
        });

        if ($cartDetails->isEmpty()) {
            $cartDetails = $cart->cartDetails;
        }

        $totalPrice = $cartDetails->sum(function ($cd) {
            return $cd->product->product_price * $cd->cartDetails_quantity;
        });

        return [
            'cartDetails' => $cartDetails,
            'totalPrice' => $totalPrice
        ];
    }

    protected function syncCartSum(int $cartId): void
    {
        $sum = CartDetail::where('cart_id', $cartId)->sum('cartDetails_quantity');
        Cart::where('id', $cartId)->update(['cart_sum' => $sum]);
        Session::put('cart_sum', $sum);
    }
}
