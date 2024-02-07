@extends('customer.layout.master')
@push('title') {{ __('Find your service') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="wrapper-area">

        <div class="w-sub w-sub-3">
            <div class="w-sub-1 w-sub-4">
                <div class="w-sub-11"><i class="fa-brands fa-discord"></i></div>
            </div>
            <div class="w-sub-2">
                <h2>{{ $category->name }}</h2>
                <p>আপনার সার্ভিসটি খুঁজুন
                </p>
            </div>
        </div>

    </div>
    <div class="my-container-2">
        <div class="my-container">


            <div class="catagory catagory-noborder ">
                @foreach($category->services as $service)
                    @if($service->gig_post == 1 || $service->page_post == 1)
                        <div class="catagory-child">
                            <div class="catagory-image">
                                <a href="{{ route('worker.showCustomerGigs',$service->meta_tag ?? $service->id) }}">
                                    <img src="{{ asset('uploads/images/worker/service/'.$service->icon) }}" alt="" style="border-radius: 50%">
                                </a>
                            </div>
                            <h4>{{ $service->name }}</h4>
                        </div>
                    @endif
                @endforeach

            </div>




            @include('worker.partials.ads')
        </div>
    </div>

    <div class="my-container">

        <div class="blog-section">
            <h2>LATEST BLOG</h2>
            @foreach($category->blogs()->orderBy('id','desc')->paginate(12) as $blog)
                <div class="blog-1">
                    <div class="blog-img"><img src="{{ asset($blog->thumbnail_img) }}" alt=""></div>
                    <div class="blog-cont">
                        <a href="{{ route('single.blog',$blog->id) }}">
                            <h3>{{ $blog->title }}</h3>
                        </a>
                        <p>View <span class="text-info">{{$blog->view_count}}</span> - {{ $blog->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
