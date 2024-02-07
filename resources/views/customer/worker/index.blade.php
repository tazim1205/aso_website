@extends('customer.layout.app')
@push('title') {{ __('Order') }} @endpush
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
@endpush
@section('content')
<div class="wrapper homepage">
    <!-- header -->
    <div class="header">
        <div class="row no-gutters">
            <div class="col-auto">
                <button class="btn  btn-link text-dark menu-btn"><i class="material-icons">menu</i><span class="new-notification"></span></button>
            </div>
            <div class="col text-center"><img src="{{ asset(get_static_option('header_logo') ?? 'uploads/images/uploads/header_logo.png') }}" alt="" class="header-logo"></div>
            <div class="col-auto">
                <a href="#" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications_none</i><span class="counts">9+</span></a>
            </div>
        </div>
    </div>
    <!-- header ends -->
    <!-- Start worker's bid of this area-->
    <div class="container">
        <div class="row">
            <div class="col-12 px-0">
                <div class="list-group list-group-flush ">
                    @foreach(auth()->user->upazila->workers->bid as $bid)
                    <a class="list-group-item border-top active text-dark" href="#">
                        <div class="row">
                            <div class="col-auto align-self-center">
                                <i class="material-icons text-template-primary">local_mall</i>
                            </div>
                            <div class="col pl-0">
                                <div class="row mb-1">
                                    <div class="col">
                                        <p class="mb-0">{{ $bid->worker->name }}</p>
                                    </div>
                                    <div class="col-auto pl-0">
                                        <p class="small text-mute text-trucated mt-1">2/12/2019</p>
                                    </div>
                                </div>
                                <p class="small text-mute">Order from Anand Mhatva recieved for Electronics with 6 quanity.</p>
                            </div>

                        </div>
                    </a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <!-- End worker's bid of this area-->
    <hr>
    <!-- Start title -->
    <div class="alert alert-primary text-center" role="alert">
        <b id="bid-job">{{ __('BID JOB') }}</b>
    </div>
    <!-- End title -->
    <!-- Start Active job -->
    <div class="container" id="active-job">
        @foreach(auth()->user()->job->where('status', 'active') as $job)
        <div class="card shadow border-0 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="font-weight-normal mb-1"><b>{{ $job->title }}</b></h5>
                        <div class="row text-center">
                            <div class="col-5 text-center color-border">
                                <p class="text text-success mb-2">{{ __('Created') }}</p>
                                <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($job->created_at)) }}</p>
                            </div>
                            <div class="col-3 text-center color-border">
                                <p class="text text-success mb-2">{{ __('16') }}</p>
                                <p class="text-mute small text-secondary mb-2">{{ __('Proposals') }}</p>
                            </div>
                            <div class="col-3 text-center">
                                <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('customer.job.show', \Illuminate\Support\Facades\Crypt::encryptString($job->id)) }}'">
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
    <!-- End Active job -->
    <!-- Start Complete job -->
    <div class="container" id="completed-job">
        @foreach(auth()->user()->job->where('status', 'completed') as $job)
            <div class="card shadow border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="font-weight-normal mb-1"><b>{{ $job->title }}</b></h5>
                            <div class="row">
                                <div class="col-5 text-center color-border">
                                    <p class="text text-success mb-2">{{ __('Created') }}</p>
                                    <p class="text-mute small text-secondary mb-2">{{  date('h:i a d/m/y', strtotime($job->created_at))  }}</p>
                                </div>
                                <div class="col-3 text-center color-border">
                                    <p class="text text-success mb-2">{{ __('16') }}</p>
                                    <p class="text-mute small text-secondary mb-2">{{ __('Proposals') }}</p>
                                </div>
                                <div class="col-3 text-center">
                                    <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('customer.job.show', \Illuminate\Support\Facades\Crypt::encryptString($job->id)) }}'">
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
    <!-- End Completed job -->

    <!-- Start Running job -->
    <div class="container" id="running-job">
        @foreach(auth()->user()->job->where('status', 'running') as $job)
            <div class="card shadow border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="font-weight-normal mb-1"><b>{{ $job->title }}</b></h5>
                            <div class="row">
                                <div class="col-5 text-center color-border">
                                    <p class="text text-success mb-2">{{ __('Created') }}</p>
                                    <p class="text-mute small text-secondary mb-2">{{  date('h:i a d/m/y', strtotime($job->created_at))  }}</p>
                                </div>
                                <div class="col-3 text-center color-border">
                                    <p class="text text-success mb-2">{{ __('16') }}</p>
                                    <p class="text-mute small text-secondary mb-2">{{ __('Proposals') }}</p>
                                </div>
                                <div class="col-3 text-center">
                                    <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('customer.job.show',\Illuminate\Support\Facades\Crypt::encryptString($job->id)) }}'">
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
    <!-- End Running job -->

    <!-- Start Cancelled job -->
    <div class="container" id="cancelled-job">
        @foreach(auth()->user()->job->where('status', 'cancelled') as $job)
            <div class="card shadow border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="font-weight-normal mb-1"><b>{{ $job->title }}</b></h5>
                            <div class="row">
                                <div class="col-5 text-center color-border">
                                    <p class="text text-success mb-2">{{ __('Created') }}</p>
                                    <p class="text-mute small text-secondary mb-2">{{  date('h:i a d/m/y', strtotime($job->created_at))  }}</p>
                                </div>
                                <div class="col-3 text-center color-border">
                                    <p class="text text-success mb-2">{{ __('16') }}</p>
                                    <p class="text-mute small text-secondary mb-2">{{ __('Proposals') }}</p>
                                </div>
                                <div class="col-3 text-center">
                                    <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('customer.job.show', \Illuminate\Support\Facades\Crypt::encryptString($job->id)) }}'">
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
    <!-- End Cancelled job -->
    <!-- Start top ads. by controller this upazila -->
    <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
        <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
            @foreach(auth()->user()->upazila->user->where('role', 'controller') as $controller)
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
    </div>
    <!-- End top ads.  by controller this upazila -->
    <hr>
    <!-- Start title -->
    <div class="alert alert-primary text-center" role="alert">
        <b id="gig-job">{{ __(' GIG JOB') }}</b>
    </div>
    <!-- End title -->
    <h1><b>Under dev ...</b></h1>
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
    <!-- footer-->
    <div class="footer">
        <div class="no-gutters">
            <div class="col-auto mx-auto">
                <div class="row no-gutters justify-content-center">
                    <div class="col-auto">
                        <a href="{{ route('customer.home.index') }}" class="btn btn-link-default active">
                            <i class="material-icons">home</i>
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-link-default">
                            <i class="material-icons">insert_chart_outline</i>
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-link-default">
                            <i class="material-icons">account_balance_wallet</i>
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-link-default">
                            <i class="material-icons">widgets</i>
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-link-default">
                            <i class="material-icons">account_circle</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer ends-->
