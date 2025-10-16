<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ProductService
{


    public function getAllProduct($perPage = 8)
    {
        return Product::paginate($perPage);
    }

    public function getAllProductShowPage($perPage = 9)
    {
        return Product::paginate($perPage);
    }

    public function getAllProducts()
    {
        return Product::all();
    }

    public function getReviewWithIDProduct($ProductId)
    {
        return $review = Review::where('product_id',$ProductId )->get();
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }

    public function deleteByProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            // Xóa ảnh cũ nếu có
            if ($product->product_image_url) {
                // Kiểm tra nếu đường dẫn ảnh có chứa thư mục 'products'
                $imagePath = 'products/' . $product->product_image_url;
                if (Storage::disk('public')->exists($imagePath)) {
                    // Xóa ảnh cũ
                    Storage::disk('public')->delete($imagePath);
                }
            }

            // Xóa sản phẩm khỏi cơ sở dữ liệu
            $product->delete();

            return true;
        }

        return false;
    }


      public function handleCreateProduct($data)
    {
        // Lưu ảnh sản phẩm (nếu có)
        $imagePath = null;
        if (isset($data['product_image_url'])) {
            $imagePath = $data['product_image_url']->store('products', 'public');
            // Lấy chỉ tên file từ đường dẫn
            $imagePath = basename($imagePath);
        }

        // Tạo sản phẩm
        return Product::create([
            'product_name' => $data['product_name'],
            'product_detailDesc' => $data['product_detailDesc'],
            'product_shortDesc' => $data['product_shortDesc'],
            'product_price' => $data['product_price'],
            'product_factory' => $data['product_factory'],
            'product_target' => $data['product_target'],
            'product_type' => $data['product_type'],
            'product_quantity' => $data['product_quantity'],
            'product_image_url' => $imagePath,  // Lưu đường dẫn ảnh
        ]);
    }


    public function handleUpdateProduct($id, $data)
    {
        $product = Product::find($id);

        if (!$product) {
            return null;
        }

        // Lưu ảnh mới (nếu có) và xóa ảnh cũ
        if (isset($data['product_image_url'])) {
            // Nếu có ảnh cũ, xóa nó
            if ($product->product_image_url) {
                Storage::disk('public')->delete('products/' . $product->product_image_url);
            }
            // Lưu ảnh mới và chỉ lưu tên file
            $data['product_image_url'] = basename($data['product_image_url']->store('products', 'public'));
        } else {
            // Nếu không có ảnh mới, giữ lại ảnh cũ
            $data['product_image_url'] = $product->product_image_url;
        }

        // Cập nhật thông tin sản phẩm
        $product->update([
            'product_name' => $data['product_name'],
            'product_detailDesc' => $data['product_detailDesc'],
            'product_shortDesc' => $data['product_shortDesc'],
            'product_price' => $data['product_price'],
            'product_factory' => $data['product_factory'],
            'product_target' => $data['product_target'],
            'product_type' => $data['product_type'],
            'product_quantity' => $data['product_quantity'],
            'product_image_url' => $data['product_image_url'],  // Cập nhật ảnh
        ]);

        return $product;
    }


    public function filterProducts($filters, $perPage = 9)
    {
        $query = Product::query();

        // Lọc theo tên sản phẩm (search)
        if (!empty($filters['searchValue'])) {
            $query->where('product_name', 'like', '%' . $filters['searchValue'] . '%');
        }

        // Lọc theo hãng sản xuất
        if (!empty($filters['factory'])) {
            $query->whereIn('product_factory', $filters['factory']);
        }

        // Lọc theo loại trái cây
        if (!empty($filters['type'])) {
            $query->whereIn('product_type', $filters['type']);
        }

        // Lọc theo mức giá
        if (!empty($filters['price'])) {
            $query->where(function ($q) use ($filters) {
                foreach ($filters['price'] as $range) {
                    switch ($range) {
                        case 'duoi-100-nghin':
                            $q->orWhere('product_price', '<', 100000);
                            break;
                        case '100-500-nghin':
                            $q->orWhereBetween('product_price', [100000, 500000]);
                            break;
                        case '500-2000-nghin':
                            $q->orWhereBetween('product_price', [500000, 2000000]);
                            break;
                        case 'tren-2-trieu':
                            $q->orWhere('product_price', '>', 2000000);
                            break;
                    }
                }
            });
        }

        // Lọc theo đánh giá
        if (!empty($filters['valueStar'])) {
            $query->where('valueStar', '>=', $filters['valueStar']);
        }

        // Sắp xếp
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'gia-tang-dan':
                    $query->orderBy('product_price', 'asc');
                    break;
                case 'gia-giam-dan':
                    $query->orderBy('product_price', 'desc');
                    break;
            }
        }

        // Phân trang với số sản phẩm mỗi trang
        return $query->paginate($perPage)->appends($filters);
    }


    public function postConfirmComment($userId, $productId, $rating, $comment){
        $user = User::find($userId);

        if (!$user || $userId==null) {
            return false;
        }

        // Kiểm tra sản phẩm tồn tại không
        $product = Product::find($productId);
        if (!$product) {
            return false;
        }

        // Lưu review
        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => (int) $rating,
            'comment' => $comment,
        ]);
        return true;
    }

    public function handleDeleteComment($id){
        $review=Review::find($id);

        if(!$review){
            return false;
        }

        $review->delete();
        return true;
    }
}