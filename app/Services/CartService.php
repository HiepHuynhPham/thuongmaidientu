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
        // Lấy thông tin người dùng theo email
        $user = User::where('user_email', $email)->first();
        if ($user) {
            // Kiểm tra giỏ hàng có tồn tại không
            $cart = Cart::where('user_id', $user->id)->first();

            if (!$cart) {
                // Tạo mới giỏ hàng
                $cart = Cart::create([
                    'user_id' => $user->id,
                    'cart_sum' => 0,
                ]);
            }

            // Tìm sản phẩm theo ID
            $product = Product::find($productId);
            if ($product) {
                // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
                $cartDetail = CartDetail::where('cart_id', $cart->id)
                    ->where('product_id', $productId)
                    ->first();

                if (!$cartDetail) {
                    // Tạo mới chi tiết giỏ hàng
                    CartDetail::create([
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'cartDetails_quantity' => $quantity,
                        'cartDetails_checkbox' => false,
                    ]);
                    // Cập nhật tổng số lượng trong giỏ hàng
                    $cart->cart_sum += $quantity;
                    $cart->save();
                } else {
                    // Cập nhật số lượng nếu sản phẩm đã có
                    $cartDetail->cartDetails_quantity += $quantity;
                    $cartDetail->save();
                }

                // Cập nhật session giỏ hàng
                Session::put('cart_sum', $cart->cart_sum);
            }
        }
    }

    public function getCartDetails($userId)
    {
        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $userId)->first();

        // Nếu không có giỏ hàng, trả về danh sách rỗng
        if (!$cart) {
            return [
                'cartDetails' => [],
                'totalPrice' => 0,
                'cart' => null
            ];
        }

        // Lấy danh sách chi tiết giỏ hàng
        $cartDetails = $cart->cartDetails;
        $totalPrice = 0;

        foreach ($cartDetails as $cd) {
            // Đặt checkbox về false
            $cd->cartDetails_checkbox = false;
            $cd->save();

            // Tính tổng tiền
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
        foreach ($cartDetails as $cartDetail) {
        $currentCartDetail = CartDetail::find($cartDetail['id']);

        if ($currentCartDetail) {
            // Sử dụng setAttribute để gán giá trị cho đúng tên cột
            $currentCartDetail->setAttribute('cartDetails_quantity', $cartDetail['quantity']);
            $currentCartDetail->setAttribute('cartDetails_checkbox', $cartDetail['checkbox'] ?? 0); // Mặc định là 0 nếu không được check
            
            $currentCartDetail->save();
        }
    }
    }

    public function fetchCartByUser($userId)
    {
        $cart = Cart::where('user_id', $userId)->with('cartDetails')->first();

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
}