@extends('customer.layout.app')
@push('title') {{ __('Service Order') }} @endpush
@push('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
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
            <div class="card bg-info shadow pb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-60">
                                {{-- <img src="{{ asset('uploads/images/users/'.App\User::find($service->worker_id)->image) }}" alt=""> --}}
                                <img src="{{ asset(App\WorkerPage::where('worker_id', $service->worker_id)->first()->image ?? 'uploads/images/defaults/user.png') }}" alt="">
                            </figure>
                        </div>
                        <div class="col pl-0">
                            <div class="row justify-content-between">
                                <div class="col-12  align-self-center">
                                    <h5 class="mb-1" style="text-transform: capitalize">{{ App\WorkerPage::where('worker_id', $service->worker_id)->first()->name }}</h5>
                                </div>
                                <div class="col-12">
                                    <div class="row small text-mute text-trucated mt-1 justify-content-between align-items-center">
                                        @php
                                            $sum = App\ServiceReview::where('worker_service_id', $service->id)->sum('rating');
                                            $count = App\ServiceReview::where('worker_service_id', $service->id)->count();
                                            if (App\ServiceReview::where('worker_service_id', $service->id)->exists()) {
                                                $total_review = $sum/$count;
                                            }else {
                                                $total_review = 0;
                                            }
                                        @endphp
                                        <div class="col-auto d-flex justify-content-between">
                                            {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                                <i class="material-icons btn-outline-warning">star</i>
                                            {{-- @endfor --}}
                                            <span class="text-right text-warning" style="font-size: 20px">{{number_format((float)$total_review, 1, '.', '')}} ({{ $count }})</span>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ App\WorkerPage::where('worker_id', $service->worker_id)->first()->location }}" target="_blank"><i class="material-icons text-warning" style="font-size: 30px;">edit_location</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="margin-top: -15px">
            <div class="card mb-4 shadow">
                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-0 font-weight-normal"> {{ __('price') }} ৳ </h3>
                        </div>
                        <div class="col-auto">
                            <button disabled class="btn btn-info btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b>{{ $service->budget }}</b> </button>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-none">
                    {{-- <div class="row">
                        <div class="col">
                            <p class="gig-title"><b>{{ $service->title }}</b></p>
                        </div>
                    </div> --}}
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <p class="" style="text-transform: capitalize"><b>{{ $service->title }}</b></p>
                        </div>
                        <div class="col-auto">
                            @php
                                $sum = App\ServiceReview::where('worker_service_id', $service->id)->sum('rating');
                                $count = App\ServiceReview::where('worker_service_id', $service->id)->count();
                                if (App\ServiceReview::where('worker_service_id', $service->id)->exists()) {
                                    $total_review = $sum/$count;
                                }else {
                                    $total_review = 0;
                                }
                            @endphp
                            <div class="d-flex align-items-center">
                                {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                    <i class="material-icons btn-outline-warning btn-sm p-0">star</i>
                                {{-- @endfor --}}
                                <span class="text-right text-warning" style="font-size: 15px">{{number_format((float)$total_review, 1, '.', '')}} ({{ $count }})</span>
                            </div>
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
                            <input id="service-id" type="hidden" value="{{$service->id}}">
                            <div class="form-group">
                                <textarea class="form-control form-control-lg" id="description" rows="6" placeholder="{{ __('Your Description') }}"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" id="address" class="form-control form-control-lg" placeholder="{{ __('Your Address') }}...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="date" id="date" class="form-control form-control-lg" placeholder="{{ __('তারিখ') }}" required="">
                        </div>
                        <div class="col">
                            <input type="time" id="time" class="form-control form-control-lg" placeholder="{{ __('সময়') }}" required="">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <!-- End order now area -->
        <div class="container">
            <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                <button disabled type="button" class="btn btn-outline-success active"><small> {{ __('time') }} </small>{{ $service->day }}<small>  {{ __('hours') }}</small></button>
                <button id="job-submit" type="button" class="btn btn-success">
                    {{ __('order now') }}
                </button>
            </div>
        </div>
        <hr>



    <!-- service level script -->
    <script>
        $(document).ready(function(){
            // $('.venobox').venobox();
            //Submit
            $("#job-submit").click(function (){
                $("#job-submit").prop("disabled", true);
                var formData = new FormData();
                formData.append('service', $('#service-id').val())
                formData.append('description', $('#description').val())
                formData.append('address', $('#address').val())
                formData.append('date', $('#date').val())
                formData.append('time', $('#time').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.submitServiceOrderForm') }}",
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
            placeholder: 'Your Description',
            tabsize: 2,
            height: 120,
            toolbar: [

            ]
        });
    </script>
@endsection
