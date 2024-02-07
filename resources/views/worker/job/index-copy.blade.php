@extends('worker.layout.app')
@push('title') {{ ('Order') }} @endpush
@push('head')
    <style>
        .color-border{
            border-style: solid;
            border-width: thin;
            border-color: white;
            border-radius: 5px;
            margin-left: 10px;
            padding: 10px;
        }
        .view-btn{
            margin-left: -10px;
            height: 100%;
        }
    </style>
    <style>
        .active_service,
        .active_service:hover{
            background: #2BB34B;
            color: white;
        }
        .service_btn{
            font-weight: 700;
            border: 1px solid #2BB34B;
            border-radius: 10px !important;
        }
        .active_bid,
        .active_bid:hover{
            background: #2BB34B;
            color: white;
        }
        .bid_btn{
            border: 1px solid #2BB34B;
        }
        .active_serv,
        .active_serv:hover{
            background: #2BB34B;
            color: white;
        }
        .serv_btn{
            border: 1px solid #2BB34B;
        }
        .active_gig,
        .active_gig:hover{
            background: #2BB34B;
            color: white;
        }
        .gig_btn{
            border: 1px solid #2BB34B;
        }
    </style>
@endpush
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="btn-group d-flex flex-wrap align-items-center justify-content-center">
                    <button class="service_btn btn active" type="button" onclick="openService('bids')" id="active_service">Bid</button>
                    <button class="service_btn btn" type="button" onclick="openService('gigs')">Gig</button>
                    <button class="service_btn btn" type="button" id="service_load" onclick="openService('services')">Service</button>
                </div>
            </div>
        </div>

        <div class="service_wrap">

            <div  id="bids" class="service_item">
                <div class="" id="gig_area">
                    <!-- Start job selection area-->
                    <div class="container">
                        <div class="card shadow mt-4 h-500">
                            <div class="card-body">
                                <div class="row">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    @php
                                                        $activeGig = 0;
                                                        $completeGig = 0;
                                                        $runningGig = 0;
                                                        $cancelledGig = 0;
                                                        foreach (auth()->user()->workerGigs as $gigs){
                                                            foreach ($gigs->customerBids as $customerBid){
                                                                if ($customerBid->status == 'active'){
                                                                    $activeGig++;
                                                                }else if($customerBid->status == 'completed'){
                                                                    $completeGig++;
                                                                }else if($customerBid->status == 'running'){
                                                                    $runningGig++;
                                                                }else if($customerBid->status == 'cancelled'){
                                                                    $cancelledGig++;
                                                                }
                                                            }
                                                        }

                                                        $activeBid = 0;
                                                        $completeBid = 0;
                                                        $runningBid = 0;
                                                        $cancelledBid = 0;
                                                        foreach (auth()->user()->workerBids as $bids){
                                                            if ($bids->customerGig->status == 'cancelled' || $bids->is_cancelled == 1){
                                                                $cancelledBid++;
                                                            }else if ($bids->customerGig->status == 'active'){
                                                                $activeBid++;
                                                            }else if($bids->customerGig->status == 'completed'){
                                                                $completeBid++;
                                                            }else if($bids->customerGig->status == 'running'){
                                                                $runningBid++;
                                                            }
                                                        }
                                                    @endphp
                                                    <button id="active-job-btn" type="button" class="mb-2 btn bid_btn active_bid w-100">{{ ('Pending') }} ({{ $activeBid }})</button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <button id="completed-job-btn" type="button" class="mb-2 btn bid_btn w-100">{{ ('Completed') }} ({{ $completeBid }})</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <button id="running-job-btn" type="button" class="mb-2 btn bid_btn w-100">{{ ('Running ') }} ({{$runningBid }})  &nbsp;</button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <button id="cancelled-job-btn" type="button" class="mb-2 btn bid_btn w-100">{{ ('Cancelled') }} ({{ $cancelledBid }})</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End job selection area-->
                    <hr>
                    <!-- Start title -->
                    <div class="alert alert-primary text-center" role="alert">
                        <b id="bid_heading">PENDING | Bid Order</b>
                    </div>
                    <!-- End title -->
                    <!-- Start WorkerBids -->
                    @foreach(auth()->user()->workerBids as $workerBid)
                        @if($workerBid->customerGig->status == 'cancelled' || $workerBid->is_cancelled == 1)
                            <!-- Start Active job -->
                                <div class="container cancelled-job" id="">
                                    <div class="card shadow border-0 mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="font-weight-normal mb-1"><b>{{ $workerBid->customerGig->title }}</b></h5>
                                                    <div class="row text-center">
                                                        <div class="col-5 text-center color-border">
                                                            <p class="text text-success mb-2">{{ __('Cancelled date') }}</p>
                                                            <p class="text-mute small text-secondary mb-2">{{ date('h:i a, d/m/y', strtotime($workerBid->customerGig->updated_at)) }}</p>
                                                        </div>
                                                        <div class="col-3 text-center color-border">
                                                            <p class="text text-success mb-2">{{ $workerBid->budget }}</p>
                                                            <p class="text-mute small text-secondary mb-2">{{ __('taka') }}</p>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showWorkerBid', \Illuminate\Support\Facades\Crypt::encryptString($workerBid->customerGig->id)) }}'">
                                                                <i class="material-icons">visibility</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Active job -->
                        @elseif($workerBid->customerGig->status == 'active')
                            @php
                                $proposal = App\WorkerBid::where('customer_gig_id',$workerBid->customer_gig_id)->count();
                            @endphp
                            <!-- Start Active job -->
                                <div class="container active-job" id="">
                                    <div class="card shadow border-0 mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="font-weight-normal mb-1"><b>{{ $workerBid->customerGig->title }}</b></h5>
                                                    <div class="row text-center">
                                                        <div class="col-5 text-center color-border">
                                                            <p class="text text-success mb-2">{{ __('Created') }}</p>
                                                            <p class="text-mute small text-secondary mb-2">{{ date('h:i a, d/m/y', strtotime($workerBid->customerGig->created_at)) }}</p>
                                                        </div>
                                                        <div class="col-3 text-center color-border">
                                                            <p class="text text-success mb-2">{{ $proposal }}</p>
                                                            <p class="text-mute small text-secondary mb-2">{{ __('Bid') }}</p>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showWorkerBid', \Illuminate\Support\Facades\Crypt::encryptString($workerBid->customerGig->id)) }}'">
                                                                <i class="material-icons">visibility</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Active job -->
                        @elseif($workerBid->customerGig->status == 'running')
                            <!-- Start Active job -->
                                <div class="container running-job" id="">
                                    <div class="card shadow border-0 mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="font-weight-normal mb-1"><b>{{ $workerBid->customerGig->title }}</b></h5>
                                                    <div class="row text-center">
                                                        <div class="col-5 text-center color-border">
                                                            <p class="text text-success mb-2">{{ __('Created') }}</p>
                                                            <p class="text-mute small text-secondary mb-2">{{ date('h:i a, d/m/y', strtotime($workerBid->customerGig->created_at)) }}</p>
                                                        </div>
                                                        <div class="col-3 text-center color-border">
                                                            <p class="text text-success mb-2">{{ $workerBid->budget }}</p>
                                                            <p class="text-mute small text-secondary mb-2">{{ __('taka') }}</p>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showWorkerBid', \Illuminate\Support\Facades\Crypt::encryptString($workerBid->customerGig->id)) }}'">
                                                                <i class="material-icons">visibility</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Active job -->
                        @elseif($workerBid->customerGig->status == 'completed')
                            <!-- Start Active job -->
                                <div class="container completed-job" id="">
                                    <div class="card shadow border-0 mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="font-weight-normal mb-1"><b>{{ $workerBid->customerGig->title }}</b></h5>
                                                    <div class="row text-center">
                                                        <div class="col-5 text-center color-border">
                                                            <p class="text text-success mb-2">{{ __('Delivery date') }}</p>
                                                            <p class="text-mute small text-secondary mb-2">{{ date('h:i a, d/m/y', strtotime($workerBid->customerGig->updated_at)) }}</p>
                                                        </div>
                                                        <div class="col-3 text-center color-border">
                                                            <p class="text text-success mb-2">{{ $workerBid->budget }}</p>
                                                            <p class="text-mute small text-secondary mb-2">{{ __('taka') }}</p>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showWorkerBid', \Illuminate\Support\Facades\Crypt::encryptString($workerBid->customerGig->id)) }}'">
                                                                <i class="material-icons">visibility</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Active job -->

                        @endif
                    @endforeach
                    <!-- End WorkerBids -->
                    <!-- Start top ads. by controller this upazila -->
                    @include('worker.partials.ads')
                    <!-- End top ads.  by controller this upazila -->

                </div>
            </div>

            <div  id="gigs" class="service_item">

                <!-- Start job selection area-->
                <div class="container">
                    <div class="card shadow mt-4 h-500">
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <button id="active-gig-btn" type="button" class="mb-2 btn gig_btn active_gig">{{ __('Pending Order') }}
                                                    ({{ $activeGig }})
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <button id="completed-gig-btn" type="button" class="mb-2 btn gig_btn">{{ __('completed') }}
                                                    ({{ $completeGig }})
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <button id="running-gig-btn" type="button" class="mb-2 btn gig_btn">{{ __('running order') }}
                                                    ({{ $runningGig }})
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <button id="cancelled-gig-btn" type="button" class="mb-2 btn gig_btn">{{ __('cancelled') }}
                                                    ({{ $cancelledGig }})
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End job selection area-->
                <hr>
                <!-- Start title -->
                <div class="alert alert-primary text-center" role="alert">
                    <b id="gig_heading"> PENDING | Gig Order</b>
                </div>
                <!-- End title -->

                <!-- Start Active service job -->
                <div class="container active-gig">
                    {{-- @foreach(auth()->user()->workerGigBids->where('status', 'active') as $gig)
                        @php
                            $today = date("Y-m-d H:i:s");
                            $datetime1 = new DateTime($today);//start time
                            $datetime2 = new DateTime($gig->created_at);//end time
                            $interval = $datetime1->diff($datetime2);
                            $interval->format('%H');
                        @endphp
                        @if($interval->format('%H') >= get_static_option('worker_job_request_accept_hour'))
                            @php
                            $updateGig = App\CustomerBid::find($gig->id);
                            $updateGig->status            = 'cancelled';
                            $updateGig->save();
                            @endphp
                        @endif

                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="font-weight-normal mb-1"><b>{{ App\WorkerGig::find($gig->worker_gig_id)->title }}</b></h5>
                                        <div class="row text-center">
                                            <div class="col-5 text-center color-border">
                                                <p class="text text-success mb-2">{{ __('created') }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($gig->created_at)) }}</p>
                                            </div>
                                            <div class="col-3 text-center color-border">
                                                <p class="text text-success mb-2">{{ $gig->budget }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ __('taka') }}</p>
                                            </div>
                                            <div class="col-3 text-center">
                                                <button type="button" class="mb-2 btn btn-lg btn-success view-btn"
                                                        onclick="window.location.href='{{ route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($gig->id)) }}'">
                                                    <i class="material-icons">visibility</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach --}}

                    @foreach(auth()->user()->workerGigs as $workerGigs)
                        @foreach($workerGigs->customerBids->where('status', 'active') as $customerBids)
                            <div class="card shadow border-0 mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="font-weight-normal mb-1"><b>{{ $workerGigs->title }}</b></h5>
                                            <div class="row text-center">
                                                <div class="col-5 text-center color-border">
                                                    <p class="text text-success mb-2">{{ __('Created') }}</p>
                                                    <p class="text-mute small text-secondary mb-2">{{ date('h:i a, d/m/y', strtotime($customerBids->created_at)) }}</p>
                                                </div>
                                                <div class="col-3 text-center color-border">
                                                    <p class="text text-success mb-2">{{ $workerGigs->budget }}</p>
                                                    <p class="text-mute small text-secondary mb-2">{{ __('Taka') }}</p>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($customerBids->id)) }}'">
                                                        <i class="material-icons">visibility</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                </div>
                <!-- End Active service job -->

                <!-- Start completed service job -->
                <div class="container completed-gig">
                    @foreach(auth()->user()->workerGigs as $workerGigs)
                        @foreach($workerGigs->customerBids->where('status', 'completed') as $customerBids)
                            <div class="card shadow border-0 mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="font-weight-normal mb-1"><b>{{ $workerGigs->title }}</b></h5>
                                            <div class="row text-center">
                                                <div class="col-5 text-center color-border">
                                                    <p class="text text-success mb-2">{{ __('Created') }}</p>
                                                    <p class="text-mute small text-secondary mb-2">{{ date('h:i a, d/m/y', strtotime($customerBids->created_at)) }}</p>
                                                </div>
                                                <div class="col-3 text-center color-border">
                                                    <p class="text text-success mb-2">{{ $customerBids->budget }}</p>
                                                    <p class="text-mute small text-secondary mb-2">{{ __('Taka') }}</p>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($customerBids->id)) }}'">
                                                        <i class="material-icons">visibility</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                <!-- End completed service job -->

                <!-- Start runnng service job -->
                <div class="container running-gig">
                    @foreach(auth()->user()->workerGigs as $workerGigs)
                        @foreach($workerGigs->customerBids->where('status', 'running') as $customerBids)
                            <div class="card shadow border-0 mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="font-weight-normal mb-1"><b>{{ $workerGigs->title }}</b></h5>
                                            <div class="row text-center">
                                                <div class="col-5 text-center color-border">
                                                    <p class="text text-success mb-2">{{ __('Created') }}</p>
                                                    <p class="text-mute small text-secondary mb-2">{{ date('h:i a, d/m/y', strtotime($customerBids->created_at)) }}</p>
                                                </div>
                                                <div class="col-3 text-center color-border">
                                                    <p class="text text-success mb-2">{{ $customerBids->budget }}</p>
                                                    <p class="text-mute small text-secondary mb-2">{{ __('Taka') }}</p>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($customerBids->id)) }}'">
                                                        <i class="material-icons">visibility</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                <!-- End runnng service job -->

                <!-- Start Cancelled service job -->
                <div class="container cancelled-gig">
                    @foreach(auth()->user()->workerGigs as $workerGigs)
                        @foreach($workerGigs->customerBids->where('status', 'cancelled') as $customerBids)
                            <div class="card shadow border-0 mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="font-weight-normal mb-1"><b>{{ $workerGigs->title }}</b></h5>
                                            <div class="row text-center">
                                                <div class="col-5 text-center color-border">
                                                    <p class="text text-success mb-2">{{ __('Created') }}</p>
                                                    <p class="text-mute small text-secondary mb-2">{{ date('h:i a, d/m/y', strtotime($customerBids->created_at)) }}</p>
                                                </div>
                                                <div class="col-3 text-center color-border">
                                                    <p class="text text-success mb-2">{{ $customerBids->budget }}</p>
                                                    <p class="text-mute small text-secondary mb-2">{{ __('Taka') }}</p>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showCustomerBid', \Illuminate\Support\Facades\Crypt::encryptString($customerBids->id)) }}'">
                                                        <i class="material-icons">visibility</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
                <!-- End Cancelled service job -->

                <!-- Start middle ads. by admin for all-->
                    <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
                        <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                            @foreach($adminAds as $adminAds)
                                <div class="swiper-slide swiper-slide-active">
                                    <div class="card">
                                        <div class="card-body">
                                            <a  @if($adminAds->url) href="{{ $adminAds->url }}" target="_blank" @endif >
                                                <img src="{{ asset($adminAds->image) }}" height="100%" width="100%" style="border-radius: 5px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                    <!-- End middle ads. by admin for all-->

            </div>

            <div  id="services" class="service_item">
                <!-- Start job selection area-->
                <div class="container">
                    <div class="card shadow mt-4 h-500">
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <button id="active-service-btn" type="button" class="mb-2 btn serv_btn active_serv">{{ __('Pending Order') }}
                                                    ({{ count(auth()->user()->workerServiceBids->where('status', 'active')) }})
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <button id="completed-service-btn" type="button" class="mb-2 btn serv_btn">{{ __('completed Order') }}
                                                    ({{ count(auth()->user()->workerServiceBids->where('status', 'completed')) }})
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <button id="running-service-btn" type="button" class="mb-2 btn serv_btn">{{ __('running order') }}
                                                    ({{ count(auth()->user()->workerServiceBids->where('status', 'running')) }})
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <button id="cancelled-service-btn" type="button" class="mb-2 btn serv_btn">{{ __('cancelled Order') }}
                                                    ({{ count(auth()->user()->workerServiceBids->where('status', 'cancelled')) }})
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End job selection area-->
                <hr>
                <!-- Start title -->
                <div class="alert alert-primary text-center" role="alert">
                    <b id="service_heading"> MY All SERVICES</b>
                </div>
                <!-- End title -->

                <!-- Start Active service job -->
                <div class="container active-service">
                    @foreach(auth()->user()->workerServiceBids->where('status', 'active') as $service)
                        @php
                            $today = date("Y-m-d H:i:s");
                            $datetime1 = new DateTime($today);//start time
                            $datetime2 = new DateTime($service->created_at);//end time
                            $interval = $datetime1->diff($datetime2);
                            $interval->format('%H');
                        @endphp
                        @if($interval->format('%H') >= get_static_option('worker_job_request_accept_hour'))
                            {{-- @php
                            $ServiceBid = App\ServiceBid::find($service->id);
                            $ServiceBid->status            = 'cancelled';
                            $ServiceBid->save();
                            @endphp --}}
                        @endif
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="font-weight-normal mb-1"><b>{{ App\PageService::withTrashed()->find($service->worker_service_id)->title }}</b></h5>
                                        <div class="row text-center">
                                            <div class="col-5 text-center color-border">
                                                <p class="text text-success mb-2">{{ __('created') }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($service->created_at)) }}</p>
                                            </div>
                                            <div class="col-3 text-center color-border">
                                                <p class="text text-success mb-2">{{ $service->budget }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ __('taka') }}</p>
                                            </div>
                                            <div class="col-3 text-center">
                                                <button type="button" class="mb-2 btn btn-lg btn-success view-btn"
                                                        onclick="window.location.href='{{ route('worker.showserviceBid', \Illuminate\Support\Facades\Crypt::encryptString($service->id)) }}'">
                                                    <i class="material-icons">visibility</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- End Active service job -->

                <!-- Start completed service job -->
                <div class="container completed-service">
                    @foreach(auth()->user()->workerServiceBids->where('status', 'completed') as $service)
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="font-weight-normal mb-1"><b>{{ App\PageService::withTrashed()->find($service->worker_service_id)->title }}</b></h5>
                                        <div class="row text-center">
                                            <div class="col-5 text-center color-border">
                                                <p class="text text-success mb-2">{{ __('created') }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($service->created_at)) }}</p>
                                            </div>
                                            <div class="col-3 text-center color-border">
                                                <p class="text text-success mb-2">{{ $service->budget }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ __('taka') }}</p>
                                            </div>
                                            <div class="col-3 text-center">
                                                <button type="button" class="mb-2 btn btn-lg btn-success view-btn"
                                                        onclick="window.location.href='{{ route('worker.showserviceBid', \Illuminate\Support\Facades\Crypt::encryptString($service->id)) }}'">
                                                    <i class="material-icons">visibility</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- End completed service job -->

                <!-- Start runnng service job -->
                <div class="container running-service">
                    @foreach(auth()->user()->workerServiceBids->where('status', 'running') as $service)
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="font-weight-normal mb-1"><b>{{ App\PageService::withTrashed()->find($service->worker_service_id)->title }}</b></h5>
                                        <div class="row text-center">
                                            <div class="col-5 text-center color-border">
                                                <p class="text text-success mb-2">{{ __('created') }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($service->created_at)) }}</p>
                                            </div>
                                            <div class="col-3 text-center color-border">
                                                <p class="text text-success mb-2">{{ $service->budget }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ __('taka') }}</p>
                                            </div>
                                            <div class="col-3 text-center">
                                                <button type="button" class="mb-2 btn btn-lg btn-success view-btn"
                                                        onclick="window.location.href='{{ route('worker.showserviceBid', \Illuminate\Support\Facades\Crypt::encryptString($service->id)) }}'">
                                                    <i class="material-icons">visibility</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- End runnng service job -->

                <!-- Start Cancelled service job -->
                <div class="container cancelled-service">
                    @foreach(auth()->user()->workerServiceBids->where('status', 'cancelled') as $service)
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="font-weight-normal mb-1"><b>{{ App\PageService::withTrashed()->find($service->worker_service_id)->title }}</b></h5>
                                        <div class="row text-center">
                                            <div class="col-5 text-center color-border">
                                                <p class="text text-success mb-2">{{ __('created') }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($service->created_at)) }}</p>
                                            </div>
                                            <div class="col-3 text-center color-border">
                                                <p class="text text-success mb-2">{{ $service->budget }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ __('taka') }}</p>
                                            </div>
                                            <div class="col-3 text-center">
                                                <button type="button" class="mb-2 btn btn-lg btn-success view-btn"
                                                        onclick="window.location.href='{{ route('worker.showserviceBid', \Illuminate\Support\Facades\Crypt::encryptString($service->id)) }}'">
                                                    <i class="material-icons">visibility</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- End Cancelled service job -->
            </div>

        </div>

        <div class="row">

            <div class="col-md-12" id="page_area">
            </div>
        </div>
    </div>


