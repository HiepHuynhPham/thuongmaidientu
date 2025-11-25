<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addProductToCart($id, Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        $email = $request->session()->get('email');
        if (!$email) {
            // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm vào giỏ hàng!');
        }

        // Nếu đã đăng nhập, tiến hành thêm vào giỏ hàng
        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) { $quantity = 1; }
        $this->cartService->handleAddProductToCart($email, $id, $quantity);
        // Trả về trang trước đó để tránh chuyển về trang chủ
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }

    public function getCartPage(Request $request)
    {
        $userId = $request->session()->get('user_id');
        try {
            $cartData = $this->cartService->getCartDetails($userId);
            return view('client.cart.show', $cartData);
        } catch (\Throwable $e) {
            return view('client.cart.show', [
                'cartDetails' => [],
                'totalPrice' => 0,
                'cart' => null,
            ])->with('error', 'Không thể tải giỏ hàng, vui lòng thử lại.');
        }
    }


    public function postCheckOutPage(Request $request)
    {
        $cartDetails = $request->input('cartDetails', []); // Lấy danh sách giỏ hàng từ request
        $this->cartService->handleUpdateCartBeforeCheckout($cartDetails); // Gọi service để xử lý
        return redirect()->route('checkout');
    }

    public function getCheckOutPage(Request $request)
    {
        // Lấy ID người dùng từ session
        $userId = Session::get('user_id');
        if (!$userId) {
            return redirect()->route('login'); // Nếu chưa đăng nhập, chuyển đến trang đăng nhập
        }

        // Gọi service để lấy thông tin giỏ hàng
        $cartData = $this->cartService->fetchCartByUser($userId);

        // Lấy cấu hình PayPal (client id, currency) để nhúng JS SDK trực tiếp vào trang checkout
        $config = config('paypal');
        $mode = Str::lower($config['mode'] ?? 'sandbox');
        $paypalClientId = $mode === 'live'
            ? ($config['live']['client_id'] ?? '')
            : ($config['sandbox']['client_id'] ?? '');
        $paypalCurrency = $config['currency'] ?? 'USD';
        $paypalLocale = $config['locale'] ?? 'en_US';

        // Truyền dữ liệu cho view
        return view('client.cart.checkout', [
            'cartDetails' => $cartData['cartDetails'],
            'totalPrice' => $cartData['totalPrice'],
            'paypalClientId' => $paypalClientId,
            'paypalCurrency' => $paypalCurrency,
            'paypalLocale' => $paypalLocale,
        ]);
    }
}