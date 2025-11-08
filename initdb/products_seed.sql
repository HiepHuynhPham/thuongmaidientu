-- Seed only data for `products` table
USE fruitshop;

INSERT INTO `products` (`id`, `product_name`, `product_detailDesc`, `product_shortDesc`, `product_price`, `product_factory`, `product_target`, `product_type`, `product_quantity`, `product_image_url`, `created_at`, `updated_at`) VALUES
(1, 'Quả sầu riêng', 'Sầu riêng Thái, cơm vàng đậm, mùi thơm nồng, hạt lép.', 'Sầu riêng Thái.', 100000.00, 'FoodMap', 'Ăn tươi - làm bánh', 'Trái cây tươi', 100, '1.jpg', NULL, NULL),
(2, 'Táo đỏ Mỹ', 'Táo nhập khẩu Mỹ, quả to, vị ngọt, giòn, giàu dinh dưỡng.', 'Táo Mỹ giòn, ngọt.', 120000.00, 'Vinfruits', 'Ăn tươi', 'Trái cây nhập khẩu', 80, '2.jpg', NULL, NULL),
(3, 'Cam sành Việt Nam', 'Cam sành nhiều nước, vị ngọt thanh, chứa nhiều vitamin C.', 'Cam sành mọng nước.', 70000.00, 'Nông trại Việt', 'Ăn tươi - vắt nước', 'Trái cây nội địa', 90, '3.jpg', NULL, NULL),
(4, 'Chuối Laba', 'Chuối đặc sản Lâm Đồng, quả to, thơm ngon, ngọt đậm.', 'Chuối Laba ngọt.', 50000.00, 'Nông trại Đà Lạt', 'Ăn tươi - làm bánh', 'Trái cây nội địa', 120, '4.jpg', NULL, NULL),
(5, 'Xoài cát Hòa Lộc', 'Xoài Hòa Lộc ngọt đậm, thịt dẻo, hương thơm đặc trưng.', 'Xoài Hòa Lộc ngọt.', 140000.00, 'VietGAP', 'Ăn tươi - sinh tố', 'Trái cây nội địa', 60, '5.jpg', NULL, NULL),
(6, 'Bưởi da xanh', 'Bưởi da xanh múi to, không hạt, vị ngọt thanh mát.', 'Bưởi da xanh ngon.', 90000.00, 'Bến Tre Fruits', 'Ăn tươi - làm salad', 'Trái cây nội địa', 75, '6.jpg', NULL, NULL),
(7, 'Dưa hấu ruột đỏ', 'Dưa hấu ruột đỏ, vỏ mỏng, ngọt mát, trồng theo tiêu chuẩn sạch.', 'Dưa hấu đỏ, ngọt.', 40000.00, 'Farm Fresh', 'Ăn tươi - ép nước', 'Trái cây nội địa', 110, '7.jpg', NULL, NULL),
(8, 'Lê Hàn Quốc', 'Lê nhập khẩu Hàn Quốc, quả to, vị ngọt mát, nhiều nước.', 'Lê Hàn Quốc ngọt.', 150000.00, 'KoreaFruit', 'Ăn tươi', 'Trái cây nhập khẩu', 50, '8.jpg', NULL, NULL),
(9, 'Nho Mỹ không hạt', 'Nho Mỹ quả to, vỏ mỏng, vị ngọt đậm, giàu dinh dưỡng.', 'Nho Mỹ không hạt.', 200000.00, 'USA Fruit', 'Ăn tươi - làm bánh', 'Trái cây nhập khẩu', 40, '9.jpg', NULL, NULL),
(10, 'Mít Thái', 'Mít Thái siêu ngọt, múi to, vàng óng, giàu vitamin.', 'Mít Thái thơm, ngọt.', 60000.00, 'Nông sản Việt', 'Ăn tươi', 'Trái cây nội địa', 95, '10.jpg', NULL, NULL),
(11, 'Dâu tây Đà Lạt', 'Dâu tây đỏ mọng, vị chua ngọt tự nhiên, trồng công nghệ cao.', 'Dâu Đà Lạt đỏ mọng.', 250000.00, 'FreshFarm', 'Ăn tươi - làm bánh', 'Trái cây nội địa', 35, '11.jpg', NULL, NULL),
(12, 'Sầu riêng Ri6', 'Sầu riêng Ri6, cơm vàng đậm, hạt lép, vị béo ngọt.', 'Sầu riêng Ri6 béo.', 300000.00, 'Bến Tre Fruits', 'Ăn tươi - làm bánh', 'Trái cây nội địa', 25, '12.jpg', NULL, NULL),
(13, 'Ổi lê Đài Loan', 'Ổi lê Đài Loan, vỏ xanh, ruột trắng, giòn ngọt, ít hạt.', 'Ổi lê Đài Loan giòn.', 50000.00, 'Nông sản Việt', 'Ăn tươi', 'Trái cây nội địa', 85, '13.jpg', NULL, NULL),
(14, 'Chôm chôm nhãn', 'Chôm chôm nhãn vỏ mỏng, thịt trắng dày, vị ngọt.', 'Chôm chôm nhãn ngọt.', 80000.00, 'Miền Tây Fruits', 'Ăn tươi', 'Trái cây nội địa', 70, '14.jpg', NULL, NULL),
(15, 'Thanh long ruột đỏ', 'Thanh long ruột đỏ ngọt dịu, nhiều nước, tốt cho sức khỏe.', 'Thanh long ruột đỏ.', 70000.00, 'Bình Thuận Fruits', 'Ăn tươi - làm sinh tố', 'Trái cây nội địa', 90, '15.jpg', NULL, NULL),
(16, 'Dưa lưới Nhật', 'Dưa lưới Nhật Bản, vị ngọt thanh, thịt giòn, thơm nhẹ.', 'Dưa lưới Nhật.', 180000.00, 'Japan Fruits', 'Ăn tươi - ép nước', 'Trái cây nhập khẩu', 30, '16.jpg', NULL, NULL),
(17, 'Lựu đỏ Ấn Độ', 'Lựu đỏ nhập khẩu Ấn Độ, hạt mọng nước, vị ngọt thanh.', 'Lựu đỏ Ấn Độ.', 130000.00, 'Indian Fruits', 'Ăn tươi', 'Trái cây nhập khẩu', 55, '17.jpg', NULL, NULL),
(18, 'Mận hậu Sơn La', 'Mận hậu Sơn La, vỏ đỏ, vị chua nhẹ, ngọt thanh, giòn.', 'Mận hậu Sơn La.', 60000.00, 'Nông sản Việt', 'Ăn tươi', 'Trái cây nội địa', 100, '18.jpg', NULL, NULL),
(19, 'Bơ 034', 'Bơ 034 Lâm Đồng, vỏ xanh, cơm dẻo, vị béo ngậy, ít xơ.', 'Bơ 034 béo.', 80000.00, 'Đà Lạt Fruits', 'Ăn tươi - làm sinh tố', 'Trái cây nội địa', 85, '19.jpg', NULL, NULL),
(20, 'Măng cụt Thái', 'Măng cụt Thái, vỏ mỏng, ruột trắng, vị ngọt thanh.', 'Măng cụt Thái.', 120000.00, 'Thai Fruits', 'Ăn tươi', 'Trái cây nhập khẩu', 60, '20.jpg', NULL, NULL),
(21, 'Dứa (Thơm) Queen', 'Dứa Queen, ruột vàng, thơm ngọt, ít xơ, giàu vitamin C.', 'Dứa Queen thơm.', 40000.00, 'Nông sản Việt', 'Ăn tươi - làm nước ép', 'Trái cây nội địa', 95, '21.jpg', NULL, NULL),
(22, 'Việt quất Mỹ', 'Việt quất nhập Mỹ, quả nhỏ, giàu chất chống oxy hóa.', 'Việt quất Mỹ.', 280000.00, 'USA Fruits', 'Ăn tươi - làm bánh', 'Trái cây nhập khẩu', 45, '22.jpg', NULL, NULL),
(23, 'Mơ vàng', 'Mơ vàng, vị chua nhẹ, giòn, dùng làm ô mai, nước giải khát.', 'Mơ vàng giòn.', 50000.00, 'Nông sản Việt', 'Ăn tươi - làm ô mai', 'Trái cây nội địa', 90, '23.jpg', NULL, NULL),
(24, 'Hồng giòn Đà Lạt', 'Hồng giòn Đà Lạt, vỏ mỏng, thịt giòn, vị ngọt tự nhiên.', 'Hồng giòn Đà Lạt.', 70000.00, 'Đà Lạt Fruits', 'Ăn tươi', 'Trái cây nội địa', 75, '24.jpg', NULL, NULL),
(25, 'Mít tố nữ', 'Mít tố nữ, múi nhỏ, vị ngọt đậm, thơm đặc trưng.', 'Mít tố nữ thơm.', 60000.00, 'Miền Tây Fruits', 'Ăn tươi', 'Trái cây nội địa', 80, '25.jpg', NULL, NULL);