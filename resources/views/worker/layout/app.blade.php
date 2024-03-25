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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    
    <link href="{{ asset('assets/mobile/vendor/bootstrap-4.4.1/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--main css-->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <!--SweetAlert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!--Select2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--====== AJAX ======-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .jq-toast-wrap.top-right {
            top: 100px !important;
        }
        .checkbox{
            width:12px !important;
            height:23px !important;
            padding:3px !important;
        }
    </style>
    @stack('head')
</head>
<body>
<!--Start logout-->
@include('includes.logout')
<!--End logout-->
<!-- heading-->





<div class="logo-nav">
    <div class="logo-nav-left">
        <img src="{{ asset( get_static_option('header_logo')  ?? '/image/aso-logo.png') }}" alt="">
    </div>
    <div class="logo-nav-right">
        <ul>
            @if(auth()->user()->out_of_work == 0)
            <li><a href="" class="btn btn-link text-dark position-relative" data-toggle="modal" data-target="#outOfWorkModal"><i class="fa-solid fa-eye"></i></a></li>
            @else
            <li><a href="" class="btn btn-link text-dark position-relative" data-toggle="modal" data-target="#inOfWorkModal"><i class="fa-solid fa-eye-slash"></i></a></li>
            @endif
            {{-- <li><a href="" class="btn btn-link text-dark position-relative"  data-toggle="modal" data-target="#addStoriesModal"><i class="material-icons header-ifs-sm">add_to_photos</i></a></li> --}}

            <li><a href="{{ route('worker.notifications') }}"><i class="fa-regular fa-bell"></i><span class="counts">({{ auth()->user()->unreadNotifications->count() }})</span></a></li>

            <li><a href="#" class="btn btn-link text-warning position-relative" data-toggle="modal" data-target="#workerAreChangeModal"><i class="fa-solid fa-location-dot location"></i></a></li>
            {{-- 
            <li><a href="#" data-toggle="modal" data-target="#workerAreChangeModal" class="list-group-item list-group-item-action @if(Route::is('worker.workerServiceArea')) active @endif"><i class="material-icons icons-raised">map</i></a></li> --}}
        </ul>
    </div>
</div>


<div class="icon-nav icon-nav-2">
    <div class="icon-nav-flex">
        <ul class="my-flex">
            <li class="@if(Route::is('worker.home.index')) under @endif">
                <a href="{{ route('worker.home.index') }}"><i class="fa-solid fa-house  @if(Route::is('worker.home.index')) blue @endif"></i></a>
            </li>
            <li class="@if(Route::is('worker.job.index')) under @endif">
                <a href="{{ route('worker.job.index') }}"><i class="fa-solid fa-bag-shopping @if(Route::is('worker.job.index')) blue @endif"></i></a>
            </li>
            <li class="@if(Route::is('worker.gig.index')) under @endif">
                <a href="{{ route('worker.gig.index') }}"><i class="fa-solid fa-square-plus @if(Route::is('worker.gig.index')) blue @endif"></i></a>
            </li>
            <li class="@if(Route::is('worker.profile.index')) under @endif">
                <a href="{{ route('worker.profile.index') }}"><i class="fa-solid fa-user @if(Route::is('worker.profile.index')) blue @endif"></i></a>
            </li>
            <li class=""><a href="#"><i class="fa-solid fa-bars three-dot-2"></i></a></li>
        </ul>
    </div>
</div>



@yield('content')




@include('worker.layout.sidebar')
</div>

<!-- Modal -->
@include('worker.layout.modal')
@include('worker.layout.member-modal')

<!-- jquery, popper and bootstrap js -->
<script src="{{ asset('assets/mobile/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/mobile/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/mobile/vendor/bootstrap-4.4.1/js/bootstrap.min.js') }}"></script>

<!-- swiper js -->
<script src="{{ asset('assets/mobile/vendor/swiper/js/swiper.min.js') }}"></script>

<!-- cookie js -->
<script src="{{ asset('assets/mobile/vendor/cookie/jquery.cookie.js') }}"></script>

<script src="https://kit.fontawesome.com/45a0bcfe23.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="{{ asset('frontend/toast/jquery.toast.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('frontend/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
        let table = new DataTable('#myTable');
    </script>
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

                        $('#pouroshava_area_div').empty();
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
                    url: "{{  url('/get/pouroshava/word/') }}/"+upazila_thana_id,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#pouroshava_area_div').empty();
                        $('#pouroshava_area_div').html(data);
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
@include('sweetalert::alert')
@stack('foot')
</body>
</html>
