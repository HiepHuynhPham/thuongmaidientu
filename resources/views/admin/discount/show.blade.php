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
</head>

<body class="sb-nav-fixed">
    @extends('admin.layout.header')

    <div id="layoutSidenav">
        @extends('admin.layout.sidebar')
        <div id="layoutSidenav_content">
            <div class="mt-5">
                <div class="row">
                    <div class="col-11 mx-auto">
                        <div class="d-flex justify-content-between">
                            <h3>Table Product</h3>
                        </div>
                        <hr />
                        <!-- Bảng hiển thị danh sách người dùng -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td scope="row">
                                        <img loading="lazy"
                                            src="{{ asset('storage/products/' . $product->product_image_url) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; overflow: hidden; display: flex;
                                           justify-content: center; align-items: center; object-fit: cover;" alt=""
                                            disabled>

                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_price }}</td>
                                    <td>
                                        <a href="{{ url('/admin/discount/' . $product->id) }}"
                                            class="btn btn-success">View</a>
                                        <a href="{{ url('/admin/discount/create/' . $product->id) }}"
                                            class="btn btn-primary mx-2">Create</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>

                <div class="row">
                    <div class="col-11 mx-auto">
                        <div class="d-flex justify-content-between">
                            <h3>Product Discount</h3>
                        </div>
                        <hr />
                        <!-- Bảng hiển thị danh sách người dùng -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">% Discount</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productsDiscounts as $productDiscount)
                                <tr>
                                    <td>{{ $productDiscount->id }}</td>
                                    <td scope="row">
                                        <img loading="lazy"
                                            src="{{ asset('storage/products/' . $productDiscount->product->product_image_url) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; overflow: hidden; display: flex;
                                           justify-content: center; align-items: center; object-fit: cover;" alt=""
                                            disabled>

                                    </td>
                                    <td>{{ $productDiscount->product->product_name }}</td>
                                    <td>{{ $productDiscount->product->product_price }}</td>
                                    <td>{{ $productDiscount->discount_percent }}%</td>
                                    <td>
                                        <a href="{{ url('/admin/discount/productdiscount/' . $productDiscount->id) }}"
                                            class="btn btn-success">View</a>
                                        <a href="{{ url('/admin/discount/update/' . $productDiscount->id) }}"
                                            class="btn btn-warning mx-2">Update</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $productsDiscounts->links('pagination::bootstrap-4') }}
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