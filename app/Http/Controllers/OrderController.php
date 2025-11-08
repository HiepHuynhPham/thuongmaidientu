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
        $this->orderService->handleUpdateOrder($request['order_status'],$id);
        return redirect('/admin/order')->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }


    // Xử lý đặt hàng
    public function placeOrder(Request $request)
    {
        // Lấy ID người dùng từ session
        $userId = Session::get('user_id');

        // Kiểm tra người dùng đăng nhập
        if (!$userId) {
            return redirect()->route('login');
        }

        // Dữ liệu từ form đặt hàng
        $data = $request->only(['receiverName', 'receiverAddress', 'receiverPhone', 'paymentMethod']);
        $cartData = $this->cartService->fetchCartByUser($userId);

        // Gọi service để xử lý đặt hàng
        $order = $this->orderService->placeOrder($userId, array_merge($data, [
            'totalPrice' => $cartData['totalPrice'],
        ]), $cartData['cartDetails']);

        if ($order) {
        // Thanh toán VNPAY
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
                // Gán mặc định NCB để test nhanh theo hướng dẫn
                'bankCode' => 'NCB',
            ]);

            // Lưu thông tin để xử lý sau khi quay về từ VNPAY
            Session::put('vnp_pending_order_id', $order->id);
            return redirect($paymentUrl);
        }

        return redirect()->route('thank')->with('success', 'Đặt hàng thành công!');
    } else {
        return redirect()->back()->with('error', 'Đặt hàng thất bại. Vui lòng thử lại.');
    }
    }

    public function thank(Request $request)
    {
        // Kiểm tra trạng thái giao dịch từ request
        $resultCode = $request->query('resultCode');
        if ($resultCode !== null && intval($resultCode) !== 0) {
            return view('client.cart.failure');
        }
        // Handle VNPAY return
        if ($request->query('vnp_ResponseCode') !== null) {
            $vnPay = new \App\Services\VnPayService();
            $isValid = $vnPay->validateReturn($request->query());
            if (!$isValid) {
                return view('client.cart.failure')->with('error', 'Không thể xác thực giao dịch VNPAY.');
            }

            $respCode = $request->query('vnp_ResponseCode');
            $orderIdInternal = Session::pull('vnp_pending_order_id');

            if ($respCode === '00' && $orderIdInternal) {
                $order = Order::where('id', $orderIdInternal)->first();
                if ($order) {
                    $order->update([
                        'pay' => 1,
                        'order_status' => 'paid',
                        'payment_method' => 'VNPAY',
                    ]);
                }
                return view('client.cart.thank');
            }

            return view('client.cart.failure')->with('error', 'Thanh toán VNPAY thất bại hoặc đã hủy.');
        }

        return view('client.cart.thank');

    }

}