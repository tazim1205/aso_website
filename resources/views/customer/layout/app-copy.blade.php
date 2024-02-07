<!doctype html>
<html lang="{{  App::getLocale() }}" class="deeppurple-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <title>@stack('title') | {{ get_static_option('name') }}</title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}"/>
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset(get_static_option('fav') ?? 'uploads/images/defaults/fav.png') }}" type="image/x-icon">
    <!-- Material design icons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/mobile/vendor/materializeicon/material-icons.css') }}">

    <!-- Roboto fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/mobile/vendor/bootstrap-4.4.1/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Swiper CSS -->
    <link href="{{ asset('assets/mobile/vendor/swiper/css/swiper.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/mobile/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/mobile/css/responsive.css') }}" rel="stylesheet">

    <!--SweetAlert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!--====== AJAX ======-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @stack('head')

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '3390821181144666');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=3390821181144666&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body>
<!-- Loader -->
@include('includes.loader')
<!-- Loader ends -->

<!--Start logout-->
@include('includes.logout')
<!--End logout-->

<!-- Sidebar -->
@include('customer.layout.sidebar')
<!-- Sidebar ends -->
<div class="wrapper homepage">
    <!-- header -->
    <div class="header">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-auto">
                    <button class="btn  btn-link text-dark menu-btn"><i class="material-icons">menu</i></button>
                </div>
                <div class="col align-self-center align-items-start"><a href="{{ route('customer.home.index') }}"><img src="{{ asset( get_static_option('header_logo')  ?? 'uploads/images/defaults/header-logo.png') }}" alt="" class="header-logo"></a></div>
                <div class="col-auto text-right">
                    <a href="" class="btn  btn-link text-dark position-relative" data-toggle="modal" data-target="#customerSearchForm"><i class="material-icons header-ifs-sm">search</i></a>
                    <a href="#" data-toggle="modal" data-target="#customerAreChangeModal" class="btn  btn-link text-dark position-relative" ><i class="material-icons header-ifs-sm">edit_location</i></a>
                    <a href="{{ route('customer.notifications') }}" class="btn  btn-link text-dark position-relative"><i class="material-icons header-ifs-sm">notifications_none</i><span class="counts">{{ auth()->user()->unreadNotifications->count() }}</span></a>

                    
                </div>
            </div>
        </div>
    </div>
    <!-- header ends -->
    @yield('content')
    @include('customer.layout.footer')
</div>

<!-- color chooser menu start -->
@include('customer.layout.color-choser')
<!-- color chooser menu ends -->

<!-- Modal -->
@include('customer.layout.modal')

<!-- jquery, popper and bootstrap js -->
<script src="{{ asset('assets/mobile/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/mobile/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/mobile/vendor/bootstrap-4.4.1/js/bootstrap.min.js') }}"></script>

<!-- swiper js -->
<script src="{{ asset('assets/mobile/vendor/swiper/js/swiper.min.js') }}"></script>

<!-- cookie js -->
<script src="{{ asset('assets/mobile/vendor/cookie/jquery.cookie.js') }}"></script>

<!-- template custom js -->
<script src="{{ asset('assets/mobile/js/main.js') }}"></script>

<!-- page level script -->
@stack('foot')
@include('sweetalert::alert')

</body>


</html>
