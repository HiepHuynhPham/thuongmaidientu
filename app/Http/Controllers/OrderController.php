<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\CartService;
use App\Services\PaymentService;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected $orderService;
    protected $cartService;
    protected $paymentService;

    public function __construct(OrderService $orderService, CartService $cartService,PaymentService $paymentService )
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->paymentService = $paymentService;
    }



    public function getAllOrder(){
        $orders = $this->orderService->getAllOrder();
        return view('admin.order.show', compact('orders'));
    }


    public function detailOrder($id){
        try {
            $orders = $this->orderService->getOrderById($id);
            if(!$orders){
                return view('admin.order.detail', ['orders'=>null]);
            }
            return view('admin.order.detail', compact('orders'));
        } catch (\Throwable $th) {
            return view('admin.order.detail', ['orders'=>null]);
        }
    }

    public function getOrderHistory(){
        try {
            $id = session('user_id');
            $orders = $this->orderService->getOrdersByUserId($id);
            if(!$orders){
                return view('client.cart.orderHistory', ['orders'=>null]);
            }
            return view('client.cart.orderHistory', compact('orders'));
        } catch (\Throwable $th) {
            return view('client.cart.orderHistory', ['orders'=>null]);
        }
    }

    public function updateOrder($id){
        try {
            $orders = $this->orderService->getOrderById($id);
            if(!$orders){
                return view('admin.order.update', ['orders'=>null]);
            }
            return view('admin.order.update', compact('orders'));
        } catch (\Throwable $th) {
            return view('admin.order.update', ['orders'=>null]);
        }
    }

    public function handleUpdateOrder(Request $request, $id){
        $this->orderService->handleUpdateOrder($request['status'],$id);
        return redirect('/admin/order')->with('success', 'C��-p nh��-t tr���ng thA�i �`��n hA�ng thA�nh cA'ng!');
    }


    // X��- lA� �`���t hA�ng
    public function placeOrder(Request $request)
    {
        // L���y ID ng����?i dA1ng t��� session
        $userId = Session::get('user_id');

        // Ki���m tra ng����?i dA1ng �`��ng nh��-p
        if (!$userId) {
            return redirect()->route('login');
        }

        // D��_ li���u t��� form �`���t hA�ng
        $data = $request->only(['receiverName', 'receiverAddress', 'receiverPhone', 'paymentMethod']);
        $cartData = $this->cartService->fetchCartByUser($userId);

        // G��?i service �`��� x��- lA� �`���t hA�ng
        $order = $this->orderService->placeOrder($userId, array_merge($data, [
            'totalPrice' => $cartData['totalPrice'],
        ]), $cartData['cartDetails']);

        if ($order) {
        // Thanh toA�n VNPAY
        if ($data['paymentMethod'] === 'VNPAY') {
            $time = strval(time());
            $vnOrderId = 'VNPAY' . $time;
            $vnOrderInfo = 'Payment for order #' . $order->id;
            $amount = (int) $cartData['totalPrice'];

            $vnPay = new \App\Services\VnPayService();
            $paymentUrl = $vnPay->generatePaymentUrl([
                'amount' => $amount,
                'orderId' => $vnOrderId,
                'orderInfo' => $vnOrderInfo,
                'ipAddr' => $request->ip(),
                // GA�n m���c �`��<nh NCB �`��� test nhanh theo h����>ng d���n
                'bankCode' => 'NCB',
            ]);

            // L��u thA'ng tin �`��� x��- lA� sau khi quay v��? t��� VNPAY
            Session::put('vnp_pending_order_id', $order->id);
            return redirect($paymentUrl);
        }

        return redirect()->route('thank')->with('success', '�?���t hA�ng thA�nh cA'ng!');
    } else {
        return redirect()->back()->with('error', '�?���t hA�ng th���t b���i. Vui lA�ng th��- l���i.');
    }
    }

    public function thank(Request $request)
    {
        // Ki���m tra tr���ng thA�i giao d��<ch t��� request
        $resultCode = $request->query('resultCode');
        if ($resultCode !== null && intval($resultCode) !== 0) {
            return view('client.cart.failure');
        }
        // Handle VNPAY return
        if ($request->query('vnp_ResponseCode') !== null) {
            $vnPay = new \App\Services\VnPayService();
            $isValid = $vnPay->validateReturn($request->query());
            if (!$isValid) {
                return view('client.cart.failure')->with('error', 'KhA'ng th��� xA�c th���c giao d��<ch VNPAY.');
            }

            $respCode = $request->query('vnp_ResponseCode');
            $orderIdInternal = Session::pull('vnp_pending_order_id');

            if ($respCode === '00' && $orderIdInternal) {
                $order = Order::where('id', $orderIdInternal)->first();
                if ($order) {
                    $order->update([
                        'pay' => 1,
                        'status' => 'paid',
                        'payment_method' => 'VNPAY',
                    ]);
                }
                return view('client.cart.thank');
            }

            return view('client.cart.failure')->with('error', 'Thanh toA�n VNPAY th���t b���i ho���c �`A� h��y.');
        }

        return view('client.cart.thank');

    }

}
