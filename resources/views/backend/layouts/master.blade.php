    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>AdminLTE 3 | Dashboard</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->

        <link rel="stylesheet" href="{{ mix('css/backend_all.css') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">



    </head>
    <body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('/') }}img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('/') }}img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('/') }}img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                            class="fa fa-th-large"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('/') }}img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                     style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('/') }}img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            {{Auth::user()->name}}
                            <p>{{Auth::user()->type}}</p>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->



                        <li class="nav-item">
                            <router-link to="/developer" class="nav-link">
                                <i class="fa fa-tachometer-alt nav-icon"></i>
                                <p>Developer</p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/dashboard" class="nav-link">
                                <i class="fa fa-tachometer-alt nav-icon"></i>
                                <p>Dashboard</p>
                            </router-link>
                        </li>


                        <li class="nav-item has-treeview ">
                            <a href="#" class="nav-link">
                                <i class="fas fa-users-cog nav-icon orange"></i>
                                <p>
                                    Admins
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
{{--                                router-link to url not working in double word--}}

                                <li class="nav-item">
                                    <router-link to="/permissionFor" class="nav-link">
                                        <i class="fab fa-typo3 nav-icon"></i>
                                        <p>permission for</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/permission" class="nav-link">
                                        <i class="fab fa-typo3 nav-icon"></i>
                                        <p>permission</p>
                                    </router-link>
                                </li>

                                <li class="nav-item">
                                    <router-link to="/role" class="nav-link">
                                        <i class="fab fa-typo3 nav-icon"></i>
                                        <p>Role</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/admin" class="nav-link">
                                        <i class="fab fa-typo3 nav-icon"></i>
                                        <p>Admin</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <router-link to="/seo" class="nav-link">
                                <i class="fab fa-searchengin nav-icon"></i>
                                <p>Seo</p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/category" class="nav-link">
                                <i class="fab fa-searchengin nav-icon"></i>
                                <p>Category</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/carousel" class="nav-link">
                                <i class="fab fa-searchengin nav-icon"></i>
                                <p>Carousel</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/tags" class="nav-link">
                                <i class="fab fa-searchengin nav-icon"></i>
                                <p>Tag</p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/post" class="nav-link">
                                <i class="fab fa-searchengin nav-icon"></i>
                                <p>Posts</p>
                            </router-link>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                                <i class="nav-icon fa fa-power-off red"></i>
                                <p>
                                    {{ __('Logout') }}
                                </p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">

            <div class="content">
                <div class="container-fluid">

                    <router-view></router-view>

                    <vue-progress-bar></vue-progress-bar>

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>





        <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2018 <a href="#">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/backend_all.js') }}"></script>

{{--    <script>--}}
{{--        $.widget.bridge('uibutton', $.ui.button)--}}
{{--    </script>--}}
    <!-- Bootstrap 4 -->

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

        })

    </script>

    <script>
        CKEDITOR.replace( 'summary-ckeditor', {
            filebrowserBrowseUrl : "{{ URL::asset('ckeditor/kcfinder/browse.php?opener=ckeditor&type=files') }}",
            filebrowserImageBrowseUrl : "{{ URL::asset('ckeditor/kcfinder/browse.php?opener=ckeditor&type=images') }}",
            filebrowserFlashBrowseUrl : "{{ URL::asset('ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash') }}",
            filebrowserUploadUrl : "{{ URL::asset('ckeditor/kcfinder/upload.php?opener=ckeditor&type=files') }}",
            filebrowserImageUploadUrl : "{{ URL::asset('ckeditor/kcfinder/upload.php?opener=ckeditor&type=images') }}",
            filebrowserFlashUploadUrl : "{{ URL::asset('ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash') }}",
        });
    </script>






    </body>
    </html>
