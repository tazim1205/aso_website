<!doctype html>
<html lang="en" class="deeppurple-theme">
<!-- This system developed by DataTech BD ltd. Phone: 01304734623-25 | info@datatechbd.com | 23-08-2020-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="Maxartkiller">

    <title>{{ __('Introduction') }} | {{ get_static_option('name') }}</title>

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
</head>

<body>
<!-- Loader -->
@include('includes.loader')
<!-- Loader ends -->
<div class="wrapper">
    <!-- Swiper intro -->
    <div class="swiper-container introduction pt-5">
        <div class="swiper-wrapper">
            <div class="swiper-slide overflow-hidden text-center">
                <div class="row no-gutters">
                    <div class="col align-self-center px-3">
                        <img src="{{ asset('uploads/images/'.setting('logo')) }}" alt="" class="mx-100 my-5">
                        <div class="row">
                            <div class="container mb-5">
                                <h4>{{ __('Amazing Finance Corner') }}</h4>
                                <p>{{ __('Lorem ipsum dolor sit amet, consect etur adipiscing elit. Sndisse conv allis.') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Add Pagination -->
    </div>
    <!-- Swiper intro ends -->

    <!-- login buttons -->
    <div class="row mx-0 bottom-button-container">
        <div class="col">
            <a href="{{ route('login') }}" class="btn btn-default btn-lg btn-rounded shadow btn-block">{{ __('Login') }}</a>
        </div>
        <div class="col">
            <a href="{{ route('register') }}" class="btn btn-white bg-white btn-lg btn-rounded shadow btn-block">{{ __('Register') }}</a>
        </div>
    </div>
    <!-- login buttons -->
</div>

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
<script>
    $(window).on('load', function() {
        var swiper = new Swiper('.introduction', {
            pagination: {
                el: '.swiper-pagination',
            },
        });

        /* notification view and hide */
        setTimeout(function() {
            $('.notification').addClass('active');
            setTimeout(function() {
                $('.notification').removeClass('active');
            }, 3500);
        }, 500);
        $('.closenotification').on('click', function() {
            $(this).closest('.notification').removeClass('active')
        });
    });

</script>
</body>
</html>

