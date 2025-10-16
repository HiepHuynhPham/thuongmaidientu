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
                            <h3>Table User</h3>
                            <a href="/admin/users/create" class="btn btn-primary">Create a User</a>
                        </div>
                        <hr />
                        <!-- Bảng hiển thị danh sách người dùng -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role description</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->user_email }}</td>
                                    <td>{{ $user->role->role_description }}</td>
                                    <td>{{ $user->role->role_name }}</td>
                                    <td>
                                        <a href="{{ url('/admin/user/' . $user->id) }}" class="btn btn-success">View</a>
                                        <a href="{{ url('/admin/user/update/' . $user->id) }}"
                                            class="btn btn-warning mx-2">Update</a>
                                        <a href="{{ url('/admin/user/delete/' . $user->id) }}"
                                            class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $users->links('pagination::bootstrap-4') }}
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