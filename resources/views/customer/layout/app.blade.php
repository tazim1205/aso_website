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
                <img src="{{ asset('assets/images/location.png') }}" style="width:20%" alt="Log in Image">
            </div>
            <div class="login-info loc-head">
                <h2>আপনার লোকেশন নির্বাচন করুন</h2>
            </div>
            <div class="login-form loc-form">
                <div class="row">
                    <div class="col-12 px-0 text-center">
                        <form action="{{ route('customer.changeArea') }}" method="POST" class="row">
                            @csrf
                            <div class="col-lg-12 form-group mt-3">
                                <select class="form-control" name="district_id" id="district_id" required="">
                                    <option value="">{{ __('সিলেক্ট জেলা ') }}</option>
                                    @foreach(App\District::get() as $row)
                                    <option value="{{ $row->id }}" <?php if ($row->id == auth()->user()->district_id) {
                                        echo "selected";
                                    } ?> >{{ __($row->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 form-group mt-3">
                                <select class="form-control" name="upazila_thana_id" id="upazila_thana_id" required="">
                                    <option value="">{{ __('সিলেক্ট উপজেলা /মেট্রোপলিটন থানা a') }}</option>
                                    @foreach(App\Upazila::where('district_id', auth()->user()->district_id)->get() as $row)
                                    <option value="{{ $row->id }}" <?php if ($row->id == auth()->user()->upazila_id) {
                                        echo "selected";
                                    } ?> >{{ __($row->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 form-group mt-3">
                                <select class="form-control" name="pouroshava_union_id" id="pouroshava_union_id" required="">
                                    <option value="">{{ __('Select Pouroshava / Union') }}</option>
                                    @foreach(App\Puroshova::where('upazila_id', auth()->user()->upazila_id)->get() as $row)
                                    <option value="{{ $row->id }}" <?php if ($row->id == auth()->user()->pouroshova_union_id) {
                                        echo "selected";
                                    } ?> >{{ __($row->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 form-group mt-3">
                                <select class="form-control" name="word_road_id" id="word_road_id" required="">
                                    <option value="">{{ __('Select Ward / Road') }}</option>
                                    @foreach(App\Word::where('puroshova_id', auth()->user()->pouroshova_union_id)->get() as $row)
                                    <option value="{{ $row->id }}" <?php if ($row->id == auth()->user()->word_road_id) {
                                        echo "selected";
                                    } ?> >{{ __($row->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <input name="location" placeholder="আপনার Google Map লিংক" type="text" value="{{ auth()->user()->location }}" >
                                <!-- <textarea name="location" placeholder="আপনার Google Map লিংক" id="" class="form-control form-control-lg" rows="2">{{ auth()->user()->location }}</textarea> -->
                                <input type="submit" value="Save Change">
                            </div>
                        </form>
                    </div>
                </div>
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

                            $('select[name="pouroshava_union_id"]').append('<option value="">Select Pouroshava / Union</option>');
                            $('select[name="word_road_id"]').append('<option value="">Select Ward / Road</option>');
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
                            $('select[name="pouroshava_union_id"]').append('<option value="">Select Pouroshava / Union</option>');
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
                            $('select[name="word_road_id"]').append('<option value="">Select Ward / Road</option>');
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
    @stack('foot')
</body>
</html>
