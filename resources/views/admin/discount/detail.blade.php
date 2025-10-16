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
        const productImageFile = $("#productImageFile");
        productImageFile.change(function(e) {
            const imgURL = URL.createObjectURL(e.target.files[0]);
            $("#productImagePreview").attr("src", imgURL).css("display", "block");
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
                    <li class="breadcrumb-item active"><a href="/admin/user">Product</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
                <div class=" mt-5">
                    <div class="row">
                        <div class="col-md-6 col-12 mx-auto">
                            <h3>Update a Product</h3>
                            <hr />
                            @if(is_null($product))
                            <div class="alert alert-danger">
                                Không tìm thấy sản phẩm hoặc đã xảy ra lỗi.
                            </div>
                            @else
                            <form method="get" enctype="multipart/form-data" class="row g-3 p-3">
                                @csrf
                                <div class="col-md-12">
                                    <label for="product_name" class="form-label">Product Name:</label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                        id="product_name" name="product_name" placeholder="Enter product name"
                                        value="{{ $product->product_name }}" disabled>
                                    @error('product_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="product_shortDesc" class="form-label">Short Description:</label>
                                    <input type="text"
                                        class="form-control @error('product_shortDesc') is-invalid @enderror"
                                        id="product_shortDesc" name="product_shortDesc"
                                        placeholder="Enter short description" value="{{ $product->product_shortDesc }}"
                                        disabled>
                                    @error('product_shortDesc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="product_detailDesc" class="form-label">Detailed Description:</label>
                                    <textarea class="form-control @error('product_detailDesc') is-invalid @enderror"
                                        id="product_detailDesc" name="product_detailDesc"
                                        placeholder="Enter detailed description"
                                        disabled>{{ old('product_detailDesc', $product->product_detailDesc) }}</textarea>
                                    @error('product_detailDesc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="product_price" class="form-label">Price:</label>
                                    <input type="number"
                                        class="form-control @error('product_price') is-invalid @enderror"
                                        id="product_price" name="product_price" placeholder="Enter price"
                                        value="{{ $product->product_price }}" disabled>
                                    @error('product_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="product_quantity" class="form-label">Quantity:</label>
                                    <input type="number"
                                        class="form-control @error('product_quantity') is-invalid @enderror"
                                        id="product_quantity" name="product_quantity" placeholder="Enter quantity"
                                        value="{{ $product->product_quantity }}" disabled>
                                    @error('product_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="product_factory" class="form-label">Factory:</label>
                                    <input type="text"
                                        class="form-control @error('product_factory') is-invalid @enderror"
                                        id="product_factory" name="product_factory" placeholder="Enter factory name"
                                        value="{{ $product->product_factory }}" disabled>
                                    @error('product_factory')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="product_type" class="form-label">Type:</label>
                                    <input type="text" class="form-control @error('product_type') is-invalid @enderror"
                                        id="product_type" name="product_type" placeholder="Enter product type"
                                        value="{{ $product->product_type }}" disabled>
                                    @error('product_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="product_target" class="form-label">Target Audience:</label>
                                    <input type="text"
                                        class="form-control @error('product_target') is-invalid @enderror"
                                        id="product_target" name="product_target" placeholder="Enter target audience"
                                        value="{{ $product->product_target }}" disabled>
                                    @error('product_target')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="productImageFile" class="form-label">Product Image:</label>
                                    <input class="form-control" type="file" id="productImageFile"
                                        name="product_image_url" accept=".png, .jpg, .jpeg" disabled>
                                </div>
                                <div class="col-12 mt-3 text-center">
                                    @if($product->product_image_url)
                                    <img id="productImagePreview"
                                        src="{{ asset('storage/products/' . $product->product_image_url) }}"
                                        alt="Product Image Preview"
                                        style="display: block; max-width: 100%; max-height: 400px; border-radius: 8px; margin-top: 10px;">
                                    @endif
                                </div>
                            </form>
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