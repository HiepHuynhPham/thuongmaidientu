<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;

class DiscountService
{
    public function getAllProduct($perPage = 8){
        return Product::paginate($perPage);
    }

    public function getAllProductDiscount($perPage = 10){
        return ProductDiscount::paginate($perPage);
    }

    public function getAllProductDiscountActive($perPage = 6)
    {
        return ProductDiscount::where('status', 1)->paginate($perPage);
    }


    public function getProductById($id){
        return Product::find($id);
    }

    public function getProducDiscounttById($id){
        return ProductDiscount::find($id);
    }

    public function handleCreateProductDiscount($id, $discount_percent, $start_date, $end_date, $status){

        $product = Product::findOrFail($id);

        if(!$product){
            dd( $product->id);
            return false;
        }
        $existing = ProductDiscount::where('product_id', $product->id)->first();

        if (!$existing) {
            ProductDiscount::create([
                'product_id' => $product->id,
                'discount_percent' => $discount_percent,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $status
            ]);
        }else{
            dd( null);
            return false;
        }
        return true;
    }

    public function handleUpdateProductDiscount($id, $discount_percent, $start_date, $end_date, $status)
    {
        $discount = ProductDiscount::find($id);
    
        if (!$discount) {
            // Không tìm thấy bản ghi, có thể xử lý lỗi hoặc trả về false
            return false;
        }
    
        // Cập nhật các trường cần thiết
        $discount->update([
            'discount_percent' => $discount_percent,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $status
        ]);
    
        return true;
    }

}