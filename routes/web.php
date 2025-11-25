<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Artisan;

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

// PayPal checkout (JavaScript SDK flow)
Route::get('/paypal/checkout', [PayPalController::class, 'checkout'])->name('paypal.checkout');

Route::get('/payment/PaymentSuccess', [PayPalController::class, 'successTransaction'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancelTransaction'])->name('paypal.cancel');
// PayPal Orders API endpoints used by JS SDK on checkout page
Route::post('/paypal/orders/create', [PayPalController::class, 'createOrder'])->name('paypal.orders.create');
Route::post('/paypal/orders/capture', [PayPalController::class, 'captureOrder'])->name('paypal.orders.capture');
// Aliases following the requested endpoint naming
Route::post('/payment/create-paypal-order', [PayPalController::class, 'createOrder'])->name('payment.paypal.create');
Route::post('/payment/capture-paypal-order', [PayPalController::class, 'captureOrder'])->name('payment.paypal.capture');
// Server-side redirect flow (create order and redirect buyer to PayPal)
Route::post('/payment/redirect-paypal', [PaymentController::class, 'redirectToPayPal'])->name('payment.redirect');
Route::get('/payment/paypal-return', [PaymentController::class, 'handlePayPalReturn'])->name('payment.return');
Route::get('/payment/paypal-cancel', [PaymentController::class, 'handlePayPalCancel'])->name('payment.cancel');
Route::post('/payment/record-paypal', [PaymentController::class, 'recordPayPalTransaction'])->name('payment.record');

//Migrate link (only for dev environment)
Route::get('/run-migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return nl2br(Artisan::output());
    } catch (\Exception $e) {
        return '❌ Lỗi: ' . $e->getMessage();
    }
});

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return 'Cache cleared!';
});

Route::get('/debug-assets', function () {
    $paths = [
        'css/style.css',
        'css/bootstrap.min.css',
        'css/bootstrap-login-form.min.css',
        'lib/lightbox/css/lightbox.min.css',
        'lib/owlcarousel/assets/owl.carousel.min.css',
        'lib/easing/easing.min.js',
        'lib/waypoints/waypoints.min.js',
        'lib/lightbox/js/lightbox.min.js',
        'lib/owlcarousel/owl.carousel.min.js',
        'js/main.js',
        'js/mdb.min.js',
    ];
    $result = [];
    foreach ($paths as $p) {
        $result[$p] = file_exists(public_path($p));
    }
    return response()->json($result);
});

Route::get('/import-db', function () {
    $files = [
        base_path('initdb/fruitshop.sql'),
        base_path('initdb/products_seed.sql'),
    ];
    $executed = [];
    foreach ($files as $file) {
        if (file_exists($file)) {
            try {
                DB::unprepared(file_get_contents($file));
                $executed[] = basename($file);
            } catch (\Throwable $e) {
                return response()->json(['ok' => false, 'file' => basename($file), 'error' => $e->getMessage()], 500);
            }
        }
    }
    return response()->json(['ok' => true, 'executed' => $executed]);
});
