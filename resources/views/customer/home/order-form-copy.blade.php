@extends('customer.layout.app')
@push('title') {{ __('Gig Order') }} @endpush
@push('head')
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .color-border{
            border-style: solid;
            border-width: thin;
            border-color: white;
            border-radius: 5px;
            margin-left: 5px;
            padding: 10px;
        }
        .view-btn{
            margin-left: -10px;
            height: 100%;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe-ui-default.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/default-skin/default-skin.min.css" rel="stylesheet">
@endpush
@section('content')

        <!--Start active job detail view -->

        <!-- Start title -->
        <div class="">
            <div class="alert alert-info text-center" role="alert">
                <b id="">  {{ __('Order Now') }} </b>
            </div>
        </div>
        <!-- End title -->
        <!--Start worker info & price-->
        <div class="container worker-profile">
            <div class="card bg-info shadow mt-4 h-190">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto align-self-center text-center">
                            <i class="material-icons text-template-primary">
                                <figure class="avatar avatar-60">
                                    <img class="worker-profile-image" src="{{ asset($gig->worker->image ?? 'uploads/images/defaults/user.png') }}" alt="">
                                </figure>

                            </i>
                        </div>
                        <div class="col pl-0">
                            <div class="row mb-1">
                                <div class="col">
                                    <p class="mb-0">{{ $gig->worker->full_name }}</p>
                                    <p class="small text-mute text-trucated mt-1" style="font-size: 100%;">
                                        <span><i class="material-icons btn-outline-warning small">star</i></span>
                                            @php
                                                $percent = 100 - (($gig->worker->rating->max_rate - $gig->worker->rating->rate)/$gig->worker->rating->max_rate)*100;
                                                if ($percent>80)
                                                    $star = 5;
                                                else if ($percent>60)
                                                    $star = 4;
                                                else if ($percent>40)
                                                    $star = 3;
                                                else if ($percent>20)
                                                    $star = 2;
                                                else if ($percent>1)
                                                    $star = 1;
                                                else
                                                    $star = 0;
                                            @endphp
                                            <span>{{ $star }} ({{ $gig->worker->rating->max_rate - $gig->worker->rating->rate }})</span>
                                            
                                    </p>
                                </div>
                                <div class="col-auto pl-0 pt-4">
                                    <a href="{{ $gig->worker->location }}" target="_blank" class="text-warning p-4"> <i class="fa fa-map-marker"></i> Location</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <div class="container top-100">
            <div class="card mb-4 shadow">
                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-0 font-weight-normal"> {{ __('price') }} ৳ </h3>
                        </div>
                        <div class="col-auto">
                            <button disabled class="btn btn-info btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b class="gig-budget">{{ $gig->budget }}</b> </button>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-none">
                    <div class="row">
                        <div class="col">
                            <p class="gig-title"><b>{{ $gig->title }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End gig info & price-->
        <!-- Start order now area -->
        <div class="container">
            <div class="card shadow mt-4 h-500">
                <div class="card-body">
                    <div class="row">
                        <div class="container">
                            <input id="gig-id" type="hidden" value="{{$gig->id}}">
                            <div class="form-group">
                                <textarea class="form-control form-control-lg" id="description" rows="6" placeholder="{{ __('বিবরণ ') }}"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" id="address" class="form-control form-control-lg" placeholder="{{ __('ঠিকানা ') }}...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="date" id="date" class="form-control form-control-lg" placeholder="{{ __('তারিখ') }}">
                        </div>
                        <div class="col">
                            <input type="time" id="time" class="form-control form-control-lg" placeholder="{{ __('সময়') }}">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <!-- End order now area -->
        <div class="container">
            <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                <button disabled type="button" class="btn btn-outline-success active"><small> {{ __('time') }} </small>{{ $gig->day }}<small>  {{ __('hours') }}</small></button>
                <button id="job-submit" data-worker-limiit="{{ $gig->worker->recharge_amount * get_static_option('order_bid_limit_amount') }}" type="button" class="btn btn-success">
                    {{ __('order now') }}
                </button>
            </div>
        </div>
        <hr>



    <!-- page level script -->
    <script>
        $(document).ready(function(){
            //Submit
            $("#job-submit").click(function (){
                    $("#job-submit").prop("disabled", true);
                    var formData = new FormData();
                    formData.append('gig', $('#gig-id').val())
                    formData.append('description', $('#description').val())
                    formData.append('address', $('#address').val())
                    formData.append('date', $('#date').val())
                    formData.append('time', $('#time').val())

                    $.ajax({
                        method: 'POST',
                        url: "{{ route('customer.submitGigOrderForm') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $("#job-submit").prop("disabled", false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Successfully order placed.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                window.location = "{{ route('customer.myJob') }}";
                            }, 1000); //1 second
                        },
                        error: function (xhr) {
                            $("#job-submit").prop("disabled", false);
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
