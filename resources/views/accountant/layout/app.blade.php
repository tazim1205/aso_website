
<!DOCTYPE html>
<html class="loading" lang="{{  App::getLocale() }}" data-textdirection="ltr">

<head>
    <meta charset=UTF-8">
    <title>@yield('title') | {{ get_static_option('name') }}</title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}" />
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_static_option('fav') ?? 'assets/images/ico/favicon-32.png') }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_static_option('fav') ?? 'assets/images/ico/favicon-32.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700"
          rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/forms/toggle/switchery.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/plugins/forms/switch.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/core/colors/palette-switch.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/charts/chartist.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/charts/chartist-plugin-tooltip.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/tables/datatable/datatables.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/tables/extensions/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/forms/icheck/custom.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/vendors/css/timeline/vertical-timeline.css">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/colors.min.css">
    <!-- END: Theme CSS-->
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/pages/chat-application.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/pages/dashboard-analytics.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/pages/users.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/pages/timeline.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/plugins/charts/chartist.min.css">
    <!-- END: Page CSS-->
    <!-- BEGIN: Font CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/fonts/simple-line-icons/style.min.css">
    <!-- END: Font CSS-->

    <!-- BEGIN: Materual Icon-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- END: Materual Icon-->

    <!-- BEGIN: Designer Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/custom.min.css">
    <!-- END: Designer Custom CSS-->

    <!-- BEGIN: Developer Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/style.css">
    <!-- END: Developer Custom CSS-->
    <style>
        .active {
            color: #57cc32 !important;
            font-weight: bold !important;

        }
    </style>
    @stack('css')
</head>
<!-- END: Head-->
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu"
      data-color="bg-gradient-x-blue-green" data-col="2-columns">

<!-- Common Content Start -->

<!-- BEGIN: Header-->
@include('accountant.layout.header')
<!-- END: Header-->

<!-- BEGIN: Main Menu-->
@include('accountant.layout.main')
<!-- END: Main Menu-->

<!-- Common Content End -->

<!-- BEGIN: Main Content start-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-body  container-fluid">
                <!-- Minimal statistics section start -->
                <section id="minimal-statistics">


                   @yield('content')

                </section>
                <!-- // Minimal statistics section end -->
            </div>
        </div>
    </div>
</div>
<!-- END: Main Content end-->

