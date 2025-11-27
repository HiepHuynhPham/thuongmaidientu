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
// use App\Http\Controllers\VNPayController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SitemapController;
use App\Models\Product;

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

Route::get('/seo/fruit-seo-guide', [HomePageController::class, 'seoLandingPage'])->name('seo.landing');

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

Route::get('/product/{slug}-{id}', [ProductController::class, 'getProductDetailPage'])->whereNumber('id')->name('product.detail');

Route::get('/product/{id}', function ($id) {
    $product = Product::find($id);
    if (!$product) {
        abort(404);
    }

    return redirect()->route('product.detail', ['slug' => $product->slug, 'id' => $product->id]);
})->whereNumber('id');

Route::get('/product', [ProductController::class, 'filterProducts'])->name('product');

Route::get('/san-pham/{slug}', [ProductController::class, 'detailBySlug'])->name('product.slug');

//Cart

Route::get('/add-product-to-cart/{id}', function ($id) {
    $product = Product::find($id);
    if (!$product) {
        abort(404);
    }

    return redirect()->route('product.detail', ['slug' => $product->slug, 'id' => $product->id])->with('error', 'Đường dẫn không hợp lệ, vui lòng dùng nút Thêm vào giỏ hàng.');
});
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

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

//profile

Route::get('/user-profile', [HomePageController::class, 'getUserProfile']);

Route::post('/update-user-in-profile', [HomePageController::class, 'postUpdateProfile']);

// PayPal checkout (JavaScript SDK flow)
Route::get('/paypal/checkout', [PayPalController::class, 'checkout'])->name('paypal.checkout');

