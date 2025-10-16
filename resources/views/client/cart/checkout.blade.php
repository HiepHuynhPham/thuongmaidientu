<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fruitables - Vegetable Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="_csrf" content="{{ csrf_token() }}">
    <meta name="_csrf_header" content="X-CSRF-TOKEN">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!--Sử dụng thư viện jQuery Toast:-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

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
    <style>
    .pagination {
        margin-top: 50px;
        display: inline-flex;
        gap: 5px;
    }

    .pagination .page-item .page-link {
        color: #333;
        border-radius: 20px;
        padding: 8px 16px;
        margin: 2px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination .page-item:hover .page-link {
        background-color: #f0f0f0;
        color: #007bff;
    }
    </style>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    @extends('client.layout.header')






    <div style="margin-top: 60px;" class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <div>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Chi tiết giỏ hàng</li>
                    </ol>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($cartDetails))
                        <p>Giỏ hàng trống!</p>
                        @else
                        @foreach ($cartDetails as $cartDetail)
                        <tr>
                            <th class="orderCart" style="display: flex; align-items: center; gap: 15px;" scope="row">

                                <div class="d-flex align-items-center">
                                    <img loading="lazy"
                                        src="{{ asset('storage/products/' . $cartDetail->product->product_image_url) }}"
                                        class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; overflow: hidden; display: flex;
                            justify-content: center; align-items: center; object-fit: cover;" alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">
                                    <a href="/product/{{ $cartDetail->product->id }}" target="_blank">
                                        {{ $cartDetail->product->product_name }}
                                    </a>
                                </p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">
                                    {{ number_format($cartDetail->product->product_price) }} đ
                                </p>
                            </td>
                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">

                                    <input type="text" class="form-control form-control-sm text-center border-0"
                                        value="{{ $cartDetail->cartDetails_quantity }}"
                                        data-cart-detail-id="{{ $cartDetail->id }}"
                                        data-cart-detail-price="{{ $cartDetail->product->product_price }}"
                                        data-cart-detail-index="{{ $loop->index }}">

                                </div>
                            </td>
                            <td>
                                <p class="mb-0 mt-4" data-cart-detail-id="{{ $cartDetail->id }}">
                                    {{ number_format($cartDetail->product->product_price * $cartDetail->cartDetails_quantity) }}
                                    đ
                                </p>
                            </td>

                        </tr>
                        @endforeach
                        <p>Tổng tiền: {{ number_format($totalPrice) }} VND</p>
                        @endif
                    </tbody>

                </table>
            </div>



            @if (!empty($cartDetails))
            <div class="mt-3">
                <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">
                    Áp dụng mã giảm giá
                </button>
            </div>
            @endif

            @if(!empty($cartDetails))
            <form action="/place-order" method="POST">
                @csrf
                <div class="mt-5 row g-4 justify-content-start">
                    <!-- Thông Tin Người Nhận -->
                    <div class="col-12 col-md-6">
                        <div class="p-4">
                            <h5>Thông Tin Người Nhận</h5>
                            <div class="row">
                                <div class="col-12 form-group mb-3">
                                    <label>Tên người nhận</label>
                                    <input class="form-control" name="receiverName" required />
                                </div>
                                <div class="col-12 form-group mb-3">
                                    <label>Địa chỉ người nhận</label>
                                    <input class="form-control" name="receiverAddress" required />
                                </div>
                                <div class="col-12 form-group mb-3">
                                    <label>Số điện thoại</label>
                                    <input class="form-control" name="receiverPhone" required />
                                </div>
                                <div class="mt-4">
                                    <i class="fas fa-arrow-left"></i>
                                    <a href="/cart">Quay lại giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông Tin Thanh Toán -->
                    <div class="col-12 col-md-6">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Thông Tin <span class="fw-normal">Thanh Toán</span></h1>

                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Phí vận chuyển</h5>
                                    <div>
                                        <p class="mb-0">0 đ</p>
                                    </div>
                                </div>

                                <div class="mt-3 d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Hình thức</h5>
                                    <select class="form-select" name="paymentMethod"
                                        aria-label="Default select example">
                                        <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                                        <option value="MOMO">Thanh toán qua MOMO</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tổng Số Tiền -->
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Tổng số tiền</h5>
                                <p class="mb-0 pe-4" data-cart-total-price="{{ $totalPrice }}">
                                    {{ number_format($totalPrice) }} đ
                                </p>
                            </div>

                            <!-- Xác Nhận Thanh Toán -->
                            <button
                                class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                                Xác nhận thanh toán
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @endif



        </div>
    </div>



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
</body>

</html>