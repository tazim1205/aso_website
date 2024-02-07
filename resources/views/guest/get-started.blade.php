@extends('guest.layout')
@push('title') {{ __('Home') }} @endpush

@section('content')
    <div class="wrapper-area">
        <div class="catagory-location">
            <p class="location"><i class="fa-solid fa-location-dot"></i> {{
                    Session::get('location')['district']->name }} > {{ Session::get('location')['upazila']->name }} > {{
                    Session::get('location')['puroshova']->name }} > {{ Session::get('location')['word']->name }}</p>
        </div>
        <a href="{{ route('customer.create.service') }}"><div class="catagory-post"> <div><p>প্রয়োজন অনুযায়ী সার্ভিস বা কাজের পোষ্ট করুন...</p></div><div><i class="fa-solid fa-pen-to-square"></i></div></div></a>


    </div>
    <div class="all-bid"><a href="#">সার্ভিসসমূহ</a></div>

    <div class="wrapper-area">
        <div class="catagory-h3"><h3></h3> </div>

        <div class="catagory">
            @foreach($categories as $category)
                <div class="catagory-child">
                    <div class="catagory-image">
                        <a href="sub_catagory_9.html"><img src="{{ asset('/uploads/images/worker/service-category/'.$category->icon) }}" height="70px"
                                                           width="70px" style=""></a>
                    </div>
                    <h4><a href="{{ route('customer.showServices',$category->meta_tag ?? $category->id) }}">{{ $category->name }}</a></h4>
                </div>
            @endforeach
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
                            <a href="{{ route('customer.showSpecialProfiles',$specialService->id) }}">{{ $specialService->name }}</a>
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