Route::get('/payment/PaymentSuccess', [PayPalController::class, 'successTransaction'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancelTransaction'])->name('paypal.cancel');
// PayPal Orders API endpoints used by JS SDK on checkout page
Route::post('/paypal/orders/create', [PaymentController::class, 'createOrder'])->name('paypal.orders.create');
Route::post('/paypal/orders/capture', [PaymentController::class, 'captureOrder'])->name('paypal.orders.capture');
// Aliases following the requested endpoint naming
Route::post('/payment/create-paypal-order', [PaymentController::class, 'createOrder'])->name('payment.paypal.create');
Route::post('/payment/capture-paypal-order', [PaymentController::class, 'captureOrder'])->name('payment.paypal.capture');
// Server-side redirect flow (create order and redirect buyer to PayPal)
Route::post('/payment/redirect-paypal', [PaymentController::class, 'redirectToPayPal'])->name('payment.redirect');
Route::get('/payment/paypal-return', [PaymentController::class, 'handlePayPalReturn'])->name('payment.return');
Route::get('/payment/paypal-cancel', [PaymentController::class, 'handlePayPalCancel'])->name('payment.cancel');
Route::post('/payment/record-paypal', [PaymentController::class, 'recordPayPalTransaction'])->name('payment.record');

// VNPay (PaymentController)
Route::get('/payment/vnpay', [PaymentController::class, 'createVnPayPayment'])->name('payment.vnpay');
Route::get('/payment/vnpay/return', [PaymentController::class, 'vnPayReturn'])->name('payment.vnpay.return');
Route::match(['GET', 'POST'], '/payment/vnpay/ipn', [PaymentController::class, 'vnPayIpn'])->name('payment.vnpay.ipn');

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

Route::get('/seed-products', function () {
    $exists = \App\Models\Product::count();
    if ($exists > 0) {
        return response()->json(['ok' => true, 'message' => 'exists']);
    }
    $rows = [
        ['product_name'=>'Quả sầu riêng','product_detailDesc'=>'Sầu riêng Thái, cơm vàng đậm, mùi thơm nồng, hạt lép.','product_shortDesc'=>'Sầu riêng Thái.','product_price'=>100000,'product_factory'=>'FoodMap','product_target'=>'Ăn tươi - làm bánh','product_type'=>'Trái cây tươi','product_quantity'=>100,'product_image_url'=>'1.jpg'],
        ['product_name'=>'Táo đỏ Mỹ','product_detailDesc'=>'Táo nhập khẩu Mỹ, quả to, vị ngọt, giòn, giàu dinh dưỡng.','product_shortDesc'=>'Táo Mỹ giòn, ngọt.','product_price'=>120000,'product_factory'=>'Vinfruits','product_target'=>'Ăn tươi','product_type'=>'Trái cây nhập khẩu','product_quantity'=>80,'product_image_url'=>'2.jpg'],
        ['product_name'=>'Cam sành Việt Nam','product_detailDesc'=>'Cam sành nhiều nước, vị ngọt thanh, chứa nhiều vitamin C.','product_shortDesc'=>'Cam sành mọng nước.','product_price'=>70000,'product_factory'=>'Nông trại Việt','product_target'=>'Ăn tươi - vắt nước','product_type'=>'Trái cây nội địa','product_quantity'=>90,'product_image_url'=>'3.jpg'],
        ['product_name'=>'Chuối Laba','product_detailDesc'=>'Chuối đặc sản Lâm Đồng, quả to, thơm ngon, ngọt đậm.','product_shortDesc'=>'Chuối Laba ngọt.','product_price'=>50000,'product_factory'=>'Nông trại Đà Lạt','product_target'=>'Ăn tươi - làm bánh','product_type'=>'Trái cây nội địa','product_quantity'=>120,'product_image_url'=>'4.jpg'],
        ['product_name'=>'Xoài cát Hòa Lộc','product_detailDesc'=>'Xoài Hòa Lộc ngọt đậm, thịt dẻo, hương thơm đặc trưng.','product_shortDesc'=>'Xoài Hòa Lộc ngọt.','product_price'=>140000,'product_factory'=>'VietGAP','product_target'=>'Ăn tươi - sinh tố','product_type'=>'Trái cây nội địa','product_quantity'=>60,'product_image_url'=>'5.jpg'],
        ['product_name'=>'Bưởi da xanh','product_detailDesc'=>'Bưởi da xanh múi to, không hạt, vị ngọt thanh mát.','product_shortDesc'=>'Bưởi da xanh ngon.','product_price'=>90000,'product_factory'=>'Bến Tre Fruits','product_target'=>'Ăn tươi - làm salad','product_type'=>'Trái cây nội địa','product_quantity'=>75,'product_image_url'=>'6.jpg'],
        ['product_name'=>'Dưa hấu ruột đỏ','product_detailDesc'=>'Dưa hấu ruột đỏ, vỏ mỏng, ngọt mát, trồng theo tiêu chuẩn sạch.','product_shortDesc'=>'Dưa hấu đỏ, ngọt.','product_price'=>40000,'product_factory'=>'Farm Fresh','product_target'=>'Ăn tươi - ép nước','product_type'=>'Trái cây nội địa','product_quantity'=>110,'product_image_url'=>'7.jpg'],
        ['product_name'=>'Lê Hàn Quốc','product_detailDesc'=>'Lê nhập khẩu Hàn Quốc, quả to, vị ngọt mát, nhiều nước.','product_shortDesc'=>'Lê Hàn Quốc ngọt.','product_price'=>150000,'product_factory'=>'KoreaFruit','product_target'=>'Ăn tươi','product_type'=>'Trái cây nhập khẩu','product_quantity'=>50,'product_image_url'=>'8.jpg'],
        ['product_name'=>'Nho Mỹ không hạt','product_detailDesc'=>'Nho Mỹ quả to, vỏ mỏng, vị ngọt đậm, giàu dinh dưỡng.','product_shortDesc'=>'Nho Mỹ không hạt.','product_price'=>200000,'product_factory'=>'USA Fruit','product_target'=>'Ăn tươi - làm bánh','product_type'=>'Trái cây nhập khẩu','product_quantity'=>40,'product_image_url'=>'9.jpg'],
        ['product_name'=>'Mít Thái','product_detailDesc'=>'Mít Thái siêu ngọt, múi to, vàng óng, giàu vitamin.','product_shortDesc'=>'Mít Thái thơm, ngọt.','product_price'=>60000,'product_factory'=>'Nông sản Việt','product_target'=>'Ăn tươi','product_type'=>'Trái cây nội địa','product_quantity'=>95,'product_image_url'=>'10.jpg'],
        ['product_name'=>'Dâu tây Đà Lạt','product_detailDesc'=>'Dâu tây đỏ mọng, vị chua ngọt tự nhiên, trồng công nghệ cao.','product_shortDesc'=>'Dâu Đà Lạt đỏ mọng.','product_price'=>250000,'product_factory'=>'FreshFarm','product_target'=>'Ăn tươi - làm bánh','product_type'=>'Trái cây nội địa','product_quantity'=>35,'product_image_url'=>'11.jpg'],
        ['product_name'=>'Sầu riêng Ri6','product_detailDesc'=>'Sầu riêng Ri6, cơm vàng đậm, hạt lép, vị béo ngọt.','product_shortDesc'=>'Sầu riêng Ri6 béo.','product_price'=>300000,'product_factory'=>'Bến Tre Fruits','product_target'=>'Ăn tươi - làm bánh','product_type'=>'Trái cây nội địa','product_quantity'=>25,'product_image_url'=>'12.jpg'],
    ];
    foreach ($rows as $row) { \App\Models\Product::create($row); }
    return response()->json(['ok' => true, 'seeded' => count($rows)]);
});

Route::get('/debug-db', function () {
    $out = [];
    $out['env'] = [
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_HOST' => env('DB_HOST'),
        'DB_PORT' => env('DB_PORT'),
        'DB_DATABASE' => env('DB_DATABASE'),
        'DB_USERNAME' => env('DB_USERNAME'),
        'DB_SSLMODE' => env('DB_SSLMODE'),
        'DATABASE_URL' => env('DATABASE_URL'),
    ];
    try {
        $out['driver'] = DB::connection()->getDriverName();
        $out['database'] = DB::connection()->getDatabaseName();
        $out['version'] = DB::select('select version() as v')[0]->v ?? null;
    } catch (\Throwable $e) {
        $out['error'] = $e->getMessage();
    }
    try {
        $out['has_products_table'] = Schema::hasTable('products');
        $out['products_count'] = $out['has_products_table'] ? \App\Models\Product::count() : null;
    } catch (\Throwable $e) {
        $out['products_error'] = $e->getMessage();
    }
    return response()->json($out);
});

Route::get('/storage-link', function () {
    try {
        Artisan::call('storage:link');
        return nl2br(Artisan::output());
    } catch (\Throwable $e) {
        return '❌ Lỗi: ' . $e->getMessage();
    }
});
