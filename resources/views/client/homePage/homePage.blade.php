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





    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">Thực phẩm hữu cơ 100%</h4>
                    <h1 class="mb-5 display-3 text-primary">Rau củ quả hữu cơ & Thực phẩm</h1>
                    <div class="position-relative mx-auto">
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="../img/hero-img-1.png" class="img-fluid w-100 h-100 bg-secondary rounded"
                                    alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Fruites</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="../img/hero-img-2.jpg" class="img-fluid w-100 h-100 rounded"
                                    alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Vesitables</a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->



    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Tất cả sản phẩm</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill"
                                    href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">All Products</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($products as $product)
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img loading="lazy"
                                                    src="{{ asset('storage/products/' . $product->product_image_url) }}"
                                                    class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Fruits</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4 style="font-size: 15px;">
                                                    <a href="/product/{{ $product->id }}"
                                                        class="text-decoration-none text-dark">
                                                        {{ $product->product_name }}
                                                    </a>
                                                </h4>
                                                <p style="font-size: 13px;">{{ $product->product_shortDesc }}</p>
                                                <div class="d-flex flex-column align-items-center">
                                                    <p style="font-size: 15px; text-align: center; width: 100%;"
                                                        class="text-dark fw-bold mb-2">
                                                        {{ number_format($product->product_price, 0, ',', '.') }} đ
                                                    </p>
                                                    <form class="add-to-cart-form"
                                                        action="/add-product-to-cart/{{ $product->id }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit"
                                                            class="btn btn-primary border-0 rounded-pill px-4 py-2 text-white w-100">
                                                            <i class="fa fa-shopping-bag me-2"></i> Add to cart
                                                        </button>
                                                    </form>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->



    <!-- Vesitable Shop Start-->
    <div class="container-fluid vesitable">
        <div class="container py-5">
            <h1 class="mb-0">Tất cả sản phẩm</h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                @foreach ($allproduct as $product)
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <img src="{{ asset('storage/products/' . $product->product_image_url) }}"
                            class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                        style="top: 10px; right: 10px;">Vegetable</div>
                    <div class="p-4 rounded-bottom">
                        <h4>{{ $product->product_name }}</h4>
                        <p>{{ $product->product_shortDesc }}</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">
                                {{ number_format($product->product_price, 0, ',', '.') }}đ</p>
                            <form class="add-to-cart-form" action="/add-product-to-cart/{{ $product->id }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="btn btn-primary border-0 rounded-pill px-4 py-2 text-white w-100">
                                    <i class="fa fa-shopping-bag me-2"></i> Add to cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Vesitable Shop End -->



    <!-- Bestsaler Product Start -->
    <div class="container-fluid">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                <h1 class="display-4">Sảm phẩm giảm giá</h1>
                <p style="color: red; font-size: 20px;">Sản phẩm chỉ được giảm giá khi mua trực tiếp tại
                    cửa hàng</p>
            </div>
            <div class="row g-4">
                @foreach ($productDiscounts as $productDiscount)
                <div class="col-lg-6 col-xl-4">
                    <div class="p-4 rounded bg-light position-relative">
                        <div class="row align-items-center">
                            <div class="col-6 position-relative">
                                <img src="{{ asset('storage/products/' . $productDiscount->product->product_image_url) }}"
                                    style="object-fit: cover; height: 140px; width: 140px;"
                                    class="img-fluid rounded-circle" alt="" />
                                <span style="font-size: 20px;"
                                    class="rounded-sm badge bg-danger position-absolute top-0 start-0 translate-middle-y">
                                    -{{ $productDiscount->discount_percent }}%
                                </span>
                            </div>
                            <div class="col-6">
                                <a href="#" class="h5">{{ $productDiscount->product->product_name }}</a>
                                <div class="d-flex my-3">
                                    @for ($i = 1; $i <= 5; $i++) <i
                                        class="fa fa-star {{ $i <= $productDiscount->product->star ? 'text-secondary' : 'text-muted' }}">
                                        </i>
                                        @endfor
                                </div>
                                @php
                                $originalPrice = $productDiscount->product->product_price;
                                $discount = $productDiscount->discount_percent;
                                $finalPrice = $originalPrice - ($originalPrice * $discount / 100);
                                @endphp

                                <h4 class="mb-1 text-danger">
                                    {{ number_format($finalPrice, 0, ',', '.') }}₫
                                </h4>
                                <small class="text-muted text-decoration-line-through">
                                    {{ number_format($originalPrice, 0, ',', '.') }}₫
                                </small>

                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $productDiscounts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <!-- Bestsaler Product End -->



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