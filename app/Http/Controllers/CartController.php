<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Session;

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
        $this->cartService->handleAddProductToCart($email, $id, 1);
        return redirect('/');
    }

    public function getCartPage(Request $request)
    {
        // Lấy ID người dùng từ session
        $userId = $request->session()->get('user_id');

        // Lấy thông tin giỏ hàng từ Service
        $cartData = $this->cartService->getCartDetails($userId);

        // Trả về view với dữ liệu giỏ hàng
        return view('client.cart.show', $cartData);
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

        // Truyền dữ liệu cho view
        return view('client.cart.checkout', [
            'cartDetails' => $cartData['cartDetails'],
            'totalPrice' => $cartData['totalPrice'],
        ]);
    }
}