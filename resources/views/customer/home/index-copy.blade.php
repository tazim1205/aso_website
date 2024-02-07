@extends('customer.layout.app')
@push('title') {{ __('Home') }} @endpush
@push('head')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe-ui-default.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/default-skin/default-skin.min.css" rel="stylesheet">
@endpush
@section('content')
<!-- Start job posting area -->
{{-- <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
    <div class="swiper-wrapper row" id="gallery"
        style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
        @foreach(App\ServiceProviderStorie::orderByDesc('created_at')->get() as $story)
        @php
        $check = false;
        $check2 = false;
        $worker = App\User::find($story->user_id);
        $Word = $worker->word_road_id;
        $workerWord = explode(',', $Word);

        $viewBy = explode(',', $story->viewBy);
        @endphp
        @if ($Word != NULL)
        @php
        foreach ($workerWord as $w) {
        if ($w == auth()->user()->word_road_id) {
        $check = true;
        }
        }
        foreach ($viewBy as $vb) {
        if ($vb == auth()->user()->id) {
        $check2 = true;
        }
        }
        @endphp
        @if ($check == true && $check2 == false)

        <figure class="col-2 swiper-slide swiper-slide-active" itemprop="associatedMedia" itemscope itemtype="">
            <a href="{{ asset($story->image) }}" id="story_a" data-caption="" data-width="1200" data-height="900"
                itemprop="contentUrl">
                <!-- Thumbnail -->
                <img src="{{ asset($story->image) }}" height="100%" width="100%" itemprop="thumbnail"
                    alt="Image description">
                <div class="centered text-center">
                    <p>{!! $story->text !!}</p>
                    <button class="btn btn-sm btn-success">View Page</button>
                </div>
            </a>
        </figure>
        @endif
        @endif
        @endforeach
        <style type="text/css">
            .centered {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>
    </div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
</div> --}}

<!-- Some spacing 😉 -->
<div class="spacer"></div>


<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- Background of PhotoSwipe. 
           It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>
    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">
        <!-- Container that holds slides. 
              PhotoSwipe keeps only 3 of them in the DOM to save memory.
              Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <!--  Controls are self-explanatory. Order can be changed. -->
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="card shadow mt-4 h-500">
        <div class="card-header">
            <p class="text-mute text-center fw-bold"><a href="#" data-toggle="modal"
                    data-target="#customerAreChangeModal"><i class="material-icons header-ifs-sm">edit_location</i> {{
                    auth()->user()->district->name ?? '' }} > {{ auth()->user()->upazila->name ?? '' }} > {{
                    auth()->user()->pouroshova->name ?? '' }} > {{ auth()->user()->word->name ?? '' }}</a></p>
            <p class="text-mute text-center fw-bold">{{ __('প্রয়োজন অনুযায়ী সার্ভিস বা কাজের পোষ্ট দিন এবং বিড সমূহ
                থেকে অর্ডার করুন।') }}</p>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="container">

                    <form action="" id="job-form">
                        <div class="form-group">
                            <input type="text" id="title" class="form-control form-control-lg pl-2"
                                placeholder="{{ __('কাজের টাইটেল') }}..." style="border-radius: 5px !important;">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control form-control-lg" id="description" rows="6"
                                placeholder=""></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" id="address" class="form-control form-control-lg"
                                placeholder="{{ __('আপনার ঠিকানা') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id="service" class="form-control form-control-lg">
                                        <option disabled selected>{{ __('ক্যাটেগরি সিলেক্ট') }}</option>
                                        @foreach($categories as $category)
                                        @php
                                        $visible = 0;
                                        @endphp
                                        @foreach($category->services as $service)
                                        @if ($service->job_post == 1)
                                        @php
                                        $visible += 1;
                                        @endphp
                                        @endif
                                        @endforeach

                                        @if ($visible != 0)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->services as $service)
                                            @if($service->job_post == 1)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" id="day" class="form-control form-control-lg"
                                        placeholder="{{ __('সময় (ঘন্টা)') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <input type="date" id="date" class="form-control form-control-lg"
                                    placeholder="{{ __('তারিখ') }}">
                            </div>
                            <div class="col">
                                <input type="time" id="time" class="form-control form-control-lg"
                                    placeholder="{{ __('সময়') }}">
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col">
                                <div class="form-group">
                                    <input type="number" id="budget" class="form-control form-control-lg"
                                        placeholder="{{ __('Budget') }}">
                                </div>
                            </div> --}}
                            <div class="col">
                                <div class="form-group">
                                    <button type="button" id="job-submit-button"
                                        class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('SUBMIT')
                                        }}</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
