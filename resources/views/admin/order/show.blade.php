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
                            <h3>Table order</h3>

                        </div>
                        <hr />
                        <!-- Bảng hiển thị danh sách người dùng -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">tatle price</th>
                                    <th scope="col">address</th>
                                    <th scope="col">name</th>
                                    <th scope="col">status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ $order->receiver_address }}</td>
                                    <td>{{ $order->receiver_name }}</td>
                                    <td>
                                        @if ($order->order_status === 'pending')
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #FFC107, #FFD54F); color: #000; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Pending
                                        </span>
                                        @elseif ($order->order_status === 'complete')
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #4CAF50, #81C784); color: #fff; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Complete
                                        </span>
                                        @elseif ($order->order_status === 'shipping')
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #2196F3, #64B5F6); color: #fff; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Shipping
                                        </span>
                                        @elseif ($order->order_status === 'cancel')
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #F44336, #E57373); color: #fff; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Cancel
                                        </span>
                                        @else
                                        <span class="badge"
                                            style="background: linear-gradient(45deg, #757575, #BDBDBD); color: #fff; font-weight: bold; padding: 5px 10px; border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                            Unknown
                                        </span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ url('/admin/order/' . $order->id) }}"
                                            class="btn btn-success">View</a>
                                        <a href="{{ url('/admin/order/update/' . $order->id) }}"
                                            class="btn btn-warning mx-2">Update</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $orders->links('pagination::bootstrap-4') }}
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