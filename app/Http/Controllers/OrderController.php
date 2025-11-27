<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\CartService;
use App\Services\PaymentService;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\VNPayController;

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
        return redirect('/admin/order')->with('success', 'Updated order status successfully!');
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

        // Dữ liệu từ form đặt hàng
        $data = $request->only(['receiverName', 'receiverAddress', 'receiverPhone', 'paymentMethod']);
        $cartData = $this->cartService->fetchCartByUser($userId);

        // Nếu chọn VNPay thì chuyển sang route VNPayController và kèm amount
        if (($data['paymentMethod'] ?? null) === 'VNPAY') {
            $amount = (int) ($cartData['totalPrice'] ?? 0);
            \Illuminate\Support\Facades\Session::put('vnp_amount', $amount);
            return redirect()->route('payment.vnpay', ['amount' => $amount]);
        }

        // Gọi service để xử lý đặt hàng
        $order = $this->orderService->placeOrder($userId, array_merge($data, [
            'totalPrice' => $cartData['totalPrice'],
        ]), $cartData['cartDetails']);

        if ($order) {
        // Thanh toán COD hoặc các phương thức khác

        return redirect()->route('thank')->with('success', 'Order placed successfully!');
    } else {
        return redirect()->back()->with('error', 'Order placement failed. Please try again.');
    }
    }

    public function thank(Request $request)
    {
        // Ki���m tra tr���ng thA�i giao d��<ch t��� request
        $resultCode = $request->query('resultCode');
        if ($resultCode !== null && intval($resultCode) !== 0) {
            return view('client.cart.failure');
        }
        // Handle VNPay return: only display status, do not update DB here
        if ($request->query('vnp_ResponseCode') !== null) {
            $vnPay = new \App\Services\VnPayService();
            $res = $vnPay->paymentExecute($request->query());
            if (!$res || !$res->success) {
                return view('client.cart.failure')->with('error', 'Unable to verify VNPay transaction.');
            }

            $respCode = $request->query('vnp_ResponseCode');
            return $respCode === '00' ? view('client.cart.thank') : view('client.cart.failure')->with('error', 'VNPay payment failed or cancelled.');
        }

        return view('client.cart.thank');

    }

}
