@extends('worker.layout.app')
@push('title') {{ __('Home') }} @endpush

@section('content')

    <div class="wrapper-area">
        
        <!-- admin ads area -->

        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($adminAds as $chabi => $ads)
                <div class="carousel-item @if(isset($chabi)) active @endif">
                    <img src="{{ asset($ads->image) }}" class="d-block w-100" alt="...">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </div>

    <div class="all-bid"><a href="#">ক্যাটাগরি | জব অফার</a></div>

    <div class="wrapper-area">
        <div class="catagory-h3"><h3></h3> </div>

        <div class="catagory">
            @foreach($categories as $category)
                <div class="catagory-child">
                    <div class="catagory-image">
                        <a href="{{ route('worker.showServices',$category->meta_tag ?? $category->id) }}"><img src="{{ asset('uploads/images/worker/service-category/'.$category->icon) }}" height="70px"
                                                           width="70px" style=""></a>
                    </div>
                    <h4><a href="{{ route('worker.showServices',$category->meta_tag ?? $category->id) }}">{{ $category->name }}</a></h4>
                </div>
            @endforeach
        </div>


    </div>


    <!-- controller ads area -->
    <div class="wrapper-area">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($controllerAds as $key => $controllerAdss)
                <div class="carousel-item @if(isset($key)) active @endif">
                    <img src="{{ asset($controllerAdss->image) }}" class="d-block w-100" alt="...">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <br>
    <br>


    {{--<div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
        <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
            @foreach((array) auth()->user()->upazila->controllers as $controller)
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
            @endforeach
        </div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
    </div>--}}



    <div class="wrapper-area">
        @foreach($adminNotice as $adminNotice)
            <div class="catagory-details">
                <h3>{{ $adminNotice->title }}</h3>
                <p>{!! $adminNotice->detail !!}</p>
            </div>
        @endforeach
    </div>

    <div class="wrapper-area">
        @foreach($notices as $controllerNotices)
            <div class="catagory-details">
                <h3>{{ $controllerNotices->title }}</h3>
                <p>{!! $controllerNotices->detail !!}</p>
            </div>
        @endforeach
    </div>

@endsection
@push('foot')
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
@endpush
