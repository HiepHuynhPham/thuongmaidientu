<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Login - laptopshop</title>
    <!-- MDB icon -->
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-login-form.min.css') }}" />
</head>

<body>
    <!-- Start your project here-->

    <style>
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    .h-custom {
        height: calc(100% - 73px);
    }

    @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
    }
    </style>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="post" action="/register">
                        @csrf
                        <div class="text-center mb-4">
                            <h3>Đăng ký tài khoản</h3>
                        </div>

                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-normal mb-0 me-3">Đăng ký với</p>
                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-floating mx-1">
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                        </div>

                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0">Hoặc</p>
                        </div>

                        <!-- Hiển thị thông báo lỗi -->
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Tên người dùng -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form3Example1" class="form-control form-control-lg"
                                placeholder="Nhập tên người dùng" name="user_name" required />
                            <label class="form-label" for="form3Example1">Tên người dùng</label>
                        </div>

                        <!-- Email -->
                        <div class="form-outline mb-4">
                            <input type="email" id="form3Example2" class="form-control form-control-lg"
                                placeholder="Nhập địa chỉ email" name="user_email" required />
                            <label class="form-label" for="form3Example2">Địa chỉ Email</label>
                        </div>

                        <!-- Mật khẩu -->
                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Nhập mật khẩu" name="user_password" required />
                            <label class="form-label" for="form3Example3">Mật khẩu</label>
                        </div>

                        <!-- Nhập lại mật khẩu -->
                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example4" class="form-control form-control-lg"
                                placeholder="Nhập lại mật khẩu" name="user_password_confirmation" required />
                            <label class="form-label" for="form3Example4">Xác nhận mật khẩu</label>
                        </div>

                        <!-- Số điện thoại -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form3Example5" class="form-control form-control-lg"
                                placeholder="Nhập số điện thoại" name="user_phone" required />
                            <label class="form-label" for="form3Example5">Số điện thoại</label>
                        </div>

                        <!-- Địa chỉ -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form3Example6" class="form-control form-control-lg"
                                placeholder="Nhập địa chỉ" name="user_address" required />
                            <label class="form-label" for="form3Example6">Địa chỉ</label>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng ký</button>
                        </div>
                    </form>



                    <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="/login"
                            class="link-danger">Login</a></p>
                </div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Copyright © 2020. All rights reserved.
            </div>
            <!-- Copyright -->

            <!-- Right -->
            <div>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#!" class="text-white">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
            <!-- Right -->
        </div>
    </section>
    <!-- End your project here-->

    <!-- MDB -->
    <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
    <!-- Custom scripts -->
    <script type="text/javascript"></script>
</body>

</html>