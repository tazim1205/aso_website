@extends('guest.layout')
@push('title') {{ __('Home') }} @endpush


@section('content')
    <div class="wrapper-area">
        <div class="catagory-location">
            <p class="location"><i class="fa-solid fa-location-dot"></i> {{
                    Session::get('location')['district']->name }} > {{ Session::get('location')['upazila']->name }} > {{
                    Session::get('location')['puroshova']->name }} > {{ Session::get('location')['word']->name }}</p>
        </div>
        <a href="{{ route('jobpost') }}"><div class="catagory-post"> <div><p>প্রয়োজন অনুযায়ী সার্ভিস বা কাজের পোষ্ট করুন...</p></div><div><i class="fa-solid fa-pen-to-square"></i></div></div></a>

        
        <!-- admin ads area -->
          
        <div id="adminAds" class="container carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @php
                    $AdminadsCount = 1;
                @endphp
                @foreach($adminAds as $adminAd)
                    <li data-target="#adminAds" style="width: 10px;height: 10px;border-radius: 50%;margin-right: 9px;margin-left: 3px;" data-slide-to="{{$AdminadsCount}}" class="@if($AdminadsCount == 1) active @endif"></li>
                    @php
                        $AdminadsCount++;
                    @endphp
                @endforeach
            </ol>
            <div class="carousel-inner swiper-wrapper">
                @php
                    $AdminaddImage = 1;
                @endphp
                @foreach($adminAds as $adminads)
                        <div class="swiper-slide carousel-item @if($AdminaddImage == 1) active @endif">
                            <div class="card">
                                <div class="card-body p-1">
                                    <a  @if($adminads->url) href="{{ $adminads->url }}" target="_blank" @endif >
                                        <img src="{{ asset($adminads->image) }}" height="180px" width="100%" style="border-radius: 5px;">
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


    </div>
    <div class="all-bid"><a href="#">সার্ভিসসমূহ</a></div>

    <div class="wrapper-area">
        <div class="catagory-h3"><h3></h3> </div>

        <div class="catagory">
            @foreach($categories as $category)
                <div class="catagory-child">
                    <div class="catagory-image">
                        <a href="{{ route('showService',\Illuminate\Support\Facades\Crypt::encryptString($category->id)) }}"><img src="{{ asset('/uploads/images/worker/service-category/'.$category->icon) }}" height="70px" width="70px" style=""></a>
                    </div>
                    <h4><a href="{{ route('showService',\Illuminate\Support\Facades\Crypt::encryptString($category->id)) }}">{{ $category->name }}</a></h4>
                </div>
            @endforeach
        </div>


    </div>


    <!-- admin ads area -->

        <div id="carouselExampleIndicators" class="container carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @php
                    $adsCount = 1;
                @endphp
                @foreach(App\User::where('role','controller')->where('upazila_id',Cookie::get('guest_upazila'))->get() as $controller)
                    @foreach($controller->controllerAds as $controllerAds)
                        <li data-target="#carouselExampleIndicators" style="width: 10px;height: 10px;border-radius: 50%;margin-right: 9px;margin-left: 3px;" data-slide-to="{{$adsCount}}" class="@if($adsCount == 1) active @endif"></li>
                        @php
                            $adsCount++;
                        @endphp
                    @endforeach
                @endforeach
            </ol>
            <div class="carousel-inner swiper-wrapper ">
                @php
                    $addImage = 1;
                @endphp
                @foreach(App\User::where('role','controller')->where('upazila_id',Cookie::get('guest_upazila'))->get() as $controller)
                    @foreach($controller->controllerAds as $controllerAds)
                        <div class="swiper-slide carousel-item  @if($addImage == 1) active @endif">
                            <div class="card">
                                <div class="card-body p-1">
                                    <a  @if($controllerAds->url) href="{{ $controllerAds->url }}" target="_blank" @endif >
                                        <img src="{{ asset($controllerAds->image) }}" height="180px" width="100%" style="border-radius: 5px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                        @php
                            $addImage++;
                        @endphp
                    @endforeach
                @endforeach
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
            </div>
        </div>

    <div class="all-bid"><a href="#">স্পেশাল সার্ভিস
        </a></div>

    <div class="free-border">

        <div class="wrapper-area">

            <div class="catagory free-h">
                @foreach($specialServices as $specialService)
                    <div class="catagory-child">
                        <div class="catagory-image">
                            <img src="{{ asset($specialService->image ?? get_static_option('no_image')) }}" style="border-radius: 15px;">
                        </div>
                        <h4>
                            <a href="{{ route('showSpecialProfiles',$specialService->id) }}">{{ $specialService->name }}</a>
                        </h4>
                    </div>

                @endforeach
            </div>


        </div>
    </div>

    <div class="wrapper-area">
        @foreach($adminNotice as $adminNotice)
            <div class="catagory-details">
                <h3>{{ $adminNotice->title }}</h3>
                <p>{!! $adminNotice->detail !!}</p>
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
                    url: "{{ route('storeGuestGig') }}",
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