<!-- End job posting area -->


{{--
<!-- Start top ads. by controller this upazila -->
<div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
    <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 5ms;">
        @foreach(auth()->user()->upazila->controllers as $controller)
        @foreach($controller->controllerAds as $controllerAds)
        <div class="swiper-slide swiper-slide-active">
            <div class="card">
                <div class="card-body">
                    <a @if($controllerAds->url) href="{{ $controllerAds->url }}" target="_blank" @endif >
                        <img src="{{ asset($controllerAds->image) }}" height="100%" width="100%"
                            style="border-radius: 5px;">
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
</div>
--}}
@include('customer.partials.ads')
<!-- End top ads.  by controller this upazila -->
<hr>
<!-- Start title -->
<div class="alert alert-primary text-center" role="alert">
    <b>{{ __('সার্ভিসসমূহ (গিগ ও পেইজ)') }}</b>
</div>
<!-- End title -->

<!-- Start worker service category -->
<div class="container">
    <div class="row text-center mt-4">
        @foreach($categories as $category)
        <div class="col-6 col-md-3">
            <div class="card shadow border-0 mb-3">
                <div class="card-body">
                    <div class="avatar avatar-60 no-shadow border-0">
                        <div class="overlay"></div>
                        <img src="{{ asset('uploads/images/worker/service-category/'.$category->icon) }}" height="70px"
                            width="70px" style="">
                    </div>
                    <a href="{{ route('customer.showServices',$category->meta_tag ?? $category->id) }}">
                        <p class="mt-3 mb-0 font-weight-bold">{{ $category->name }}</p>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- End worker service category -->

{{--
<!-- Start middle ads. by admin for all-->
<div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
    <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
        @foreach($adminAds as $adminAds)
        <div class="swiper-slide swiper-slide-active">
            <div class="card">
                <div class="card-body">
                    <a @if($adminAds->url) href="{{ $adminAds->url }}" target="_blank" @endif >
                        <img src="{{ asset($adminAds->image) }}" height="100%" width="100%" style="border-radius: 5px;">
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
</div> --}}

<div id="adminAds" class="container carousel slide col-lg-3 col-md-6 col-sm-12 col-12" data-ride="carousel">
    <ol class="carousel-indicators">
        @php
        $AdminadsCount = 1;
        @endphp
        @foreach($adminAds as $adminAd)
        <li data-target="#adminAds"
            style="width: 10px;height: 10px;border-radius: 50%;margin-right: 9px;margin-left: 3px;"
            data-slide-to="{{$AdminadsCount}}" class="@if($AdminadsCount == 1) active @endif"></li>
        @php
        $AdminadsCount++;
        @endphp
        @endforeach
    </ol>
    <div class="carousel-inner swiper-wrapper ">
        @php
        $AdminaddImage = 1;
        @endphp
        @foreach($adminAds as $adminads)
        <div class="swiper-slide carousel-item  @if($AdminaddImage == 1) active @endif">
            <div class="card">
                <div class="card-body p-1">
                    <a @if($adminads->url) href="{{ $adminads->url }}" target="_blank" @endif >
                        <img src="{{ asset($adminads->image) }}" height="180px" width="100%"
                            style="border-radius: 5px;">
                    </a>
                </div>
            </div>
        </div>
        @php
        $AdminaddImage++;
        @endphp
        @endforeach
        <a class="carousel-control-prev" href="#adminAds" role="button" data-slide="prev">
            <span class="" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#adminAds" role="button" data-slide="next">
            <span class="" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<!-- End middle ads. by admin for all-->