<!-- BEGIN: Customizer-->
<div class="customizer border-left-blue-grey border-left-lighten-4 d-none d-xl-block">
    <a class="customizer-close" href="#"><i class="ft-x font-medium-3"></i></a><a
        class="customizer-toggle bg-green box-shadow-3" href="#" id="customizer-toggle-setting">
        <i class="ft-settings font-medium-3 spinner black"></i>
    </a>
    <div class="customizer-content p-2">
        <h5 class="mt-1 mb-1 text-bold-500">Navbar Color Options</h5>
        <div class="navbar-color-options clearfix">
            <div class="gradient-colors mb-1 clearfix">

                <div class="bg-gradient-x-blue-green navbar-color-option" data-bg="bg-gradient-x-blue-green"
                     title="bg-gradient-x-blue-green"></div>

                <div class="bg-gradient-x-purple-green navbar-color-option" data-bg="bg-gradient-x-purple-green"
                     title="bg-gradient-x-purple-green"></div>

                <div class="bg-success navbar-color-option" data-bg="bg-success" title="success"></div>

                <div class="bg-gradient-x-blue-cyan navbar-color-option" data-bg="bg-gradient-x-blue-cyan"
                     title="bg-gradient-x-blue-cyan"></div>

            </div>
        </div>
        <hr>
        <h5 class="mt-1 mb-1 text-bold-500">Sidebar menu Background</h5>
        <div class="row sidebar-color-options ml-0">
            <label for="sidebar-color-option" class="card-title font-medium-2 mr-2" Mode</label>
            <div class="text-center mb-1">
                <input type="checkbox" id="sidebar-color-option" class="switchery" data-size="xs" />
            </div>
            <label for="sidebar-color-option" class="card-title font-medium-2 ml-2">Dark Mode</label>
        </div>
        <hr>
        <label for="collapsed-sidebar" class="font-medium-2">Menu Collapse</label>
        <div class="float-right">
            <input type="checkbox" id="collapsed-sidebar" class="switchery" data-size="xs" />
        </div>
        <hr>
        <!--Sidebar Background Image Starts-->
        <h5 class="mt-1 mb-1 text-bold-500">Sidebar Background Image</h5>
        <div class="cz-bg-image row">
            <div class="col mb-3">
                <img src="../assets/images/backgrounds/04.jpg" class="rounded sidiebar-bg-img" width="50" height="100"
                     alt="background image">
            </div>
            <div class="col mb-3">
                <img src="../assets/images/backgrounds/01.jpg" class="rounded sidiebar-bg-img" width="50" height="100"
                     alt="background image">
            </div>
            <div class="col mb-3">
                <img src="../assets/images/backgrounds/02.jpg" class="rounded sidiebar-bg-img" width="50" height="100"
                     alt="background image">
            </div>
            <div class="col mb-3">
                <img src="../assets/images/backgrounds/05.jpg" class="rounded sidiebar-bg-img" width="50" height="100"
                     alt="background image">
            </div>
        </div>
        <!--Sidebar Background Image Ends-->
        <!--Sidebar BG Image Toggle Starts-->
        <div class="sidebar-image-visibility">
            <div class="row ml-0">
                <label for="toggle-sidebar-bg-img" class="card-title font-medium-2 mr-2">Hide Image</label>
                <div class="text-center mb-1">
                    <input type="checkbox" id="toggle-sidebar-bg-img" class="switchery" data-size="xs" checked />
                </div>
                <label for="toggle-sidebar-bg-img" class="card-title font-medium-2 ml-2">Show Image</label>
            </div>
        </div>
        <!--Sidebar BG Image Toggle Ends-->
    </div>
</div>
<!-- End: Customizer-->
<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light navbar-border navbar-shadow">
    <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
         <span class="float-md-left d-block d-md-inline-block">2023 &copy; Copyright <a
                 class="text-bold-800 grey darken-2" href="https://aso.com.bd" target="_blank">ASO</a></span>
        <ul class="list-inline float-md-right d-block d-md-inline-blockd-none d-lg-block mb-0">
            <li class="list-inline-item">
                <a class="my-1" href="support.html" target="_blank"> Support</a>
            </li>
        </ul>
    </div>
</footer>
<!-- END: Footer-->
<!-- BEGIN: Vendor JS-->
<script src="{{ asset('') }}assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/js/scripts/forms/switch.min.js" type="text/javascript"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('') }}assets/vendors/js/charts/chartist.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/vendors/js/charts/chartist-plugin-tooltip.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>

<script src="{{ asset('') }}assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/vendors/js/tables/datatable/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset('') }}assets/js/core/app-menu.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/js/core/app.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/js/scripts/customizer.min.js" type="text/javascript"></script>
<script src="{{ asset('') }}assets/vendors/js/jquery.sharrre.js" type="text/javascript"></script>
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
<script src="{{ asset('') }}assets/js/scripts/pages/dashboard-analytics.min.js" type="text/javascript"></script>
<!-- END: Page JS-->
<!-- BEGIN: Page JS-->
<script src="{{ asset('') }}assets/js/scripts/tables/datatables/datatable-basic.min.js" type="text/javascript"></script>
<!-- END: Page JS-->
<!-- END: Page JS-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- BEGIN: Page JS-->
<script src="{{ asset('') }}assets/js/scripts/pages/users-contacts.min.js" type="text/javascript"></script>
<!-- END: Page JS-->
@stack('js')
<script>
    $('.deleted-click').click(function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })
    });
</script>
</body>
<!-- END: Body-->

</html>
