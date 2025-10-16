<?php

namespace App\Http\Controllers;
use App\Services\DiscountService;
use Illuminate\Http\Request;
class DiscountController extends Controller{

    private $discountService;

    public function __construct(DiscountService $discountService){
        $this->discountService=$discountService;
    }

    public function getAllProductAndProductDiscount(){
        $products=$this->discountService->getAllProduct();
        $productsDiscounts=$this->discountService->getAllProductDiscount();
        return view('admin.discount.show', compact('products', 'productsDiscounts'));
    }

    public function detailProduct($id){
        try {
            $product=$this->discountService->getProductById($id);
            if(!$product){
                return view('admin.products.detail', ['product'=>null]);
            }
            return view('admin.discount.detail', compact('product'));
        } catch (\Throwable $th) {
            return view('admin.discount.detail', ['product'=>null]);
        }
    }

    public function detailProductDiscount($id){
        try {
            $productDiscount=$this->discountService->getProducDiscounttById($id);
            if(!$productDiscount){
                return view('admin.products.detailDiscount', ['productDiscount'=>null]);
            }
            return view('admin.discount.detailDiscount', compact('productDiscount'));
        } catch (\Throwable $th) {
            return view('admin.discount.detailDiscount', ['productDiscount'=>null]);
        }
    }

    public function updateProductDiscount($id){
        try {
            $productDiscount=$this->discountService->getProducDiscounttById($id);
            if(!$productDiscount){
                return view('admin.products.update', ['productDiscount'=>null]);
            }
            return view('admin.discount.update', compact('productDiscount'));
        } catch (\Throwable $th) {
            return view('admin.discount.update', ['productDiscount'=>null]);
        }
    }

    public function createProductDiscount($id){
        try {
            $product=$this->discountService->getProductById($id);
            if(!$product){
                return view('admin.products.create', ['product'=>null]);
            }
            return view('admin.discount.create', compact('product'));
        } catch (\Throwable $th) {
            return view('admin.discount.create', ['product'=>null]);
        }
    }

    public function postCreateProductDiscount(Request $request, $id)
    {
        try {
            $request->validate([
                'discount_percent' => 'required|numeric|min:1|max:100',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $discount_percent=$request->discount_percent;
            $start_date=$request->start_date;
            $end_date=$request->end_date;
            $status = (int) $request->status;


            if(!$this->discountService->handleCreateProductDiscount($id, $discount_percent, $start_date, $end_date, $status)){
                return redirect('/admin/discount')->with('error', 'tạo sản phẩm giảm giá bị lỗi!');
            }
            return redirect('/admin/discount')->with('success', 'tạo sản phẩm giảm giá thành công');
        } catch (\Throwable $th) {
            return redirect('/admin/discount')->with('error', 'tạo sản phẩm giảm giá bị lỗi!');
        }
    }

    public function postUpdateProductDiscount(Request $request, $id)
    {
        try {
            $request->validate([
                'discount_percent' => 'required|numeric|min:1|max:100',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $discount_percent=$request->discount_percent;
            $start_date=$request->start_date;
            $end_date=$request->end_date;
            $status = (int) $request->status;


            if(!$this->discountService->handleUpdateProductDiscount($id, $discount_percent, $start_date, $end_date, $status)){
                return redirect('/admin/discount')->with('error', 'tạo sản phẩm giảm giá bị lỗi!');
            }
            return redirect('/admin/discount')->with('success', 'tạo sản phẩm giảm giá thành công');
        } catch (\Throwable $th) {
            return redirect('/admin/discount')->with('error', 'tạo sản phẩm giảm giá bị lỗi!');
        }
    }
}