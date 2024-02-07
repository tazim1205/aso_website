<!DOCTYPE html>
<html lang="{{  App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@stack('title') | {{ get_static_option('name') }}</title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}"/>
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
<!--Start logout-->
@include('includes.logout')
<!--End logout-->
<!-- heading-->
@include('customer.layout.header')

<div class="icon-nav icon-nav-2">
    <div class="icon-nav-flex">
        <ul class="my-flex">
            <li class="@if(Route::is('customer.home.index')) under @endif"><a href="{{ route('customer.home.index') }}"><i class="fa-solid fa-house  @if(Route::is('customer.home.index')) blue @endif"></i></a></li>
            <li class="@if(Route::is('customer.myJob')) under @endif"><a href="{{ route('customer.myJob') }}"><i class="fa-solid fa-bag-shopping @if(Route::is('customer.myJob')) blue @endif"></i></a></li>
            <li class="@if(Route::is('customer.create.service')) under @endif"><a href="{{ route('customer.create.service') }}"><i class="fa-solid fa-square-plus @if(Route::is('customer.create.service')) blue @endif"></i></a></li>
            <li class="@if(Route::is('customer.profile.index')) under @endif"><a href="{{ route('customer.profile.index') }}"><i class="fa-solid fa-user @if(Route::is('customer.profile.index')) blue @endif"></i></a></li>
            <li class=""><a href="#"><i class="fa-solid fa-bars three-dot-2"></i></a></li>
        </ul>
    </div>
</div>



@yield('content')


<div class="my-location">

    <div class="login-area loc-area lc-1">
        <i class="fa-solid fa-xmark colo-2"></i>
        <div class="login-content">

            <div class="login-img">

                <img src="{{ asset('image/3196533 1.png') }}" alt="Log in Image">
            </div>

            <div class="login-info loc-head">
                <h2>আপনার লোকেশন নির্বাচন করুন</h2>
            </div>
            <div class="login-form loc-form">
                <form>

                    <select name="District" placeholder="Feni | ফেনী">
                        <option value="Dhaka">Select জেলা</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                    </select>


                    <select name="Upzilla" placeholder="Feni Sadar | ফেনী সদর">
                        <option value="Dhaka">Select মেট্রোপলিটন থানা / উপজেলা</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                    </select>



                    <select name="Pouroshoba" placeholder="Feni Pouroshova">
                        <option value="Dhaka">Select এরিয়া /পৌরসভা /ইউনিয়ন</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                    </select>

                    <select name="Pouroshoba" placeholder="Select Word/Road">
                        <option value="Dhaka">Select রোড / ওয়ার্ড</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Dhaka">Dhaka</option>
                    </select>
                    <input type="text" placeholder="আপনার Google Map লিংক">
                    <input type="submit" value="Save Change">
                </form>




            </div>
        </div>
    </div>

    @include('customer.layout.sidebar')
</div>

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
