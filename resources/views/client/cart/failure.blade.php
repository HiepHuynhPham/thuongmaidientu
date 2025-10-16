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






    <!-- 404 Start -->
    <div style="margin-top: 130px;" class="container-fluid ">
        <div class="container py-5 text-center">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <i style="font-size: 120px;" class="far fa-smile"></i>
                    <h1 class="display-3">Đặt hàng thành công</h1>
                    <h1 class="mb-4">Cảm ơn bạn đã mua hàng</h1>
                    <p class="mb-4">Laptopshop - Uy tín - chất lượng</p>
                    <a class="btn border-secondary rounded-pill py-3 px-5" href="/">Go Back To Home</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 End -->

    <div class="container-fluid featurs">
        <div class="container">
            <div class="row g-4" style="justify-content: center;">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i style="color: rgb(255, 4, 4); font-size: 60px;" class="fas fa-times"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>ĐẶT HÀNG KHÔNG THÀNH CÔNG</h5>
                            <p class="mb-0">Đơn hàng sẽ không được xác nhận</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6 col-lg-3">
                                    <div class="featurs-item text-center rounded bg-light p-4">
                                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                            <i style="color: white; font-size: 60px;" class="far fa-calendar-check"></i>
                                        </div>
                                        <div class="featurs-content text-center">
                                            <h5>HÀNG ĐƯỢC XÁC NHẬN</h5>
                                            <p class="mb-0">Hàng đến tay bạn sau 5 - 7 ngày</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="featurs-item text-center rounded bg-light p-4">
                                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">

                                            <i class="fas fa-car-side fa-3x text-white"></i>
                                        </div>
                                        <div class="featurs-content text-center">
                                            <h5>ĐANG ĐƯỢC VẬN CHUYỂN</h5>
                                            <p class="mb-0">Đơn hàng sắp đến tay bạn</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="featurs-item text-center rounded bg-light p-4">
                                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                            <i style="color: white; font-size: 60px;" class="fas fa-people-carry"></i>
                                        </div>
                                        <div class="featurs-content text-center">
                                            <h5>HÀNG ĐÃ ĐƯỢC GIAO</h5>
                                            <p class="mb-0">Đổi trả miễn phí</p>
                                        </div>
                                    </div>
                                </div> -->

            </div>
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