<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sofra</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href={{asset('dist/plugins/fontawesome-free/css/all.min.css')}}>
    <!-- Theme style -->
    <link rel="stylesheet" href={{asset('dist/css/adminlte.min.css')}}>
</head>

<body
    class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li>
                <a class="nav-link"  href="{{url('admin/logout')}}"  role="button">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{url('admin/home')}}" class="brand-link">
            <span class="brand-text blood-weight-light pl-5"> Sofra</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{Auth()->user()->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href={{url('admin/cities')}} class="nav-link">
                            <i class="nav-icon fas fa-city"></i>
                            <p>Cities</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/districts')}} class="nav-link">
                            <i class="nav-icon fas fa-flag"></i>
                            <p>Districts</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/categories')}} class="nav-link">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/payments')}} class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Payments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/offers')}} class="nav-link">
                            <i class="nav-icon fas fa-money-check"></i>
                            <p>Offers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/orders')}} class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/restaurants')}} class="nav-link">
                            <i class="nav-icon fas fa-pizza-slice"></i>
                            <p>Restaurants</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/clients')}} class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Clients</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href={{url('admin/contacts')}} class="nav-link">
                            <i class="nav-icon fas fa-phone"></i>
                            <p>Contacts</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href={{url('admin/change-password')}} class="nav-link">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Change Password</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/settings')}} class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/users')}} class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href={{url('admin/roles')}} class="nav-link">
                            <i class="nav-icon fas fa-list-ul"></i>
                            <p>Users Roles</p>
                        </a>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            @yield('page_title')
                            <small>@yield('small_title')</small>
                        </h1>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href={{url('admin/home')}}>Home</a></li>
                            <li class="breadcrumb-item active">@yield('page_title')</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        @yield('content')
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src={{asset('dist/plugins/jquery/jquery.min.js')}}></script>
<!-- Bootstrap 4 -->
<script src={{asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js')}}></script>
<!-- AdminLTE App -->
<script src={{asset('dist/js/adminlte.min.js')}}></script>
<!-- AdminLTE for demo purposes -->
<script src={{asset('dist/js/adminlte.min.js')}}></script>
@stack('scripts')
</body>
</html>

