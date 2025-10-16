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


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->



    <!-- Fruits Shop Start-->
    <div style="margin-top: -30px;" class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4 mt-5">
                <div class="col-lg-12">

                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">

                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <div class="col-12" id="factoryFilter">
                                            <div class="mb-2"><b>Hãng sản xuất</b></div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-1"
                                                    value="FoodMap">
                                                <label class="form-check-label" for="factory-1">FoodMap</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-2"
                                                    value="Vinfruits">
                                                <label class="form-check-label" for="factory-2">Vinfruits</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-3"
                                                    value="Nông trại Việt">
                                                <label class="form-check-label" for="factory-3">Nông trại Việt</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-4"
                                                    value="Nông trại Đà Lạt">
                                                <label class=" form-check-label" for="factory-4">Nông trại Đà Lạt
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-5"
                                                    value="VietGAP">
                                                <label class="form-check-label" for="factory-5">VietGAP</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-6"
                                                    value="Bến Tre Fruits">
                                                <label class="form-check-label" for="factory-6">Bến Tre Fruits</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-7"
                                                    value="Japan Fruits">
                                                <label class="form-check-label" for="factory-6">Japan Fruits</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-8"
                                                    value="USA Fruits">
                                                <label class="form-check-label" for="factory-6">USA Fruits</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-9"
                                                    value="Đà Lạt Fruits">
                                                <label class="form-check-label" for="factory-6">Đà Lạt Fruits</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-10"
                                                    value="Miền Tây Fruits">
                                                <label class="form-check-label" for="factory-6">Miền Tây Fruits</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="factory-11"
                                                    value="FreshFarm">
                                                <label class="form-check-label" for="factory-6">FreshFarm</label>
                                            </div>

                                        </div>
                                        <div class="col-12" id="typeFilter">
                                            <div class="mb-2"><b>loại trái cây</b></div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="type-1"
                                                    value="Trái cây nhập khẩu">
                                                <label class="form-check-label" for="type-1">Trái cây nhập
                                                    khẩu</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="type-2"
                                                    value="Trái cây nội địa">
                                                <label class="form-check-label" for="type-2">Trái cây nội địa</label>
                                            </div>
                                        </div>
                                        <div class="col-12" id="priceFilter">
                                            <div class="mb-2"><b>Mức giá</b></div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="price-2"
                                                    value="duoi-100-nghin">
                                                <label class="form-check-label" for="price-2">Dưới 100 nghìn</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="price-3"
                                                    value="100-500-nghin">
                                                <label class="form-check-label" for="price-3">Từ 100 - 500
                                                    nghin</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="price-4"
                                                    value="500-2000-nghin">
                                                <label class="form-check-label" for="price-4">Từ 500 nghìn - 2
                                                    triệu</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="price-5"
                                                    value="tren-2-trieu">
                                                <label class="form-check-label" for="price-5">Trên 2 triệu</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-2"><b>Đánh giá</b></div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sort-1" value="1"
                                                    name="radio-star">
                                                <label class="form-check-label" for="sort-1"><i
                                                        class="fa fa-star text-secondary"></i>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sort-2" value="2"
                                                    name="radio-star">
                                                <label class="form-check-label" for="sort-2">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                </label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sort-3" value="3"
                                                    name="radio-star">
                                                <label class="form-check-label" for="sort-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>

                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sort-4" value="4"
                                                    name="radio-star">
                                                <label class="form-check-label" for="sort-4">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>

                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sort-5" value="5"
                                                    name="radio-star">
                                                <label class="form-check-label" for="sort-5">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>

                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-2"><b>Sắp xếp</b></div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sort-1"
                                                    value="gia-tang-dan" name="radio-sort">
                                                <label class="form-check-label" for="sort-1">Giá tăng dần</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sort-2"
                                                    value="gia-giam-dan" name="radio-sort">
                                                <label class="form-check-label" for="sort-2">Giá giảm dần</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="sort-3" checked
                                                    value="gia-nothing" name="radio-sort">
                                                <label class="form-check-label" for="sort-3">Không sắp xếp</label>
                                            </div>

                                        </div>
                                        <div class="col-12">
                                            <button
                                                class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4"
                                                id="btnFilter">
                                                Lọc Sản Phẩm
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <input type="hidden" name="${_csrf.parameterName}" value="${_csrf.token}" />
                            <div class="position-relative mx-auto mb-5">
                                <input name="SearchProduct"
                                    class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill"
                                    type="text" placeholder="Tìm kiếm">
                                <button type="button" id="searchButton"
                                    class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                                    style="top: 0; right: 25%;">Xác nhận</button>
                            </div>
                            <div class="row g-4 justify-content-start">
                                @if ($products->isEmpty())
                                <h3>Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm.</h3>
                                @else
                                @foreach ($products as $product)
                                <div class="col-md-6 col-lg-6 col-xl-4">
                                    <div class="rounded position-relative fruite-item">
                                        <div class="fruite-img">
                                            <img src="{{ asset('storage/products/' . $product->product_image_url) }}"
                                                class="img-fluid w-100 rounded-top" alt="">
                                        </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                            style="top: 10px; left: 10px;">Fruits</div>
                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                            <h4><a href="/product/{{ $product->id }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ $product->product_name }}
                                                </a></h4>
                                            <p>{{ $product->product_shortDesc }}</p>
                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                <p class="text-dark fs-5 fw-bold mb-0">
                                                    {{ number_format($product->product_price, 0, ',', '.') }} đ</p>
                                                <form class="add-to-cart-form"
                                                    action="/add-product-to-cart/{{ $product->id }}" method="POST">
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
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $products->links('pagination::bootstrap-4') }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->


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