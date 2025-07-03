<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>매크로 관리자</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/public/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/public/dist/css/adminlte.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/public/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/public/plugins/summernote/summernote-bs4.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/plugins/fontawesome-free-6.3.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/public/dist/css/adminlte.min.css">

    <!-- jQuery -->
    <script src="/public/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/public/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/public/plugins/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- ChartJS -->
    <script src="/public/plugins/chart.js/Chart.js"></script>
    <!-- Sparkline -->
    <script src="/public/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/public/plugins/jqvmap/jquery.vmap.js"></script>
    <script src="/public/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/public/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/public/plugins/moment/moment.min.js"></script>
    <script src="/public/plugins/moment/locale/ko.js"></script>
    <script src="/public/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js"></script>
    <!-- Summernote -->
    <script src="/public/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="/public/plugins/summernote/lang/summernote-ko-KR.js"></script>
    <!-- overlayScrollbars -->
    <script src="/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js"></script>
    <!-- AdminLTE App -->
    <script src="/public/dist/js/adminlte.js"></script>




    <!-- DataTables  & Plugins -->
    <script src="/public/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="/public/plugins/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="/public/plugins/datatables-responsive/js/responsive.bootstrap4.js"></script>
    <script src="/public/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
    <script src="/public/plugins/datatables-buttons/js/buttons.bootstrap4.js"></script>
    <script src="/public/plugins/jszip/jszip.js"></script>
    <script src="/public/plugins/pdfmake/pdfmake.js"></script>
    <script src="/public/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/public/plugins/datatables-buttons/js/buttons.html5.js"></script>
    <script src="/public/plugins/datatables-buttons/js/buttons.print.js"></script>
    <script src="/public/plugins/datatables-buttons/js/buttons.colVis.js"></script>


    <link rel="stylesheet" href="/public/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <script src="/public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="/public/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/public/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript" src="/public/js/jquery.bpop.js"></script>
    <style>
        .sidebar-mini.layout-fixed .main-sidebar {width: 290px;}
        .sidebar-mini.layout-fixed .brand-link {width: 290px;}
        .sidebar-mini.layout-fixed .main-header {margin-left: 290px;}
        .sidebar-mini.layout-fixed .main-footer {margin-left: 290px;}
        .sidebar-mini.layout-fixed .content-wrapper {margin-left: 290px;}
        .sidebar-mini.layout-fixed.sidebar-closed .main-header {margin-left: 0;}
        .sidebar-mini.layout-fixed.sidebar-closed .main-footer {margin-left: 0;}
        .sidebar-mini.layout-fixed.sidebar-closed .content-wrapper {margin-left: 0;}
        .sidebar-mini.layout-fixed.sidebar-collapse .main-sidebar:hover {width: 290px;}
        .sidebar-mini.layout-fixed.sidebar-collapse .main-sidebar {width: 4.6rem;}
        .turn_around{transform: scaleY(-1) rotate(-90deg); margin-left:1.5rem; margin-right:0.5rem;}
    </style>

    <!-- develop style -->
    <link rel="stylesheet" href="/public/css/style.css">
    <script src="/public/js/common.js"></script>
    <link rel="stylesheet" href="/public/css/style2.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="loading_wrap overlay-wrapper" style="display:none; position:fixed; width:100%; height:100%; z-index:9999;">
    <div class="overlay dark"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
</div>
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="/public/#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="/login/logout">
                    <i class="fa-solid fa-lock-open">&nbsp;logout</i>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="/public/dist/img/logo-h.svg" class="brand-image img-circle elevation-3" style="opacity: 0.8; background-color: #fff;">
            <span class="brand-text font-weight-light">중고차 보험 매크로</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                    <li class="nav-item <?=$this->common->adminMenuOpen("users")?>">
                        <a href="/users" class="nav-link <?=$this->common->adminSubMenuActive("users", array("index", "index"))?>">
                            <i class="nav-icon fa-solid fa-user-group"></i>
                            <p>회원 관리</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                    <li class="nav-item <?=$this->common->adminMenuOpen("ai")?>">
                        <a href="/ai" class="nav-link <?=$this->common->adminSubMenuActive("ai", array("index", "index"))?>">
                            <i class="nav-icon fa-solid fa-layer-group"></i>
                            <p>AI 파인튜닝</p>
                        </a>
                    </li>
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
                        <h1></h1>
                    </div>
                </div>
            </div>
        </section>
        {yield}
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy;  중고차 보험 매크로</strong>
        All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

</body>
</html>
