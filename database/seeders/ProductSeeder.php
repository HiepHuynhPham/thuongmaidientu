<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
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
        foreach ($rows as $row) {
            Product::firstOrCreate(['product_name' => $row['product_name']], $row);
        }
    }
}
