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

        $order->order_status=$status;
        $order->save();

    }

    // Lấy thông tin giỏ hàng
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

    // Tạo đơn hàng
    public function placeOrder($userId, $data, $cartDetails)
{
    // Tạo đơn hàng
    $order = Order::create([
        'user_id' => $userId,
        'receiver_name' => $data['receiverName'],
        'receiver_address' => $data['receiverAddress'],
        'receiver_phone' => $data['receiverPhone'],
        'total_price' => $data['totalPrice'],
        'order_status' => 'pending',
        'payment_method' => $data['paymentMethod'],
        'pay' => 0, // Đơn hàng chưa thanh toán
    ]);

    // Lưu chi tiết đơn hàng
    foreach ($cartDetails as $cartDetail) {
        if ($cartDetail->cartDetails_checkbox == 1) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cartDetail->product_id,
                'quantity' => $cartDetail->cartDetails_quantity,
                'price' => $cartDetail->product->product_price,
                'payment_method' => $data['paymentMethod'],
            ]);
        }
    }

    // Xóa các CartDetail đã được checkout
    $cartIds = Cart::where('user_id', $userId)->pluck('id');
    foreach ($cartIds as $cartId) {
        // Xóa các CartDetail có checkbox = 1
        CartDetail::where('cart_id', $cartId)
            ->where('cartDetails_checkbox', 1)
            ->delete();

        // Tính lại tổng số lượng loại sản phẩm còn lại trong giỏ hàng
        $newCartSum = CartDetail::where('cart_id', $cartId)->count();

        // Cập nhật cart_sum hoặc xóa cart nếu không còn chi tiết
        if ($newCartSum > 0) {
            Cart::where('id', $cartId)->update(['cart_sum' => $newCartSum]);
        } else {
            Cart::where('id', $cartId)->delete();
        }
    }

    

    return $order;
}




}