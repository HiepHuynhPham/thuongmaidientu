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
        // Thanh toán MOMO
        if ($data['paymentMethod'] === 'MOMO') {
            $time = strval(time());
            $orderId = "MOMO" . $time;
            $orderInfo = "Payment for order " . $orderId;
            $amount = strval($cartData['totalPrice']);
            $requestId = "MOMO" . $time . "001";

            // Tạo yêu cầu thanh toán MOMO
            $paymentRequest = [
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'requestId' => $requestId,
                'extraData' => strval($order->id),  // Gắn ID đơn hàng vào extraData
            ];

            // Gửi yêu cầu thanh toán đến MOMO
            $response = $this->paymentService->createPayment($paymentRequest);
            $jsonResponse = json_decode($response, true);

            // Lấy URL thanh toán
            $paymentUrl = $jsonResponse['payUrl'] ?? '';

            if (!empty($paymentUrl)) {
                // Lưu orderId và requestId vào session để kiểm tra sau
                Session::put('momoOrderId', $orderId);
                Session::put('momoRequestId', $requestId);
                return redirect($paymentUrl);
            }
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
        $orderId = $request->query('extraData');
        // Kiểm tra trạng thái giao dịch qua session
        $momoOrderId = Session::get('momoOrderId');
        $momoRequestId = Session::get('momoRequestId');

        if ($momoOrderId && $momoRequestId) {
            // Gọi phương thức checkPaymentStatus để kiểm tra trạng thái giao dịch
            $transactionStatus = $this->paymentService->queryTransactionStatus($momoOrderId, $momoRequestId);

            // Kiểm tra nếu không có phản hồi hoặc phản hồi không phải là JSON hợp lệ
            if (empty($transactionStatus)) {
                return view('client.cart.failure')->with('error', 'Không nhận được phản hồi từ MoMo.');
            }

            $jsonResponse = json_decode($transactionStatus, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return view('client.cart.failure')->with('error', 'Phản hồi không hợp lệ từ MoMo.');
            }

            $resultCodeFromApi = $jsonResponse['resultCode'] ?? -1;
            if ($resultCodeFromApi === 0) {
                $order = Order::where('id', $orderId)->first();
                if ($order) {
                    $order->update([
                        'pay' => 1, // Cập nhật trạng thái thanh toán
                    ]);
                }
                return view('client.cart.thank');
            } else {
                return view('client.cart.failure')->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
            }
        }

        return view('client.cart.thank');

    }

}