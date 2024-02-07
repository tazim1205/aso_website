<!DOCTYPE html>
<html lang="{{  App::getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@stack('title') | {{ get_static_option('name') }}</title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}" />
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/toast/jquery.toast.min.css') }}">
    <!--main css-->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <style>
        .jq-toast-wrap.top-right {
            top: 100px !important;
        }
    </style>
    @stack('head')
</head>

<body>

    <div class="arro-area">
        <div class="arro-head">
            <div>
                <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i></a>
            </div>
            <div>
                <h2>@stack('title') </h2>
            </div>

            <div class="menu-icon">
                <a href="#"><i class="fa-solid fa-bars"></i></a>
            </div>

        </div>
    </div>




    @yield('content')

    @include('customer.layout.sidebar')




    <script src="https://kit.fontawesome.com/45a0bcfe23.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="{{ asset('frontend/toast/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
    <script>
        @if (Session::has('message'))           
                $.toast({
                    heading: 'Success!',
                    position: 'top-right',
                    text: "{{ session('message') }}",
                    showHideTransition: 'slide',
                    icon: 'success',
                })
            @endif
    
            @if (Session::has('error'))
                $.toast({
                    heading: 'Opps!',
                    position: 'top-right',
                    text: "{{ session('error') }}",
                    showHideTransition: 'slide',
                    icon: 'error',
                })
            @endif
    </script>
    @stack('foot')
</body>

</html>