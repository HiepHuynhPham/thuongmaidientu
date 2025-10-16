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

                        <h1 class="mt-4">Manage User</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><a href="/admin">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="/admin/order">Order</a></li>
                            <li class="breadcrumb-item active">Update</li>
                        </ol>
                        @if(is_null($orders))
                        <div class="alert alert-danger">
                            Không tìm thấy sản phẩm hoặc đã xảy ra lỗi.
                        </div>
                        @else

                        <form method="post" action="/admin/order/update/{{$orders->id}}" enctype="multipart/form-data"
                            class="row g-3 p-3">
                            @csrf
                            <div class="col-md-6">
                                <label for="user_email" class="form-label">name:</label>
                                <input type="email" class="form-control @error('user_email') is-invalid @enderror"
                                    value="{{ $orders->receiver_name }}" disabled>

                            </div>

                            <div class="col-md-6">
                                <label for="user_phone" class="form-label">Phone number:</label>
                                <input type="text" class="form-control" value="{{ $orders->receiver_phone }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="user_name" class="form-label">payment:</label>
                                <input type="text" class="form-control" value="{{ $orders->payment_method }}" disabled>
                            </div>

                            <div class="col-md-12">
                                <label for="user_address" class="form-label">Address:</label>
                                <input type="text" class="form-control" value="{{ $orders->receiver_address }}"
                                    disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="user_role" class="form-label">Role:</label>
                                <select class="form-select" id="order_status" name="order_status">
                                    <option value="pending" {{ $orders->order_status == 'pending' ? 'selected' : '' }}>
                                        PENDING</option>
                                    <option value="shipping" {{ $orders->order_status == 3 ? 'shipping' : '' }}>SHIPPING
                                    </option>
                                    <option value="complete" {{ $orders->order_status == 2 ? 'complete' : '' }}>COMPLETE
                                    </option>
                                    <option value="cancel" {{ $orders->order_status == 2 ? 'cancel' : '' }}>CANCEL
                                    </option>
                                </select>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-warning">Update</button>
                            </div>
                        </form>
                        <!-- Bảng hiển thị danh sách người dùng -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Giá cả</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($orders->orderDetails as $orderDetail)
                                <tr>
                                    <th scope="row">

                                        <img loading="lazy"
                                            src="{{ asset('storage/products/' . $orderDetail->product->product_image_url) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; overflow: hidden; display: flex;
                                           justify-content: center; align-items: center; object-fit: cover;" alt=""
                                            disabled>

                                    </th>
                                    <td>
                                        <p class="mb-0 mt-4">
                                            {{ $orderDetail->product->product_name }}
                                            </a>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">
                                            {{ number_format($orderDetail->price) }} đ
                                        </p>
                                    </td>
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <input type="text" class="form-control form-control-sm text-center border-0"
                                                value="{{ $orderDetail->quantity }}" disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4" data-cart-detail-id="{{ $orderDetail->id }}" disabled>
                                            {{ number_format($orderDetail->price * $orderDetail->quantity) }} đ
                                        </p>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @endif
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