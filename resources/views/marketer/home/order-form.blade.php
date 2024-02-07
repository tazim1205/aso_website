@extends('marketer.layout.app')
@push('title') {{ __('Gig Order') }} @endpush
@push('head')
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
            <div class="card bg-info shadow mt-4 h-190">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-60"><img class="worker-profile-image" src="{{ asset('uploads/images/users/'.$gig->worker->image) }}" alt=""></figure>
                        </div>
                        <div class="col pl-0 align-self-center">
                            <h5 class="mb-1">{{ $gig->worker->full_name }}</h5>
                            <div class="col-auto pl-0">
                                <p class="small text-mute text-trucated mt-1">
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
                                    @for ($starCounter = 1; $starCounter <= $star; $starCounter++)
                                        <i class="material-icons btn-outline-warning">star</i>
                                    @endfor
                                </p>
                            </div>
                        </div>
                    </div>
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
                            <button disabled class="btn btn-info btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b>{{ $gig->budget }}</b> </button>
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
                                <textarea class="form-control form-control-lg" id="description" rows="6" placeholder="{{ __('customer/home.description') }}"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" id="address" class="form-control form-control-lg" placeholder="{{ __('customer/home.address') }}...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <!-- End order now area -->
        <div class="container">
            <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                <button disabled type="button" class="btn btn-outline-success active"><small> {{ __('time') }} </small>{{ $gig->day }}<small>  {{ __('day') }}</small></button>
                <button id="job-submit" type="button" class="btn btn-success">
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
                var formData = new FormData();
                formData.append('gig', $('#gig-id').val())
                formData.append('description', $('#description').val())
                formData.append('address', $('#address').val())

                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.submitGigOrderForm') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
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
@endsection