<script>
    //service area js Start
    $('.service_btn').on('click', function () {
        $('.service_btn').removeClass('active_service');
        $(this).addClass('active_service');
    });

    function openService(service) {
        var i, service_item;
        service_item = document.getElementsByClassName("service_item");
        for (i = 0; i < service_item.length; i++) {
            service_item[i].style.display = "none";
        }
        document.getElementById(service).style.display = "block";
    }
    document.getElementById("active_service").click();
    //service js ends
</script>
{{-- bid script start  --}}
    <script>
        $('.bid_btn').on('click', function () {
            $('.bid_btn').removeClass('active_bid');
            $(this).addClass('active_bid');
        });




    </script>
    {{-- bid script end  --}}
<script>
    $(document).ready(function() {

        $('#page_area').hide();
        $('#gig-btn').on('click', function(e){
            $('#gig_area').show();
            $('#page_area').hide();

            $('#gig-btn').removeClass( "btn-default" );
            $('#gig-btn').addClass( "btn-success" );

            $('#page-btn').removeClass( "btn-success" );
            $('#page-btn').addClass( "btn-default" );
        });

        $('#page-btn').on('click', function(e){
            $('#gig_area').hide();
            $('#page_area').show();

            $('#page-btn').removeClass( "btn-default" );
            $('#page-btn').addClass( "btn-success" );

            $('#gig-btn').removeClass( "btn-success" );
            $('#gig-btn').addClass( "btn-default" );
        });

        //Show only active
        $('.active-job').show();
        $('.completed-job').hide();
        $('.running-job').hide();
        $('.cancelled-job').hide();

        //Active job show
        $('#active-job-btn').click(function (){
            $('#bid_heading').html('PENDING | Bid Order');
            $('.active-job').show();
            $('.completed-job').hide();
            $('.running-job').hide();
            $('.cancelled-job').hide();
        })

        //Complete job show
        $('#completed-job-btn').click(function (){
            $('#bid_heading').html('COMPLETED | Bid Order');
            $('.active-job').hide();
            $('.completed-job').show();
            $('.running-job').hide();
            $('.cancelled-job').hide();
        })

        //Running job show
        $('#running-job-btn').click(function (){
            $('#bid_heading').html('RUNNING | Bid Order');
            $('.active-job').hide();
            $('.completed-job').hide();
            $('.running-job').show();
            $('.cancelled-job').hide();
        })

        //Cancelled job show
        $('#cancelled-job-btn').click(function (){
            // alert("ok");
            $('#bid_heading').html('CANCELLED | Bid Order');
            $('.active-job').hide();
            $('.completed-job').hide();
            $('.running-job').hide();
            $('.cancelled-job').show();
        })

    });

