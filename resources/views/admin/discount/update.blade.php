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
                <h1 class="mt-4">Manage Discount</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="/admin/discount">Discount</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
                <div class=" mt-5">
                    <div class="row">
                        <div class="col-md-6 col-12 mx-auto">
                            <h3>Update a Product</h3>
                            <hr />
                            @if(is_null($productDiscount))
                            <div class="alert alert-danger">
                                Không tìm thấy sản phẩm hoặc đã xảy ra lỗi.
                            </div>
                            @else
                            <form method="post" action="/admin/discount/update/{{$productDiscount->id}}"
                                enctype="multipart/form-data" class="row g-3 p-3">
                                @csrf
                                <div class="col-md-12">
                                    <label for="product_name" class="form-label">Product Name:</label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                        id="product_name" name="product_name" placeholder="Enter product name"
                                        value="{{ $productDiscount->product->product_name }}" disabled>
                                    @error('product_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="product_price" class="form-label">Price:</label>
                                    <input type="number"
                                        class="form-control @error('product_price') is-invalid @enderror"
                                        id="product_price" name="product_price" placeholder="Enter price"
                                        value="{{ $productDiscount->product->product_price }}" disabled>
                                    @error('product_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="discount_percent" class="form-label">Discount Percent (%):</label>
                                    <input type="number"
                                        class="form-control @error('discount_percent') is-invalid @enderror"
                                        id="discount_percent" name="discount_percent"
                                        placeholder="Enter discount percent"
                                        value="{{ old('discount_percent', $productDiscount->discount_percent) }}"
                                        min="1" max="100">
                                    @error('discount_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status:</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="1"
                                            {{ old('status', $productDiscount->status) == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $productDiscount->status) == 0 ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Start Date:</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                        id="start_date" name="start_date"
                                        value="{{ old('start_date', \Carbon\Carbon::parse($productDiscount->start_date)->format('Y-m-d')) }}">
                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">End Date:</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        id="end_date" name="end_date"
                                        value="{{ old('end_date', \Carbon\Carbon::parse($productDiscount->end_date)->format('Y-m-d')) }}">
                                    @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>




                                <div class="col-md-6">
                                    <label for="productImageFile" class="form-label">Product Image:</label>
                                    <input class="form-control" type="file" id="productImageFile"
                                        name="product_image_url" accept=".png, .jpg, .jpeg" disabled>
                                </div>
                                <div class="col-12 mt-3 text-center">
                                    @if($productDiscount->product->product_image_url)
                                    <img id="productImagePreview"
                                        src="{{ asset('storage/products/' . $productDiscount->product->product_image_url) }}"
                                        alt="Product Image Preview"
                                        style="display: block; max-width: 100%; max-height: 400px; border-radius: 8px; margin-top: 10px;">
                                    @endif
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-warning">Update</button>
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