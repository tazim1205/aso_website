@extends('guest.layout')

@section('content')
    <div class="wrapper">
        <!-- Swiper intro -->
        {{-- <div class="swiper-container introduction pt-5">
            <div class="swiper-wrapper">
                <div class="swiper-slide overflow-hidden text-center">
                    <div class="row no-gutters">
                        <div class="col align-self-center px-3">
                            <img src="{{ asset( get_static_option('logo')  ?? 'uploads/images/defaults/logo.png') }}" alt="" class="mx-100 my-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Swiper intro ends -->

        <!-- login buttons -->
        <div class="row mx-0">
            <div class="col-12 container text-center small">
                <p>{{ __('সার্ভিস নিতে অথবা সার্ভিস দিতে সাইন ইন করুন। আপনার কোনো অ্যাকাউন্ট নেই? এখনই সাইন আপ করুন।') }}</p>
                <br>
            </div>
            <div class="col">
                <a href="{{ route('login') }}" class="btn btn-default btn-lg btn-rounded bg-success shadow btn-block">{{ __('Sign in') }}</a>
            </div>
            <div class="col">
                <a href="{{ route('register') }}" class="btn btn-white bg-white btn-lg btn-rounded shadow btn-outline-success btn-block text-success">{{ __('Sign up') }}</a>
            </div>
        </div>
        
        <hr> --}}
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h5 class="subtitle mb-1">{{ $category->name }}</h5>
                    <p class="">{{ __('Find your service') }}</p>
                </div>
            </div>
            <div class="row text-center mt-4">
                @foreach($category->services as $service)
                    @if($service->gig_post == 1 || $service->page_post == 1)
                        <div class="col-6 col-md-3">
                            <div class="card shadow border-0 mb-3">
                                <div class="card-body">
                                    <div class="avatar avatar-60 no-shadow border-0">
                                        <div class="overlay"></div>
                                        <img src="{{ asset('uploads/images/worker/service/'.$service->icon) }}" height="50px" width="50px" style="border-radius: 15px;width: auto;">
                                    </div>
                                    <a href="{{ route('showGigs',\Illuminate\Support\Facades\Crypt::encryptString($service->id)) }}"> <p class="mt-3 mb-0 font-weight-bold">{{ $service->name }}</p></a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <hr>

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
                                    <a href="{{ route('customer.single.blog',$blog->id) }}"> <p class="font-weight-bold">{{ $blog->title }}</p></a>
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
    </div>
@endsection
