<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderService
{
    public function getAllOrder($perPage = 10)
    {
        return Order::paginate($perPage);
    }

    public function getOrderById($id)
    {
         return Order::with('orderDetails')->find($id);
    }

    public function getOrdersByUserId($userId)
    {
        return Order::with('orderDetails')
                    ->where('user_id', $userId)
                    ->get();
    }

    public function handleUpdateOrder($status ,$id)
    {
        $order= Order::with('orderDetails')->find($id);

        $order->status=$status;
        $order->save();
    }

    // L���y thA'ng tin gi��? hA�ng
    public function getCartDetails($userId)
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

        $totalPrice = $cartDetails->sum(function ($cd) {
            return $cd->product->product_price * $cd->cartDetails_quantity;
        });

        return [
            'cartDetails' => $cartDetails,
            'totalPrice' => $totalPrice
        ];
    }

    // T���o �`��n hA�ng
    public function placeOrder($userId, $data, $cartDetails)
    {
        $selectedDetails = $cartDetails->filter(function ($cd) {
            return $cd->cartDetails_checkbox == 1;
        });

        if ($selectedDetails->isEmpty()) {
            $selectedDetails = $cartDetails;
        }

        if ($selectedDetails->isEmpty()) {
            throw new \RuntimeException('Cannot place order without items.');
        }

        $orderTotal = $selectedDetails->sum(function ($cd) {
            return $cd->product->product_price * $cd->cartDetails_quantity;
        });

        // T���o �`��n hA�ng
        $order = Order::create([
            'user_id' => $userId,
            'receiver_name' => $data['receiverName'],
            'receiver_address' => $data['receiverAddress'],
            'receiver_phone' => $data['receiverPhone'],
            'total_price' => $orderTotal,
            'status' => 'pending',
            'payment_method' => $data['paymentMethod'],
            'pay' => 0, // �?��n hA�ng ch��a thanh toA�n
        ]);

        // L��u chi ti���t �`��n hA�ng
        foreach ($selectedDetails as $cartDetail) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cartDetail->product_id,
                'quantity' => $cartDetail->cartDetails_quantity,
                'price' => $cartDetail->product->product_price,
                'payment_method' => $data['paymentMethod'],
            ]);
        }

        // XA3a cA�c CartDetail �`A� �`�����c checkout
        $cartIds = Cart::where('user_id', $userId)->pluck('id');
        foreach ($cartIds as $cartId) {
            // XA3a cA�c CartDetail cA3 checkbox = 1
            CartDetail::where('cart_id', $cartId)
                ->where('cartDetails_checkbox', 1)
                ->delete();

            // TA-nh l���i t��ng s��` l�����ng lo���i s���n ph��cm cA�n l���i trong gi��? hA�ng
            $newCartSum = CartDetail::where('cart_id', $cartId)->count();

            // C��-p nh��-t cart_sum ho���c xA3a cart n���u khA'ng cA�n chi ti���t
            if ($newCartSum > 0) {
                Cart::where('id', $cartId)->update(['cart_sum' => $newCartSum]);
            } else {
                Cart::where('id', $cartId)->delete();
            }
        }

        return $order;
    }
}
