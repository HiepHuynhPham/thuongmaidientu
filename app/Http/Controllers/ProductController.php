<?php

namespace App\Http\Controllers;
use App\Services\ProductService;
use App\Services\DiscountService;
use Illuminate\Http\Request;
class ProductController extends Controller{
    private $productService;
    private $discountService;

    public function __construct(ProductService $productService, DiscountService $discountService){
        $this->productService = $productService;
        $this->discountService = $discountService;
    }

    public function getAllProduct()
    {
        $products = $this->productService->getAllProduct();
        return view('admin.products.show', compact('products'));
    }

    

    // Hiển thị form tạo sản phẩm
    public function createProduct()
    {
        return view('admin.products.create');
    }

    // Xem chi tiết sản phẩm
    public function detailProduct($id)
    {
        try {
            $product = $this->productService->getProductById($id);
            if (!$product) {
                return view('admin.products.detail', ['product'=>null]);
            }
            return view('admin.products.detail', compact('product'));
        } catch (\Throwable $th) {
            return view('admin.products.detail', ['product'=>null]);
        }
        
    }

    

    public function getProductDetailPage($id){
        $product = $this->productService->getProductById($id);
        $reviews = $this->productService->getReviewWithIDProduct($id);
        $allproduct= $this->productService->getAllProducts();
        $productDiscounts = $this->discountService->getAllProductDiscountActive();
        return view('client.product.detail', compact('product','allproduct', 'reviews', 'productDiscounts' ));
    }


    public function getProductShowPage(){
        $allproduct= $this->productService->getAllProductShowPage();
        return view('client.product.show', compact('allproduct',));
    }


    // Xử lý tạo sản phẩm
    public function handleCreateProduct(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_detailDesc' => 'required|string',
            'product_shortDesc' => 'nullable|string|max:500',
            'product_price' => 'required|numeric|min:0',
            'product_factory' => 'required|string|max:255',
            'product_target' => 'nullable|string|max:255',
            'product_type' => 'required|string|max:100',
            'product_quantity' => 'required|integer|min:0',
            'product_image_url' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        // Tạo sản phẩm qua Service
        $this->productService->handleCreateProduct($request->all());

        return redirect('/admin/product')->with('success', 'Product created successfully!');
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function updateProduct($id)
    {
        try {
            $product = $this->productService->getProductById($id);

            if (!$product) {
                return view('admin.products.update', ['product'=>null]);
            }

            return view('admin.products.update', compact('product'));
        } catch (\Throwable $th) {
            return view('admin.products.update', ['product'=>null]);
        }
        
    }

    // Xử lý cập nhật sản phẩm
    public function handleUpdateProduct(Request $request, $id)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_detailDesc' => 'required|string',
            'product_shortDesc' => 'nullable|string|max:500',
            'product_price' => 'required|numeric|min:0',
            'product_factory' => 'required|string|max:255',
            'product_target' => 'nullable|string|max:255',
            'product_type' => 'required|string|max:100',
            'product_quantity' => 'required|integer|min:0',
            'product_image_url' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        // Cập nhật thông tin sản phẩm qua Service
        $this->productService->handleUpdateProduct($id, $validatedData);

        return redirect('/admin/product')->with('success', 'Product updated successfully!');
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        try {
           $product = $this->productService->getProductById($id);

            if (!$product) {
                return view('admin.products.delete', ['product'=>null]);
            }

            return view('admin.products.delete', compact('product'));
        } catch (\Throwable $th) {
            return view('admin.products.delete', ['product'=>null]);
        }
        
    }

    // Xử lý xóa sản phẩm
    public function handleDeleteProduct($id)
    {
        // Xóa sản phẩm qua Service
        $this->productService->deleteByProduct($id);

        return redirect('/admin/product')->with('success', 'Product deleted successfully!');
    }

    public function filterProducts(Request $request)
    {
        $filters = [
            'searchValue' => $request->input('searchValue'),
            'factory' => $request->has('factory') ? (is_string($request->input('factory')) ? explode(',', $request->input('factory')) : $request->input('factory')) : [],
            'type' => $request->has('type') ? (is_string($request->input('type')) ? explode(',', $request->input('type')) : $request->input('type')) : [],
            'price' => $request->has('price') ? (is_string($request->input('price')) ? explode(',', $request->input('price')) : $request->input('price')) : [],
            'valueStar' => $request->input('valueStar'),
            'sort' => $request->input('sort'),
        ];


        $perPage = $request->input('per_page', 9); // Số sản phẩm mỗi trang

        $products = $this->productService->filterProducts($filters, $perPage);

         if ($request->ajax()) {
        return view('client.product.show', compact('products'))->render();
    }

        return view('client.product.show', compact('products'));
    }

    public function postConfirmComment(Request $request)
    {
        try {
            $rating = $request->input('radio-sort');
            $comment = $request->input('description');
            $productId = $request->input('id');

            // Lấy người dùng hiện tại từ session (giả sử đã login)
            $userId = session('user_id');
            if(!$this->productService->postConfirmComment($userId, $productId, $rating, $comment )){
                return redirect('/login')->with('user', 'bạn cần đăng nhập!');
            }
            // Chuyển hướng lại trang sản phẩm
            return redirect('/product/' . $productId)->with('success', 'Cảm ơn bạn đã đánh giá!');
        } catch (\Throwable $th) {
            return redirect('/login')->with('user', 'bạn cần đăng nhập!');
        }
    }

    public function postDeleteComment(Request $request, $id)
    {
        try {
            $productId=$request->input('productId');
            if(!$id){
                return redirect('/product/' . $productId)->with('error', 'Không có id comment');
            }

            if(!$this->productService->handleDeleteComment($id)){
                return redirect('/product/' . $productId)->with('error', 'Không có id comment');
            }

            return redirect('/product/' . $productId)->with('success', 'xóa thành công');
        } catch (\Throwable $th) {
            return redirect('/')->with('error', 'Không có id comment');
        }
    }
}