<!-- Start title -->
<div>
    <div class="alert alert-primary text-center" role="alert">
        <b>{{ __('Speacial service') }}</b>
    </div>
</div>
<!-- End title -->

<!-- Start special service category -->
<div class="container">
    <div class="row text-center mt-4">
        @foreach($specialServices as $specialService)
        <div class="col-6 col-md-3">
            <div class="card shadow border-0 mb-3">
                <div class="card-body">
                    <div class="avatar avatar-60 no-shadow border-0">
                        <div class="overlay"></div>
                        <img src="{{ asset($specialService->image ?? get_static_option('no_image')) }}" height="70px"
                            width="70px" style="border-radius: 15px;">
                    </div>
                    <a href="{{ route('customer.showSpecialProfiles',$specialService->id) }}">
                        <p class="mt-3 mb-0 font-weight-bold">{{ $specialService->name }}</p>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- End worker service category -->

<!-- Start admin notice box -->
@foreach($adminNotice as $adminNotice)
<section class="jumbotron  mt-1 bg-white shadow-sm">
    <div class="container">
        <p class="lead">{{ $adminNotice->title }}</p>
        <div>
            {!! $adminNotice->detail !!}
        </div>
    </div>
</section>
@endforeach
<!-- End admin notice box -->
<!-- Start controller notice box -->
@foreach(auth()->user()->upazila->controllers as $controller)
@foreach($controller->controllerNotice as $controllerNotice)
<section class="jumbotron  mt-1 bg-white">
    <div class="container">
        <div class="container">
            <p class="lead">{{ $controllerNotice->title }}</p>
            <div>
                {!! $controllerNotice->detail !!}
            </div>
        </div>
    </div>
</section>
@endforeach
@endforeach
<!-- End controller notice box -->


<script>
    $(document).ready(function() {
        (function($) {

          // Init empty gallery array
          var container = [];

          // Loop over gallery items and push it to the array
          $('#gallery').find('figure').each(function() {
            var $link = $(this).find('a'),
              item = {
                src: $link.attr('href'),
                w: $link.data('width'),
                h: $link.data('height'),
              };
            container.push(item);
          });

          // Define click event on gallery item
          $('#story_a').click(function(event) {

            // Prevent location change
            event.preventDefault();

            // Define object and gallery options
            var $pswp = $('.pswp')[0],
              options = {
                index: $(this).parent('figure').index(),
                bgOpacity: 0.85,
                showHideOpacity: true
              };

            // Initialize PhotoSwipe
            var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
            gallery.init();
          });

        }(jQuery));
        //Submit new Job
        $('#job-submit-button').click(function(){
            $("#job-submit-button").prop("disabled", true);
            var formData = new FormData();
            formData.append('title', $('#title').val())
            formData.append('description', $('#description').val())
            formData.append('address', $('#address').val())
            formData.append('service', $('#service').val())
            formData.append('day', $('#day').val())
            formData.append('date', $('#date').val())
            formData.append('time', $('#time').val())
            // formData.append('budget', $('#budget').val())

            $.ajax({
                method: 'POST',
                url: "{{ route('customer.storeCustomerGig') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#job-submit-button").prop("disabled", false);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Successfully add new job.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(function() {
                        location.reload();
                    }, 200);//
                },
                error: function (xhr) {
                    $("#job-submit-button").prop("disabled", false);
                    var errorMessage = '<div class="card bg-danger">\n' +
                        '                        <div class="card-body text-center p-5">\n' +
                        '                            <span class="text-white">';
                    $.each(xhr.responseJSON.errors, function(key,value) {
                        errorMessage +=(''+value+'<br>');
                    });
                    errorMessage +='</span>\n' +
                        '                        </div>\n' +
                        '                    </div>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        footer: errorMessage
                    })
                },
            })
        });
        $('.note-btn').click(function(){
            $('.note-modal-backdrop').css("z-index", "0");
        });
    });
</script>
<script>
    $('#description').summernote({
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['fontname', ['fontname']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
            ],
            placeholder: 'কাজের বিবরণ...',
            tabsize: 2,
            height: 120,
            
        });
</script>
@endsection