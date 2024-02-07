@extends('customer.layout.app')
@push('title') {{ __('Order') }} @endpush
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
    <!--Start active job detail view -->
    @if($job->status == 'active')
        <!-- Start title -->
        <div class="">
                <div class="alert alert-info text-center" role="alert">
                    <b id=""> {{ __('BID ORDER') }}</b>
                </div>
            </div>
        <!-- End title -->
        <!--Start owner info & price-->
        <div class="container">
            <div class="card bg-info shadow mt-4 h-190">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-60"><img src="{{ asset('uploads/images/users/'.$job->customer->image) }}" alt=""></figure>
                            </div>
                            <div class="col pl-0 align-self-center">
                                <h5 class="mb-1">{{ $job->customer->full_name }}</h5>
                                <p class="text-mute small">{{ $job->customer->phone }}</p>
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
                                <button disabled class="btn btn-info btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b>{{ $job->budget }}</b> </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-none">
                        <div class="row">
                            <div class="col">
                                <p><b>{{ $job->title }}</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--End owner info & price-->
        <!--Start work detail , address, day-->
        <div class="container">
            <h4 class="mb-3"><b>{{ __('Work details:') }}</b></h4>
            <div>{!! $job->description !!}</div>
            <h4 class="mb-3"><b>{{ __('Address:') }}</b></h4>
            <p>{{ $job->address }}</p>
            <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                <button disabled type="button" class="btn btn-outline-success active"><small>{{ __('Time') }} </small>{{ $job->day }}<small> {{ __('Hours') }}</small></button>
                <button id="job-cancel" onclick="window.location.href='{{ route('customer.job.edit', \Illuminate\Support\Facades\Crypt::encryptString($job->id)) }}'" type="button" class="btn btn-danger">{{ __('Cancel') }}</button>
            </div>
        </div>
        <!--End work detail , address, day-->
            <hr>
        <!-- Start bid title -->
        <div class="">
                <div class="alert alert-info text-center" role="alert">
                    <b id=""> {{ __('ALL BIDS') }}</b>
                </div>
            </div>
        <!-- End title -->
       <!-- Start Bids -->
        <h1>Under dev...</h1>
        <!-- End Bids -->
    @elseif($job->status == 'cancelled')
            <!-- Start title -->
            <div class="">
                <div class="alert alert-danger text-center" role="alert">
                    <b id=""> {{ __('CANCELLED ORDER') }}</b>
                </div>
            </div>
            <!-- End title -->
            <!--Start Canceller info & price-->
            <div class="container">
                <div class="card bg-danger shadow mt-4 h-190">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-60"><img src="{{ asset('uploads/images/users/'.$job->cancelInfo->canceller->image) }}" alt=""></figure>
                            </div>
                            <div class="col pl-0 align-self-center">
                                <h5 class="mb-1">{{ $job->cancelInfo->canceller->full_name }}</h5>
                                <p class="text-mute small"><b>{{ __('Under dev.. ***') }}</b></p>
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
                                <button disabled class="btn btn-danger btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b>{{ $job->budget }}</b> </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-none">
                        <div class="row">
                            <div class="col">
                                <p><b>{{ $job->title }}</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Canceller info & price-->
            <hr>
            <!--Start work detail , address, day-->
            <div class="container">
                <h4 class="mb-3"><b>{{ __('Work details:') }}</b></h4>
                <div>{!! $job->description !!}</div>
                <h4 class="mb-3"><b>{{ __('Address:') }}</b></h4>
                <p>{{ $job->address }}</p>
                <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                    <button disabled type="button" class="btn btn-outline-danger active"><b>{{ __('Cancelled Date') }}</b> <br> <small> {{ date('h:i:s a d/m/y', strtotime($job->updated_at)) }}</small></button>
                </div>
            </div>
    @endif
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
@endsection
