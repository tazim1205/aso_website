@extends('marketer.layout.app')
@push('title') {{ __('Find your service') }} @endpush
@push('head')
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/assets/owl.theme.default.min.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="{{ asset('assets/owlcarousel/owl.carousel.js') }}"></script>
@endpush
@section('content')

    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h5 class="subtitle mb-1">{{ $category->name }}</h5>
                <p class="">{{ __('Find your service') }}</p>
            </div>
        </div>
        <div class="row text-center mt-4">
            @foreach($category->services as $service)
                <div class="col-6 col-md-3">
                    <div class="card shadow border-0 mb-3">
                        <div class="card-body">
                            <div class="avatar avatar-60 no-shadow border-0">
                                <div class="overlay"></div>
                                <img src="{{ asset('uploads/images/worker/service/'.$service->icon) }}" height="50px" width="50px" style="border-radius: 15px;">
                            </div>
                            <a href="{{ route('marketer.showGigs',\Illuminate\Support\Facades\Crypt::encryptString($service->id)) }}"> <p class="mt-3 mb-0 font-weight-bold">{{ $service->name }}</p></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <hr>
    <!-- Start top ads. by controller this upazila -->
    <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
        <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
            {{-- @foreach(auth()->user()->upazila->controllers as $controller)
                @foreach($controller->controllerAds as $controllerAds)
                    <div class="swiper-slide swiper-slide-active">
                        <div class="card">
                            <div class="card-body">
                                <a  @if($controllerAds->url) href="{{ $controllerAds->url }}" target="_blank" @endif >
                                    <img src="{{ asset($controllerAds->image) }}" height="100%" width="100%" style="border-radius: 5px;">
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach --}}
        </div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
    </div>
    <!-- End top ads.  by controller this upazila -->
    <hr>
    <!-- Start middle ads. by admin for all-->
    <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
        <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
            <div class="owl-carousel owl-theme topOwl">
                @foreach($adminAds as $controllerAds)
                <div class="item">
                    <div class="swiper-slide ">
                        <div class="card">
                            <div class="card-body">
                                <a  @if($controllerAds->url) href="{{ $controllerAds->url }}" target="_blank" @endif >
                                    <img src="{{ asset($controllerAds->image) }}" height="100%" width="100%" style="border-radius: 5px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
    </div>
    <!-- End middle ads. by admin for all-->


   {{-- Blog Start --}}
   <div class="container">
    <div class="row">
        <div class="col text-center">
            <h5 class="subtitle mb-1 text-success">Latest Blog</h5>
        </div>
    </div>
    <div class="row text-center mt-4">
        @foreach($category->blogs()->orderBy('id','desc')->paginate(12) as $blog)
            <div class="col-12 col-md-12">
                <div class="card shadow border-0 mb-3">
                    <div class="card-body row">
                        <div class="col-lg-3 col-md-4 col-4">
                            <img src="{{ asset($blog->thumbnail_img) }}" height="100%" width="100%">
                        </div>
                        <div class="col-lg-9 col-md-8 col-8 text-left">
                            <a href="{{ route('marketer.single.blog',$blog->id) }}"> <p class="font-weight-bold">{{ $blog->title }}</p></a>
                            <small class="text-secondary">View <span class="text-info">{{$blog->view_count}}</span> - {{ $blog->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach 
    </div>
    {{-- {{ $category->blogs->links() }} --}}
</div>
{{-- Blog End --}}


    <script type="text/javascript">
        $(document).ready(function() {
            jQuery.noConflict();
          $('.topOwl').owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            responsiveClass: true,
            responsive: {
              0: {
                items: 4,
                nav: true,
                dots: false,
              },
              600: {
                items: 4,
                nav: false,
                dots: false,
              },
              1000: {
                items: 6,
                nav: false,
                dots: false,
                loop: false,
                margin: 20
              }
            }
          })
        })
    </script>
@endsection
