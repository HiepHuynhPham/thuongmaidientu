<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Fruitables – Trái cây sạch & nhập khẩu, giao hàng nhanh</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Fruitables cung cấp trái cây tươi sạch, trái cây nhập khẩu chất lượng cao. Giao hàng nhanh, giá tốt, đảm bảo an toàn.">
    <meta name="keywords" content="trái cây sạch, trái cây nhập khẩu, trái cây tươi, trái cây giao tận nhà">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="Fruitables – Trái cây sạch & nhập khẩu">
    <meta property="og:description" content="Mua trái cây tươi, sạch, nhập khẩu. Giao nhanh, đảm bảo chất lượng.">
    <meta property="og:image" content="{{ asset('images/seo-fruitables.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    @include('client.layout.header')

    <div class="container py-4" style="margin-top: 90px;">
        <h1 class="mb-4">Fruitables – Cửa hàng trái cây sạch & tươi nhập khẩu</h1>

        <p>
            Fruitables là cửa hàng chuyên cung cấp các loại trái cây sạch, tươi ngon và trái cây nhập khẩu từ nhiều quốc gia khác nhau. 
            Chúng tôi theo đuổi triết lý “Feel Good Food” – mang đến cho bạn nguồn thực phẩm giúp cơ thể khỏe mạnh, tinh thần thoải mái, và trải nghiệm ăn uống tích cực mỗi ngày.
            Tại Fruitables, bạn có thể tìm thấy danh mục phong phú gồm táo đỏ Mỹ, xoài cát Hòa Lộc, việt quất, cam sành, bưởi da xanh, và nhiều loại trái cây đặc sản theo mùa, 
            được tuyển chọn kỹ lưỡng từ nhà vườn đạt tiêu chuẩn an toàn. Mục tiêu của chúng tôi là cung cấp trái cây tươi, có nguồn gốc rõ ràng, giao hàng nhanh, giá hợp lý và dịch vụ chăm sóc khách hàng tận tâm.
        </p>

        <h2 class="mt-4">Vì sao chọn Fruitables?</h2>
        <p>
            Chúng tôi cam kết mang đến chất lượng cao nhất: trái cây không hóa chất độc hại, quy trình bảo quản đúng chuẩn để giữ được hương vị và dinh dưỡng tự nhiên. 
            Hệ thống kiểm soát chất lượng của Fruitables giám sát từng khâu từ chọn lọc, đóng gói đến vận chuyển, giúp sản phẩm đến tay bạn ở trạng thái tươi ngon nhất. 
            Bên cạnh đó, chúng tôi thường xuyên có chương trình ưu đãi, gợi ý dinh dưỡng theo mục tiêu sức khỏe, và đường dây hỗ trợ nhanh để giải đáp mọi thắc mắc.
        </p>

        <h2 class="mt-4">Sản phẩm nổi bật</h2>
        <ul>
            <li>Táo đỏ Mỹ – giàu vitamin C, giòn ngọt dễ ăn, thích hợp cho bữa phụ lành mạnh.</li>
            <li>Xoài cát Hòa Lộc – thơm ngọt tự nhiên, thịt dẻo, phù hợp làm sinh tố hoặc ăn tươi.</li>
            <li>Việt quất – chống oxy hóa mạnh, hỗ trợ tim mạch và làn da, dùng kèm sữa chua càng ngon.</li>
        </ul>

        <h2 class="mt-4">Cam kết & dịch vụ</h2>
        <p>
            Chúng tôi đảm bảo trái cây sạch, có chứng nhận phù hợp, bảo quản đúng nhiệt độ và quy trình để không ảnh hưởng đến chất lượng.
            Dịch vụ giao hàng nhanh đáp ứng nhu cầu dùng trái cây tươi hằng ngày của bạn; tất cả đơn hàng đều được kiểm tra trước khi giao để đảm bảo an tâm. 
            Mọi phản hồi được ghi nhận và xử lý trong thời gian sớm nhất, giúp nâng cao trải nghiệm mua sắm liên tục.
        </p>

        <h2 class="mt-4">Hướng dẫn đặt hàng</h2>
        <p>
            Quy trình đặt hàng rất đơn giản: Chọn sản phẩm → Thêm vào giỏ → Thanh toán → Nhận hàng. 
            Nếu bạn mới bắt đầu, hãy tham khảo danh mục được yêu thích hoặc xem gợi ý theo mùa để chọn trái cây ngon nhất. 
            Đừng quên sử dụng các mã khuyến mãi trong mục ưu đãi để tối ưu chi phí.
        </p>

        <p>
            Xem thêm sản phẩm tại 
            <a href="{{ route('product') }}" class="text-primary">trang danh mục trái cây</a> 
            và trải nghiệm nhiều loại trái cây hấp dẫn.
        </p>

        <p>
            Tham khảo thêm thông tin về chế độ dinh dưỡng, thực phẩm lành mạnh và mẹo ăn uống cân bằng tại 
            <a href="https://www.healthline.com/nutrition" target="_blank" rel="noopener">Healthline Nutrition</a>. 
            Đây là nguồn tham khảo hữu ích giúp bạn xây dựng thói quen ăn uống tích cực, lựa chọn thực phẩm phù hợp với mục tiêu sức khỏe.
        </p>
    </div>

    @include('client.layout.footer')

    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
