<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\ProductService;
use App\Services\DiscountService;
use Illuminate\Http\Request;
class HomePageController extends Controller{

    private $productService;
    private $discountService;
    private $userService;

    function __construct(ProductService $productService, DiscountService $discountService, UserService $userService){
        $this->productService = $productService;
        $this->discountService = $discountService;
        $this->userService = $userService;
    }

    public function getHomePage(){

        $products = $this->productService->getAllProduct();
        $allproduct = $this->productService->getAllProducts();
        $productDiscounts = $this->discountService->getAllProductDiscountActive();
        return view("client.homePage.homePage", compact('products','allproduct', 'productDiscounts'), );
    }

    public function errorHomePage(){
        return view("client.auth.error");
    }

    public function getUserProfile(){
        $userId = session('user_id');
        $user = $this->userService->getUserById($userId);
        return view("client.profile.profile", compact('user'));
    }

    public function postUpdateProfile(Request $request){
        // Validate input

        $id = session('user_id');
        
        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'user_phone' => 'nullable|string|max:20',
            'user_address' => 'nullable|string|max:255',
            'user_avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Tìm user
        $user= $this->userService->getUserById($id);

        // Truyền file nếu có
        $validated['user_avatar'] = $request->file('user_avatar');

        if(!$this->userService->updateProfileUserHomepage($validated, $user)){
            return redirect('/')->with('error', 'update profile faild');
        }

        return view("client.profile.profile", compact('user'));
    }
}