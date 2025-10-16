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
    <div style="margin-top: 120px;" class="container-fluid">
        <div class="container py-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thông tin cá nhân</li>
                    </ol>
                </nav>
            </div>
            <div style="width: 20px;" class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    hiến thị thêm
                </button>
                <div style="left: 0px; width: 200px;" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Địa chỉ</a>
                    <a class="dropdown-item" href="/purchase">Đơn mua</a>
                    <a class="dropdown-item" href="#">Kho voucher</a>
                </div>
            </div>

            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <img loading="lazy" src="{{ asset('storage/avatars/' . $user->user_avatar) }}"
                                    alt="avatar" class="rounded-circle img-fluid"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                                <h5 class="my-3">{{ $user->user_name }}</h5>
                                <p class="text-muted mb-1">Email:
                                    {{ session('email', 'Chưa cập nhật') }}
                                </p>
                                <p class="text-muted mb-1">Địa chỉ:
                                    @if(!empty($user->user_address))
                                    {{ $user->user_address }}
                                    @else
                                    {{ session('addefault: dress', 'Chưa cập nhật') }}
                                    @endif
                                </p>

                                <form method="post" action="/update-user-in-profile" id="formupdateuser"
                                    style="display:none;" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control @error('fullName') is-invalid @enderror"
                                            name="user_name" placeholder="Full name"
                                            value="{{ old('fullName', $user->user_name) }}">
                                        @error('fullName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="user_address"
                                            placeholder="Address" value="{{ old('address', $user->user_address) }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="user_phone"
                                            value="{{ $user->user_phone}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="avatarFile" class="form-label">Avatar:</label>
                                        <input class="form-control" type="file" id="avatarFile" name="user_avatar"
                                            accept=".png, .jpg, .jpeg">
                                    </div>
                                    <div class="col-12 mt-3 text-center">
                                        @if($user->user_avatar)
                                        <img id="avatarPreview"
                                            src="{{ asset('storage/avatars/' . $user->user_avatar) }}"
                                            alt="Avatar Preview"
                                            style="display: block; max-width: 100%; max-height: 250px; border-radius: 8px; margin-top: 10px;">
                                        @endif
                                    </div>

                                    <div style="margin-left: -180px;" class="col-12 mt-3">
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="d-flex mb-3">
                            <button class="btn btn-primary me-2" id="openbuttonUpdatedform">Cập nhật thông tin</button>
                            <button class="btn btn-secondary" id="closebuttonUpdatedform" style="display: none;">Không
                                cập nhật</button>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Full Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ session('fullName', 'Chưa cập nhật') }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ session('email', 'Chưa cập nhật') }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">
                                            {{ session('phone', 'Chưa cập nhật') }}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Address</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">
                                            {{ session('address', 'Chưa cập nhật') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 mb-lg-0">
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush rounded-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fas fa-globe fa-lg text-warning"></i>
                                        <p class="mb-0">https://mdbootstrap.com</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-github fa-lg text-body"></i>
                                        <p class="mb-0">github</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                        <p class="mb-0">twitter</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                        <p class="mb-0">instagram</p>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                        <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                        <p class="mb-0">facebook</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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