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
    <link rel="icon" href="{{ asset(get_static_option('fav') ?? 'uploads/images/defaults/fav.png') }}" type="image/x-icon">
    <!--Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--main css-->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
</head>
<body>

<!-- heading-->
<div class="logo-nav">
    <div class="logo-nav-left">
        <img src="{{ asset( get_static_option('header_logo')  ?? 'uploads/images/defaults/header-logo.png') }}" alt="">
    </div>
    <div class="logo-nav-right home-menu">
        <ul>
            @guest()
                <li><a href="{{ route('login') }}">Sign In</a></li>
                <li><a href="{{ route('register') }}">Sign Up</a></li>
            @else
                <li><a href="{{ route('customer.home.index') }}">Dashboard</a></li>
            @endguest

            <li><a href="javascript:void(0);" class="location"><i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
        </ul>
    </div>

</div>
<!-- <div class="icon-nav icon-nav-2">
    <div class="icon-nav-flex">
        <ul class="my-flex">
            <li class="@if(Route::is('get.started')) under @endif"><a href="{{ route('get.started') }}"><i class="fa-solid fa-house  @if(Route::is('get.started')) blue @endif"></i></a></li>
            <li class="@if(Route::is('customer.myJob')) under @endif"><a href="{{ route('customer.myJob') }}"><i class="fa-solid fa-bag-shopping @if(Route::is('customer.myJob')) blue @endif"></i></a></li>
            <li class="@if(Route::is('customer.create.service')) under @endif"><a href="{{ route('customer.create.service') }}"><i class="fa-solid fa-square-plus @if(Route::is('customer.create.service')) blue @endif"></i></a></li>
            <li class="@if(Route::is('customer.profile.index')) under @endif"><a href="{{ route('customer.profile.index') }}"><i class="fa-solid fa-user @if(Route::is('customer.profile.index')) blue @endif"></i></a></li>
            <li class=""><a href="#"><i class="fa-solid fa-bars three-dot-2"></i></a></li>
        </ul>
    </div>
</div> -->
@yield('content')

@include('guest.sidebar')

<div class="my-location">

    <div class="login-area loc-area lc-1">
        <i class="fa-solid fa-xmark colo-2"></i>
        <div class="login-content">

            <div class="login-img">

                <img src="{{ asset('frontend/image/3196533 1.png') }}" alt="Log in Image">
            </div>

            <div class="login-info loc-head">
                <h2>আপনার লোকেশন নির্বাচন করুন</h2>
            </div>
            <div class="login-form loc-form">
                <form action="{{ route('get.started') }}" method="get">
                    <select name="district_id" id="district_id" placeholder="Feni | ফেনী">
                        <option value="Dhaka">Select জেলা</option>
                        @foreach(App\District::get() as $row)
                            <option value="{{ $row->id }}" >{{ __($row->name) }}</option>
                        @endforeach
                    </select>
                    <select name="upazila_thana_id" id="upazila_thana_id" placeholder="Feni Sadar | ফেনী সদর">
                        <option value="Dhaka">Select মেট্রোপলিটন থানা / উপজেলা</option>
                    </select>
                    <select name="pouroshava_union_id" id="pouroshava_union_id" placeholder="Feni Pouroshova">
                        <option value="Dhaka">Select এরিয়া /পৌরসভা /ইউনিয়ন</option>
                    </select>

                    <select name="word_road_id" id="word_road_id placeholder="Select Word/Road">
                        <option value="Dhaka">Select রোড / ওয়ার্ড</option>
                    </select>
                    <input type="submit" value="Save Change">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/45a0bcfe23.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('frontend/js/custom.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('select[name="district_id"]').on('change', function(){
            var district_id = $(this).val();
            if(district_id) {
                $.ajax({
                    url: "{{  url('/get/district/upazila/') }}/"+district_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        var d =$('select[name="upazila_thana_id"]').empty();
                        $('select[name="upazila_thana_id"]').append('<option value="">সিলেক্ট উপজেলা /মেট্রোপলিটন থানা</option>');
                        $.each(data, function(key, value){
                            $('select[name="upazila_thana_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                        $('select[name="pouroshava_union_id"]').empty();
                        $('select[name="word_road_id"]').empty();

                        $('select[name="pouroshava_union_id"]').append('<option value="">Select এরিয়া /পৌরসভা /ইউনিয়ন</option>');
                        $('select[name="word_road_id"]').append('<option value="">Select রোড / ওয়ার্ড</option>');
                    },

                });
            } else {
                alert('danger');
            }
        });

        $('select[name="upazila_thana_id"]').on('change', function(){
            var upazila_thana_id = $(this).val();
            if(upazila_thana_id) {
                $.ajax({
                    url: "{{  url('/get/upazila/pouroshava-union/') }}/"+upazila_thana_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        var d =$('select[name="pouroshava_union_id"]').empty();
                        $('select[name="pouroshava_union_id"]').append('<option value="">Select এরিয়া /পৌরসভা /ইউনিয়ন</option>');
                        $.each(data, function(key, value){
                            $('select[name="pouroshava_union_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                    },

                });
            } else {
                alert('danger');
            }
        });

        $('select[name="pouroshava_union_id"]').on('change', function(){
            var pouroshava_union_id = $(this).val();
            if(pouroshava_union_id) {
                $.ajax({
                    url: "{{  url('/get/pouroshava-union/word-road/') }}/"+pouroshava_union_id,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        var d =$('select[name="word_road_id"]').empty();
                        $('select[name="word_road_id"]').append('<option value="">Select রোড / ওয়ার্ড</option>');
                        $.each(data, function(key, value){
                            $('select[name="word_road_id"]').append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                    },

                });
            } else {
                alert('danger');
            }
        });
    });

</script>
</body>
</html>