</div>

<script>
    $(document).ready(function() {
        //Show only active
        $('#bid-job').html('Pending | BID JOB');
        $('#active-job').show();
        $('#completed-job').hide();
        $('#running-job').hide();
        $('#cancelled-job').hide();

        //Active job show
        $('#active-job-btn').click(function (){
            $('#bid-job').html('Pending | BID JOB');
            $('#active-job').show();
            $('#completed-job').hide();
            $('#running-job').hide();
            $('#cancelled-job').hide();
        })

        //Complete job show
        $('#completed-job-btn').click(function (){
            $('#bid-job').html('COMPLETED | BID JOB');
            $('#active-job').hide();
            $('#completed-job').show();
            $('#running-job').hide();
            $('#cancelled-job').hide();
        })

        //Running job show
        $('#running-job-btn').click(function (){
            $('#bid-job').html('RUNNING | BID JOB');
            $('#active-job').hide();
            $('#completed-job').hide();
            $('#running-job').show();
            $('#cancelled-job').hide();
        })

        //Cancelled job show
        $('#cancelled-job-btn').click(function (){
            $('#bid-job').html('CANCELLED | BID JOB');
            $('#active-job').hide();
            $('#completed-job').hide();
            $('#running-job').hide();
            $('#cancelled-job').show();
        })

    });

</script>
@endsection
