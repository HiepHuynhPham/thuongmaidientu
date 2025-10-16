<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fruitables - Vegetable Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mã điều khiển form
        const openBtn = document.getElementById("openbuttonUpdatedform");
        const closeBtn = document.getElementById("closebuttonUpdatedform");
        const form = document.getElementById("formupdateuser");

        openBtn.addEventListener("click", function() {
            form.style.display = "block";
            openBtn.style.display = "none";
            closeBtn.style.display = "inline-block";
        });

        closeBtn.addEventListener("click", function() {
            form.style.display = "none";
            openBtn.style.display = "inline-block";
            closeBtn.style.display = "none";
        });

        // Mã xử lý ảnh khi người dùng chọn ảnh mới
        const avatarFile = document.getElementById("avatarFile");
        const avatarPreview = document.getElementById("avatarPreview");

        avatarFile.addEventListener("change", function(e) {
            const imgURL = URL.createObjectURL(e.target.files[0]);
            avatarPreview.src = imgURL;
            avatarPreview.style.display = "block"; // Đảm bảo hình ảnh được hiển thị
        });
    });
    </script>


</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    @extends('client.layout.header')




    <!-- Single Product Start -->
    <div style="margin-top: 70px;" class="container-fluid py-5">
        <div class="container py-5">
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Lịch sử mua hàng</li>
                    </ol>
                </nav>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Giá cả</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                            <!-- <th scope="col">Trạng thái</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders == null || $orders->isEmpty())
                        <tr>
                            <td colspan="6">
                                Không có đơn hàng nào được tạo
                            </td>
                        </tr>
                        @else
                        @foreach ($orders as $order)
                        <tr>
                            <td colspan="2">ĐƠN HÀNG CÓ MÃ SỐ {{ $order->id }}</td>
                            <td colspan="1">
                                {{ number_format($order->total_price, 0, ',', '.') }} đ
                            </td>
                            <td colspan="2"></td>
                            <td colspan="1"></td>
                        </tr>

                        @foreach ($order->orderDetails as $orderDetail)
                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img loading="lazy"
                                        src="{{ asset('storage/products/' . $orderDetail->product->product_image_url) }}"
                                        class="img-fluid me-5 rounded-circle"
                                        style="width: 80px; height: 80px; object-fit: cover;" alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">
                                    <a href="/product/{{ $orderDetail->product->id }}" target="_blank">
                                        {{ $orderDetail->product->product_name }}
                                    </a>
                                </p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">
                                    {{ number_format($orderDetail->price, 0, ',', '.') }} đ
                                </p>
                            </td>
                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">
                                    <input type="text" class="form-control form-control-sm text-center border-0"
                                        value="{{ $orderDetail->quantity }}">
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">
                                    {{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') }} đ
                                </p>
                            </td>
                            <!-- <td>
                                {{-- Trạng thái đơn hàng nếu có --}}
                                {{ $order->status ?? 'Chờ xử lý' }}
                            </td> -->
                        </tr>
                        @endforeach
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <!-- Single Product End -->


    @extends('client.layout.footer')



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            // Lấy giá trị radio được chọn
            let rating = $('input[name="radio-sort"]:checked').val();

            // Gán vào input hidden
            $('#rating-hidden').val(rating);

            // (Tùy chọn) Debug thử
            console.log("Đánh giá được chọn là: " + rating);
        });
    });
    </script>
</body>

</html>