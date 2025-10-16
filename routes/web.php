<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DiscountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//auth

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


//home

Route::get('/', [HomePageController::class, 'getHomePage'])->name('home');

Route::get('/error', [HomePageController::class, 'errorHomePage'])->name('error');

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'viewDashboard']);

    //User

    Route::get('/admin/user', [UserController::class, 'getAllUsers']);

    Route::get('/admin/user/{id}', [UserController::class, 'detailUser']);

    Route::get('/admin/users/create', [UserController::class, 'createUser']);
    Route::post('/admin/user/create', [UserController::class, 'handleCreateUser']);

    Route::get('/admin/user/update/{id}', [UserController::class, 'updateUser']);
    Route::post('/admin/user/update/{id}', [UserController::class, 'handleUpdateUser']);

    Route::get('/admin/user/delete/{id}', [UserController::class, 'deleteUser']);
    Route::post('/admin/user/delete/{id}', [UserController::class, 'handleDeleteUser']);

    //Product

    Route::get('/admin/product', [ProductController::class, 'getAllProduct']);

    Route::get('/admin/product/{id}', [ProductController::class, 'detailProduct']);

    Route::get('/admin/products/create', [ProductController::class, 'createProduct']);
    Route::post('/admin/product/create', [ProductController::class, 'handleCreateProduct']);

    Route::get('/admin/product/update/{id}', [ProductController::class, 'updateProduct']);
    Route::post('/admin/product/update/{id}', [ProductController::class, 'handleUpdateProduct']);

    Route::get('/admin/product/delete/{id}', [ProductController::class, 'deleteProduct']);
    Route::post('/admin/product/delete/{id}', [ProductController::class, 'handleDeleteProduct']);

    //order

    Route::get('/admin/order', [OrderController::class, 'getAllOrder']);

    Route::get('/admin/order/{id}', [OrderController::class, 'detailOrder']);

    Route::get('/admin/order/update/{id}', [OrderController::class, 'updateOrder']);
    Route::post('/admin/order/update/{id}', [OrderController::class, 'handleUpdateOrder']);

    //discount

    Route::get('/admin/discount', [DiscountController::class, 'getAllProductAndProductDiscount']);

    Route::get('/admin/discount/{id}', [DiscountController::class, 'detailProduct']);

    Route::get('/admin/discount/productdiscount/{id}', [DiscountController::class, 'detailProductDiscount']);

    Route::get('/admin/discount/create/{id}', [DiscountController::class, 'createProductDiscount']);
    Route::post('/admin/discount/create/{id}', [DiscountController::class, 'postCreateProductDiscount']);

    Route::get('/admin/discount/update/{id}', [DiscountController::class, 'updateProductDiscount']);
    Route::post('/admin/discount/update/{id}', [DiscountController::class, 'postUpdateProductDiscount']);
});

//product

Route::get('/product/{id}', [ProductController::class, 'getProductDetailPage']);

Route::get('/product', [ProductController::class, 'filterProducts'])->name('product');

//Cart

Route::get('/cart', [CartController::class, 'getCartPage'])->name('cart.show');

Route::post('/add-product-to-cart/{id}', [CartController::class, 'addProductToCart'])->name('cart.add');

Route::post('/confirm-checkout', [CartController::class, 'postCheckOutPage'])->name('confirmCheckout');

Route::get('/checkout', [CartController::class, 'getCheckOutPage'])->name('checkout');

Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('placeOrder');

Route::get('/thank', [OrderController::class, 'thank'])->name('thank');

Route::get('/order-history', [OrderController::class, 'getOrderHistory']);

//comment

Route::post('/confirm-comment', [ProductController::class, 'postConfirmComment'])->name('comment.confirm');

Route::post('/review/delete/{id}', [ProductController::class, 'postDeleteComment']);

//profile

Route::get('/user-profile', [HomePageController::class, 'getUserProfile']);

Route::post('/update-user-in-profile', [HomePageController::class, 'postUpdateProfile']);