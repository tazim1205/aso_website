<!doctype html>
<html lang="{{  App::getLocale() }}" class="deeppurple-theme">
<!-- This system developed by DataTech BD ltd. Phone: 01304734623-25 | info@datatechbd.com | 23-08-2020-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <title>{{ get_static_option('name') }} | {{ __('Otp check')}} </title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}"/>
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Material design icons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/mobile/vendor/materializeicon/material-icons.css')}}">

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
    <!-- header -->
    <div class="header">
        <div class="row no-gutters">
            <div class="col-auto">
                <a href="{{ route('welcome') }}" class="btn  btn-link text-dark"><i class="material-icons">chevron_left</i></a>
            </div>
            <div class="col text-center"></div>
            <div class="col-auto">
            </div>
        </div>
    </div>
    <!-- header ends -->

    <div class="row no-gutters login-row">
        <div class="col align-self-center px-3 text-center">
            <br>
            <img src="{{ asset( get_static_option('logo')  ?? 'uploads/images/defaults/logo.png') }}" alt="logo" class="logo-small">
            <br>
            {{-- <a href="{{ route('language') }}">
                @if(current_language() != 'en')
                    বাংলা
                @else
                    English
                @endif
            </a> --}}
            <!--Show error & session message -->
            @include('includes.message')
            <form class="form-signin mt-3" method="POST" action="{{ route('otp.check.post') }}">
                @csrf
                <div class="form-group">
                    <input type="number" id="inputPhone" class="form-control form-control-lg text-center" name="phone" placeholder="{{ __('Mobile') }}"  value="{{ old('phone') }}" required autofocus>
                </div>

                <div class="form-group">
                    <input type="text" id="otp" value="{{ old('otp') }}" class="form-control form-control-lg text-center" name="otp" placeholder="{{ __('Otp') }}" required>
                </div>
                <div class="form-group">
                    <input type="password" id="otp" class="form-control form-control-lg text-center" name="password" placeholder="{{ __('Password') }}" value="{{ old('password') }}" required>
                </div>
                <div class="form-group">
                    <input type="password" id="otp" class="form-control form-control-lg text-center" name="confirm_password" placeholder="{{ __('Confirm Password') }}" value="{{ old('confirm_password') }}" required>
                </div>
                <input type="submit" class="mt-4 d-block btn btn-default btn-lg btn-rounded shadow btn-block" value="{{ __('Change password') }}">
                <!-- login buttons -->
            </form>
        </div>
    </div>
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
@include('sweetalert::alert')
</body>
<!-- This system developed by DataTech BD ltd. Phone: 01304734623-25 | info@datatechbd.com | 23-08-2020-->
</html>

