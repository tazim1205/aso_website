 @extends('worker.layout.app')
@push('title') {{ __('Order') }} @endpush

@section('content')

    <!--Start active job detail view -->

        <!-- Start title -->
        <div class="">
                <div class="alert alert-info text-center" role="alert">
                    <b id=""> {{ __('BID Order') }}</b>
                </div>
            </div>
        <!-- End title -->
        <!--Start owner info & price-->
        <div class="container mb-4">
            <div class="card bg-info shadow mt-4" style="height: 100px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-60"><img src="{o{ asset($custmerGig->customer->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                        </div>
                        <div class="col pl-0 align-self-center">
                            <h5 class="mb-1">{{ $customerGig->customer->full_name }}</h5>
                        </div>

                        <div class="col pl-0 align-self-center text-right">
                            <a href="{{ $customerGig->customer->location }}" target="_blank"><i class="material-icons text-warning" style="font-size: 30px;">edit_location</i></a>
                        </div>
                    </div>
                </div>
             </div>
        </div>
        <div class="container ">
            <div class="card mb-4 shadow">

                <div class="card-footer bg-none">
                    <div class="row">
                        <div class="col">
                            <p><b>{{ $customerGig->title }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End owner info & price-->
        <!--Start work detail , address, day-->
        <div class="container mt-5">
            <h4 class="mb-3"><b>{{ __('কাজের বিবরণ:') }}</b></h4>
            <div>{!! $customerGig->description !!}</div>
            <h4 class="mb-3"><b>{{ __('ঠিকানা:') }}</b></h4>
            <p>{{ $customerGig->address }}</p>
            <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                <button disabled type="button" class="btn btn-outline-success active col"><small> {{ __('ডেলিবারি সময়') }} </small>{{ $customerGig->day }}<small> {{ __('ঘন্টা ') }}</small></button>
                <button disabled type="button" class="btn btn-success col">{{  date('h:i a, d/m/y', strtotime($customerGig->created_at)) }}</button>

            </div>

            <div class="w-100 mb-2 text-center" >
                <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('কাস্টমার অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় দিয়েছেন ') }} </small>{{  date('h:i a', strtotime($customerGig->time)) }}, {{  date('d F Y', strtotime($customerGig->date)) }} </button>
            </div>
        </div>
        <!--End work detail , address, day-->
            <hr>

        @if(auth()->user()->workerBids()->where('customer_gig_id', $customerGig->id)->exists())
            <!-- Start bid title -->
            <div class="">
                <div class="alert alert-danger text-center" role="alert">
                    <b id=""> {{ __('BID ALREADY SUBMITTED') }}</b>
                </div>
            </div>
        <!-- End title -->
        @else
        <div class="mb-2">
            <div class=" text-center" role="alert">
                <button type="button" class="btn btn-primary">
                    {{ __('TOTAL BID') }} <span class="badge badge-light"><b id=""> {{ $customerGig->workerBids->where('worker_id', '!=', auth()->user()->id)->where('is_cancelled', 0)->count() }}</b></span>
                </button>
            </div>
        </div>
                <!-- Start bid title -->
                <div class="">
                    <div class="alert alert-info text-center" role="alert">
                        <b id=""> {{ __('Bid Now') }}</b>
                    </div>
                </div>
                <!-- End title -->
                <!-- Start Bids -->
                <div class="card-body">
                    <div class="row">
                        <div class="container">
                            <div class="form-group">
                                <input type="number" id="budget" class="form-control form-control-lg text-success text-center" placeholder="{{ __('অফার প্রাইস') }}">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control form-control-lg text-success" id="description" rows="6" placeholder="{{ __('আপনার অফারের বিবরণ') }}"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="job-id" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($customerGig->id) }}">

                                {{-- @if(App\User::worker_bid_gig_limit(auth()->user()->id)) --}}
                                    <button type="button" id="bid-submit-button" class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('সাবমিট ') }}</button>
                                {{-- @else
                                    <button type="button" class="mb-2 btn btn-lg btn-success w-100 btn-rounded" data-toggle="modal" data-target="#rechargeModalforBid">
                                        <b>{{ __('সাবমিট ') }}</b>
                                    </button>
                                @endif --}}

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Bids -->
        @endif
<!-- Start bid title -->

    <!-- End title -->
{{-- @foreach($customerGig->workerBids->where('worker_id', '!=', auth()->user()->id)->where('is_cancelled', 0) as $bid)
    <!--Start worker info & price-->
        <div class="container">
            <div class="card bg-info shadow mt-4 h-190">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-60"><img src="{{ asset($bid->worker->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                        </div>
                        <div class="col pl-0 align-self-center">
                            <h5 class="mb-1">{{ $bid->worker->full_name }}</h5>
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
                            <h3 class="mb-0 font-weight-normal">{{ __('Price ৳ ') }}</h3>
                        </div>
                        <div class="col-auto">
                            <button disabled class="btn btn-info btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b>{{ $bid->budget }}</b> </button>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-none">
                    <div class="row">
                        <div class="col">
                            <div>{!! $bid->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End worker info & price-->
@endforeach --}}

    <!-- footer-->
<script>
    $(document).ready(function() {
        //Submit new Job
        $('#bid-submit-button').click(function(){
            $("#bid-submit-button").prop("disabled", true);
            var balance = {{ App\User::worker_bid_gig_limit(auth()->user()->id) }}
            // alert('balance');
            if(Number($('#budget').val()) <= Number(balance)) {

                var formData = new FormData();
                formData.append('description', $('#description').val())
                formData.append('budget', $('#budget').val())
                formData.append('jobId', $('#job-id').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('worker.storeWorkerBid') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#bid-submit-button").prop("disabled", false);
                        $('#description').val('');
                        $('#budget').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Bid Successful.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            //your code to be executed after 1 second
                            // location.replace("/worker/bid/"+$('#job-id').val())
                            location.replace("/worker/order");
                        }, 1000);//2 second
                    },
                    error: function (xhr) {
                        $("#bid-submit-button").prop("disabled", false);
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
            }else{
                $('#rechargeModalforBid').modal('show');
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'error',
                //     title: 'Your balance is low for this order.',
                //     showConfirmButton: false,
                //     timer: 1500
                // })
            }
        });
    });
</script>
@endsection