</script>

{{-- gigs script start  --}}
    <script>
        $('.gig_btn').on('click', function () {
            $('.gig_btn').removeClass('active_gig');
            $(this).addClass('active_gig');
        });

        //Show only active
        $('.active-gig').show();
        $('.completed-gig').hide();
        $('.running-gig').hide();
        $('.cancelled-gig').hide();

        //Active service show
        $('#active-gig-btn').click(function (){
            $('#gig_heading').html('PENDING | Gig Order');
            $('.active-gig').show();
            $('.completed-gig').hide();
            $('.running-gig').hide();
            $('.cancelled-gig').hide();
        })
        //completed service show
        $('#completed-gig-btn').click(function (){
            $('#gig_heading').html('COMPLETED | Gig Order');
            $('.active-gig').hide();
            $('.completed-gig').show();
            $('.running-gig').hide();
            $('.cancelled-gig').hide();
        })
        //runnng service show
        $('#running-gig-btn').click(function (){
            $('#gig_heading').html('RUNNING | Gig Order');
            $('.active-gig').hide();
            $('.completed-gig').hide();
            $('.running-gig').show();
            $('.cancelled-gig').hide();
        })

        //Cancelled service show
        $('#cancelled-gig-btn').click(function (){
            $('#gig_heading').html('CANCELLED | Gig Order');
            $('.active-gig').hide();
            $('.completed-gig').hide();
            $('.running-gig').hide();
            $('.cancelled-gig').show();
        })

        $(document).ready(function() {

        });
    </script>

    {{-- services script start  --}}
    <script>
        $('.serv_btn').on('click', function () {
            $('.serv_btn').removeClass('active_serv');
            $(this).addClass('active_serv');
        });


        //Show only active
        $('.active-service').show();
        $('.completed-service').hide();
        $('.running-service').hide();
        $('.cancelled-service').hide();

        //Active service show
        $('#active-service-btn').click(function (){
            $('#service_heading').html('PENDING | Service Order');
            $('.active-service').show();
            $('.completed-service').hide();
            $('.running-service').hide();
            $('.cancelled-service').hide();
        })
        //completed service show
        $('#completed-service-btn').click(function (){
            $('#service_heading').html('COMPLETED | Service Order');
            $('.active-service').hide();
            $('.completed-service').show();
            $('.running-service').hide();
            $('.cancelled-service').hide();
        })
        //runnng service show
        $('#running-service-btn').click(function (){
            $('#service_heading').html('RUNNING | Service Order');
            $('.active-service').hide();
            $('.completed-service').hide();
            $('.running-service').show();
            $('.cancelled-service').hide();
        })

        //Cancelled service show
        $('#cancelled-service-btn').click(function (){
            $('#service_heading').html('CANCELLED | Service Order');
            $('.active-service').hide();
            $('.completed-service').hide();
            $('.running-service').hide();
            $('.cancelled-service').show();
        })

        $(document).ready(function() {

        });
    </script>

    <script>
        if ("{{ session('service_click') }}") {
            $("#service_load").trigger("click");
        }
        if ("{{ session('pending_service_click') }}") {
            $("#active-service-btn").trigger("click");
        }
        if ("{{ session('cancelled_service_click') }}") {
            $("#cancelled-service-btn").trigger("click");
        }
        if ("{{ session('running_service_click') }}") {
            $("#running-service-btn").trigger("click");
        }
        if ("{{ session('completed_service_click') }}") {
            $("#completed-service-btn").trigger("click");
        }
    </script>
    {{-- packages script end  --}}
    {{ Session::forget('service_click') }}
    {{ Session::forget('pending_service_click') }}
    {{ Session::forget('cancelled_service_click') }}
    {{ Session::forget('running_service_click') }}
    {{ Session::forget('completed_service_click') }}
@endsection
