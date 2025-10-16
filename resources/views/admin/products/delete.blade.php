<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(() => {
        const avatarFile = $("#avatarFile");
        avatarFile.change(function(e) {
            const imgURL = URL.createObjectURL(e.target.files[0]);
            $("#avatarPreview").attr("src", imgURL).css("display", "block");
        });
    });
    </script>
</head>

<body class="sb-nav-fixed">
    @extends('admin.layout.header')

    <div id="layoutSidenav">
        @extends('admin.layout.sidebar')
        <div id="layoutSidenav_content">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Manage Product</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="/admin/product">Product</a></li>
                    <li class="breadcrumb-item active">Delete</li>
                </ol>
                <div class=" mt-5">
                    <div class="row">
                        <div class="col-md-6 col-12 mx-auto">
                            <h3>Delete a Product</h3>
                            <hr />
                            @if(is_null($product))
                            <div class="alert alert-danger">
                                Không tìm thấy sản phẩm hoặc đã xảy ra lỗi.
                            </div>
                            @else
                            <div class="col-12 mx-auto">
                                <div class="d-flex justify-content-between">
                                    <h3>Delete the product with id = {{ $product->id }}</h3>
                                </div>
                                <hr />
                                <div class="alert alert-danger" role="alert">
                                    Are you sure to delete this user ?
                                </div>
                                <form method="post" action="/admin/product/delete/{{$product->id}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}" />
                                    <div class="mb-3">
                                        <p><strong>Product name:</strong> {{ $product->product_name }}</p>
                                        <p><strong>Product price:</strong> {{ $product->product_price }}</p>
                                        <p><strong>Product factory:</strong> {{ $product->product_factory }}</p>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Confirm</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @extends('admin.layout.footer')
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
</body>

</html>