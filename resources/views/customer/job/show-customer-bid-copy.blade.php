@extends('customer.layout.app')
@push('title') {{ __('Order') }} @endpush
@push('head')
<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
<style>
    .color-border {
        border-style: solid;
        border-width: thin;
        border-color: white;
        border-radius: 5px;
        margin-left: 5px;
        padding: 10px;
    }

    .view-btn {
        margin-left: -10px;
        height: 100%;
    }
</style>
@endpush
@section('content')
<!--Start active job detail view -->
@if($customerBid->status == 'active')
<!-- Start title -->
<div class="">
    <div class="alert alert-info row" role="alert">
        <div class="col-1">
            <a href="{{ route('customer.myJob') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                    class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                </svg>
            </a>
        </div>
        <div class="col text-center">
            <b id=""> {{ __('Gig Order') }}</b>
        </div>
        <div class="col-1"></div>
    </div>
</div>
<!-- End title -->
<!--Start owner info & price-->
<div class="container">
    <div class="card bg-info shadow pb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                    <figure class="avatar avatar-60"><img
                            src="{{ asset($customerBid->workerGig->worker->image ?? 'uploads/images/defaults/user.png') }}"
                            alt=""></figure>
                </div>
                <div class="col pl-0 align-self-center">
                    <h5 class="mb-1">{{ $customerBid->workerGig->worker->full_name }}</h5>
                    <div class="col-auto pl-0">

                        <p class="small text-mute text-trucated mt-1">
                            @php
                            $percent = 100 - (($customerBid->customer->rating->max_rate -
                            $customerBid->customer->rating->rate)/$customerBid->customer->rating->max_rate)*100;
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
                            @for ($starCounter = 1; $starCounter <= $star; $starCounter++) <i
                                class="material-icons btn-outline-warning">star</i>
                                @endfor
                        </p>
                    </div>
                </div>
                <div class="col-auto pl-0 pt-4">
                    <a href="{{ $customerBid->workerGig->worker->location }}" target="_blank" class="text-warning p-4">
                        <i class="fa fa-map-marker"></i> Location</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container" style="margin-top: -15px">
    <div class="card mb-4 shadow">
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center pt-2 pb-2">
                <strong>Order Id: </strong>
                <div>#AO{{ $customerBid->id }}</div>
            </div>
            <div class="row">
                <div class="col">
                    <h3 class="mb-0 font-weight-normal">{{ __('price') }} ৳ </h3>
                </div>
                <div class="col-auto">
                    <button disabled class="btn btn-info btn-rounded-54 shadow"> <b>{{ $customerBid->budget }}</b>
                    </button>
                </div>
            </div>

        </div>
        <div class="card-footer bg-none">

            <!-- new budget -->
            <div class="">
                <div class=" text-center" role="alert">
                    <div class="row">
                        <div class="container">
                            <div class="row container">
                                {{ __('প্রয়োজন অনুযায়ী প্রাইস পরিবর্তন করুন') }}
                                <hr>
                            </div>
                            <div class="row P-2">
                                <div class="col-lg-10 col-12">
                                    <div class="form-group mb-2 ">
                                        <input type="hidden" id="bid-id" value="{{ $customerBid->id }}">
                                        <input type="number" id="budget" placeholder="250"
                                            class="form-control form-control-lg text-center">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-12 text-center">
                                    <button type="button" id="update_budget"
                                        data-worker-limit="{{ App\User::worker_bid_gig_limit($customerBid->workerGig->worker_id) }}"
                                        class="mb-2 btn btn-lg btn-info" style="width: 100%">{{ __('submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                @if ($customerBid->proposed_budget )
                <div class="col-12">
                    <div class="alert alert-success text-center"><i class="fa fa-exclamation-circle text-danger"></i>
                        সার্ভিস প্রোভাইডার অর্ডারটি <strong>{{ $customerBid->proposed_budget }}/-</strong> টাকায় করতে
                        আগ্রহী। সম্মত থাকলে Accept করুন অথবা Reject করুন।</div>
                    <div class="btn-group d-flex flex-wrap">
                        <input type="hidden" id="proposed_budget" value="{{ $customerBid->proposed_budget }}">
                        <button class="btn btn-lg btn-success  mr-1" id="accept_budget"
                            style="border-radius: 5px !important;">Accept</button>
                        <button class="btn btn-lg btn-danger ml-1" id="cancel_budget"
                            style="border-radius: 5px !important;">cancel</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!--End owner info & price-->

<!--Start work detail , address, day-->
<div class="container">
    <h5 class="mb-3"><b> {{ $customerBid->workerGig->title }} </b></h5>
    <br>
    <h4 class="mb-3"><b>{{ __('Work details:') }}</b></h4>
    <div>{!! $customerBid->description !!}</div>
    <h4 class="mb-3"><b>{{ __('Address:') }}</b></h4>
    <p>{{ $customerBid->workerGig->worker->address }}</p>
    <hr>
    <div class="alert text-mute text-justify" style="text-align-last: center;">নির্দিষ্ট সময়ের মধ্যে সার্ভিস প্রোভাইডার
        /ওয়ার্কার কর্তৃক অর্ডারটি Confirm হওয়ার জন্য একটু অপেক্ষা করুন। নির্দিষ্ট সময়ের মধ্যে অর্ডার Confirm না করলে
        অর্ডারটি Auto Cancel হয়ে যাবে। সেক্ষেত্রে অন্য সার্ভিস প্রোভাইডার /ওয়ার্কারকে পুনরায় অর্ডার করতে পারবেন।</div>
    <hr>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
            <div class="single_counter text-center">
                <h4 id="days">00</h4>
                <span>Days</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
            <div class="single_counter text-center">
                <h4 id="hours">00</h4>
                <span>Hours</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
            <div class="single_counter text-center">
                <h4 id="minutes">00</h4>
                <span>Minutes</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
            <div class="single_counter text-center">
                <h4 id="seconds">00</h4>
                <span>Seconds</span>
            </div>
        </div>
    </div>
    <hr>
    <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
        <button disabled type="button" class="btn btn-outline-success active"><small>{{ __('time') }} </small>{{
            $customerBid->workerGig->day }}<small> {{ __('Hours') }}</small></button>
        <button id="job-cancel" type="button" class="btn btn-danger">{{ __('cancel') }}</button>
    </div>

    <div class="w-100 mb-2 text-center">
        <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('অর্ডারটি শুরু
                করার সম্ভাব্য তারিখ ও সময় ') }}{{ date('h:i a', strtotime($customerBid->time)) }}, {{ date('d F Y',
                strtotime($customerBid->date)) }} </small></button>
    </div>
</div>
<!--End work detail , address, day-->
<hr>
<!-- End Bids -->
@elseif($customerBid->status == 'running')
<!-- Start title -->
<div class="">
    <div class="alert alert-success row" role="alert">
        <div class="col-1">
            <a href="{{ route('customer.myJob') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                    class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                </svg>
            </a>
        </div>
        <div class="col text-center">
            <b id=""> {{ __('Running') }}</b>
        </div>
        <div class="col-1"></div>
    </div>
</div>
<!-- End title -->
<!-- Start active Bids -->
<div class="container">
    <div class="row">
        <div class="col-12 px-0">
            <div class="list-group list-group-flush ">
                <div class="list-group-item border-top text-dark">
                    <!-- worker profile -->
                    <div class="row">
                        <div class="col-auto align-self-center text-center">
                            <i class="material-icons text-template-primary">
                                <figure class="avatar avatar-60 border-0">
                                    <img src="{{ asset($customerBid->workerGig->worker->image ?? 'uploads/images/defaults/user.png') }}"
                                        alt="">
                                </figure>
                            </i>
                        </div>
                        <div class="col pl-0">
                            <div class="row mb-1">
                                <div class="col">
                                    <p class="mb-0">{{ $customerBid->workerGig->worker->full_name }}</p>
                                    <p class="small text-mute text-trucated mt-1">
                                        <i class="material-icons btn-outline-warning small">star</i>
                                        @php
                                        $percent = 100 - (($customerBid->workerGig->worker->rating->max_rate -
                                        $customerBid->workerGig->worker->rating->rate)/$customerBid->workerGig->worker->rating->max_rate)*100;
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
                                        {{ $star }} ({{ $customerBid->workerGig->worker->rating->max_rate -
                                        $customerBid->workerGig->worker->rating->rate }})
                                    </p>
                                </div>
                                <div class="col-auto pl-0 pt-4">
                                    <a href="{{ $customerBid->workerGig->worker->location }}" target="_blank"
                                        class="text-warning p-4"> <i class="fa fa-map-marker"></i> Location</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col p-2">
                            <div class="input-group">
                                <input type="text" class="form-control" id="phone" placeholder="phone" readonly
                                    value="{{ $customerBid->workerGig->worker->phone }}">
                                <div class="input-group-prepend">
                                    <a href="tel:{{ $customerBid->workerGig->worker->phone }}">
                                        <span class="input-group-text bg-success text-white dz-clickable" onclick=""
                                            id="phone">{{ __('Call') }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class=" row p-4">
                                <div class="col-6">
                                    Order #AO{{ $customerBid->id }}
                                </div>
                                <div class="col-6 text-right">
                                    {{ $customerBid->budget }} ৳
                                </div>

                            </div>
                            <div class=" row p-4">
                                <div class="col-6">
                                    Worker #{{ $customerBid->worker->name ?? '' }}
                                </div>
                                <div class="col-6 text-right">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="phone" placeholder="phone" readonly
                                            value="{{ $customerBid->worker->phone ?? '' }}">
                                        <div class="input-group-prepend">
                                            <a href="tel:{{ $customerBid->worker->phone ?? '' }}">
                                                <span class="input-group-text bg-success text-white dz-clickable"
                                                    onclick="" id="phone">{{ __('Call')
                                                    }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="">
                        <div class=" text-center" role="alert">
                            <div class="row">
                                <div class="container">
                                    <div class="row container">
                                        {{ __('প্রয়োজন অনুযায়ী প্রাইস পরিবর্তন করুন') }}
                                        <hr>
                                    </div>
                                    <div class="row P-2">
                                        <div class="col-lg-10 col-12">
                                            <div class="form-group mb-2 ">
                                                <input type="number" id="budget" placeholder="250"
                                                    class="form-control form-control-lg text-center">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-12 text-center">
                                            <input type="hidden" id="bid-id" value="{{ $customerBid->id }}">

                                            <button type="button"
                                                data-worker-limit="{{ App\User::worker_bid_gig_limit($customerBid->workerGig->worker_id) }}"
                                                class="btn btn-success mb-2" id="update_budget"><b>{{ __('SUBMIT')
                                                    }}</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- new budget -->
                    {{-- <div class="">
                        <div class="alert alert-danger text-center" role="alert">
                            <div class="d-flex align-items-center pt-2 pb-2">
                                <strong>Order Id: </strong>
                                <div>#{{ $customerBid->id }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <h3 class="mb-0 font-weight-normal text-left">{{ __('price') }} ৳ </h3>
                                </div>
                                <div class="col-auto">
                                    <button disabled class="btn btn-info btn-rounded-54 shadow"> <b>{{
                                            $customerBid->budget }}</b> </button>
                                </div>
                            </div>
                            <div class="alert alert-info text-center">{{ __('Change Your Order Price') }}</div>
                            <div class="row">
                                @if ($customerBid->proposed_budget )
                                <div class="col-auto">
                                    <div class="alert alert-success text-center">Proposed Budget <strong>{{
                                            $customerBid->proposed_budget }}/-</strong> is Pending For Your Approval.
                                    </div>
                                    <div class="btn-group d-flex flex-wrap">
                                        <input type="hidden" id="proposed_budget"
                                            value="{{ $customerBid->proposed_budget }}">
                                        <button class="btn btn-lg btn-success" id="accept_budget"
                                            style="border-radius: 5px !important;">Accept</button>
                                        <button class="btn btn-lg btn-danger" id="cancel_budget"
                                            style="border-radius: 5px !important;">cancel</button>
                                    </div>
                                </div>
                                @endif
                                <div class="col text-center">
                                    <input type="hidden" id="bid-id" value="{{ $customerBid->id }}">
                                    <input type="number" id="budget" placeholder="250"
                                        class="form-control form-control-lg text-center">
                                    <button type="button" id="update-budget" class="mb-2 btn btn-lg btn-info mt-3"
                                        style="width: 100%">{{ __('submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <hr>
                    <div class="row">
                        @if ($customerBid->proposed_budget )
                        <div class="col-12 text-center">
                            <div class="alert alert-success text-center"><i
                                    class="fa fa-exclamation-circle text-danger"></i> সার্ভিস প্রোভাইডার অর্ডারটি {{
                                $customerBid->proposed_budget }} টাকায় করতে আগ্রহী। সম্মত থাকলে Accept করুন অথবা Reject
                                করুন।</div>
                            <div class="btn-group d-flex flex-wrap">
                                <input type="hidden" id="proposed_budget" value="{{ $customerBid->proposed_budget }}">
                                <button class="btn btn-lg btn-success mr-1" id="accept_budget"
                                    style="border-radius: 5px !important;">Accept</button>
                                <button class="btn btn-lg btn-danger ml-1" id="cancel_budget"
                                    style="border-radius: 5px !important;">cancel</button>
                            </div>
                        </div>
                        <hr>
                        @endif

                    </div>
                    <div>{!! $customerBid->workerGig->title !!}</div>
                    <hr>
                    <!-- work detail -->
                    <b>{!! $customerBid->workerGig->description !!}</b>
                    <hr>
                    <b>{{ __('Details:') }}</b>
                    <div>{!! $customerBid->description !!}</div>
                    <br>
                    <b>{{ __('Address:') }}</b>
                    <p>{{ $customerBid->address }}</p>
                    <br>
                    <b>{{ __('Image:') }}</b>

                    <div class="custom-file mb-2">

                        <input type="file" accept="image/*" class="custom-file-input" @if($customerBid->image) disabled
                        readonly @endif id="image" required="">
                        <label class="custom-file-label" for="image">@if($customerBid->image) {{ __('Already uploaded')
                            }} @else {{ __('Chose file') }} @endif</label>

                    </div>
                    @if($customerBid->image)
                    <img id="myImg" src="{{ asset($customerBid->image) }}" class="text-center p-2"
                        style="width: 100%; max-height: 2000px; ">
                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                        <img class="modal-content" id="img01">
                        <div id="caption"></div>
                    </div>
                    <style type="text/css">
                        #myImg {

                            cursor: pointer;
                            transition: 0.3s;
                            display: block;
                            margin-left: auto;
                            margin-right: auto
                        }

                        #myImg:hover {
                            opacity: 0.7;
                        }

                        /* The Modal (background) */
                        .modal {
                            display: none;
                            /* Hidden by default */
                            position: fixed;
                            /* Stay in place */
                            z-index: 99;
                            /* Sit on top */
                            padding-top: 100px;
                            /* Location of the box */
                            left: 0;
                            top: 0;
                            width: 100%;
                            /* Full width */
                            height: 100%;
                            /* Full height */
                            overflow: auto;
                            /* Enable scroll if needed */
                            background-color: rgb(0, 0, 0);
                            /* Fallback color */
                            background-color: rgba(0, 0, 0, 0.9);
                            /* Black w/ opacity */
                        }

                        /* Modal Content (image) */
                        .modal-content {
                            margin: auto;
                            display: block;
                            width: auto;
                            //max-width: 75%;
                        }

                        /* Caption of Modal Image */
                        #caption {
                            margin: auto;
                            display: block;
                            width: 80%;
                            max-width: 700px;
                            text-align: center;
                            color: #ccc;
                            padding: 10px 0;
                            height: 150px;
                        }

                        @-webkit-keyframes zoom {
                            from {
                                -webkit-transform: scale(1)
                            }

                            to {
                                -webkit-transform: scale(2)
                            }
                        }

                        @keyframes zoom {
                            from {
                                transform: scale(0.4)
                            }

                            to {
                                transform: scale(1)
                            }
                        }

                        @-webkit-keyframes zoom-out {
                            from {
                                transform: scale(1)
                            }

                            to {
                                transform: scale(0)
                            }
                        }

                        @keyframes zoom-out {
                            from {
                                transform: scale(1)
                            }

                            to {
                                transform: scale(0)
                            }
                        }

                        /* Add Animation */
                        .modal-content,
                        #caption {
                            -webkit-animation-name: zoom;
                            -webkit-animation-duration: 0.6s;
                            animation-name: zoom;
                            animation-duration: 0.6s;
                        }

                        .out {
                            animation-name: zoom-out;
                            animation-duration: 0.6s;
                        }

                        /* 100% Image Width on Smaller Screens */
                        @media only screen and (max-width: 700px) {
                            .modal-content {
                                width: 100%;
                            }
                        }
                    </style>
                    @endif
                    <hr>
                    <div class="alert text-mute text-justify" style="text-align-last: center;">অর্ডার ডেলিভারি টাইম {{
                        $customerBid->workerGig->day }} {{ __('ঘন্টা') }}</div>
                    <hr>
                    <div class="w-100 mb-2 text-center">
                        <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{
                                __('অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ') }} {{ date('h:i a',
                                strtotime($customerBid->time)) }}, {{ date('d F Y', strtotime($customerBid->date)) }}
                            </small></button>
                    </div>
                    {{-- <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                            <div class="single_counter text-center">
                                <h4 id="days">00</h4>
                                <span>Days</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                            <div class="single_counter text-center">
                                <h4 id="hours">00</h4>
                                <span>Hours</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                            <div class="single_counter text-center">
                                <h4 id="minutes">00</h4>
                                <span>Minutes</span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                            <div class="single_counter text-center">
                                <h4 id="seconds">00</h4>
                                <span>Seconds</span>
                            </div>
                        </div>
                    </div> --}}
                    <hr>
                    <div class="">
                        <div class=" text-center" role="alert">
                            <div class="row">
                                <div class="container">
                                    <div class="row container">
                                        {{ __('Worker এর মোবাইলে ৪ ডিজিট এর একটি ওটিপি কোড সেন্ড করা হইছে , ঐ ওটিপি কোড
                                        নিম্নে বসিয়ে Worker Verify করুন।') }}
                                        <hr>
                                    </div>
                                    <div class="row P-2">
                                        <div class="col-lg-8 col-12">

                                            <div class="form-group mb-2 ">
                                                <input type="number" id="otp" placeholder="7250"
                                                    class="form-control form-control-lg text-center">
                                                <input type="hidden" id="bid-id-otp" value="{{ $customerBid->id }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <p class="text-success" style="display:none;" id="success_otp">OTP Verified
                                            </p>
                                            <p class="text-danger" style="display:none;" id="wrong_otp">Wrong OTP</p>
                                        </div>
                                        {{-- <div class="col-lg-2 col-12 text-center">


                                            <button type="button"
                                                data-worker-limit="{{ App\User::worker_bid_gig_limit($customerBid->workerGig->worker_id) }}"
                                                class="btn btn-success mb-2" id="update_budget"><b>{{ __('SUBMIT')
                                                    }}</b></button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-center">
                            <button onclick="complainNow({{ $customerBid->id }});" type="button"
                                class="mb-2 w-100 btn btn-lg btn-danger">{{ __('Complain') }}</button>
                        </div>
                        <div class="col-6 text-center">
                            <button type="button" class="mb-2 w-100 btn btn-lg btn-success mb-2"
                                id="completed-btn"><b>{{ __('Completed') }}</b></button>
                        </div>
                    </div>
                </div>
                {{-- <div class="row text-center">
                    <div class="col-6">
                        <h4><b>{{ $customerBid->workerGig->day }} <br> <small> {{ __('Day') }}</small></b></h4>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-success mb-2" id="completed-btn"><b>{{ __('Rate and
                                Complete') }}</b></button>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <button onclick="complainNow({{ $customerBid->workerGig->id }});" type="button"
                        class="mb-2 w-100 btn btn-lg btn-danger">{{ __('Complain') }}</button>
                </div> --}}

            </div>
        </div>
    </div>
</div>
</div>
<!-- End Active Bids -->
<!-- End running Bids -->

@elseif($customerBid->status == 'completed')
<!-- Start title -->
<div class="">
    <div class="alert alert-success row" role="alert">
        <div class="col-1">
            <a href="{{ route('customer.myJob') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                    class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                </svg>
            </a>
        </div>
        <div class="col text-center">
            <b id=""> {{ __('Completed') }}</b>
        </div>
        <div class="col-1"></div>
    </div>
</div>
<!-- End title -->
<!-- Start Completed Bids -->
<div class="container">
    <div class="row">
        <div class="col-12 px-0">
            <div class="list-group list-group-flush ">
                <div class="list-group-item border-top text-dark">
                    <!-- worker profile -->
                    <div class="row">
                        <div class="col-auto align-self-center text-center">
                            <i class="material-icons text-template-primary">
                                <figure class="avatar avatar-60 border-0">
                                    <img src="{{ asset($customerBid->workerGig->worker->image ?? 'uploads/images/defaults/user.png') }}"
                                        alt="">
                                </figure>
                            </i>
                        </div>
                        <div class="col pl-0">
                            <div class="row mb-1">
                                <div class="col">
                                    <p class="mb-0">{{ $customerBid->workerGig->worker->full_name }}</p>
                                </div>
                                <div class="col-auto pl-0">
                                    <p class="small text-mute text-trucated mt-1">
                                        @php
                                        $percent = 100 - (($customerBid->workerGig->worker->rating->max_rate -
                                        $customerBid->workerGig->worker->rating->rate)/$customerBid->workerGig->worker->rating->max_rate)*100;
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

                                        <i class="material-icons btn-outline-warning small">star</i>
                                        {{ $star }} ({{getWorkerRatting($customerBid->workerGig->worker->id)}})
                                    </p>
                                </div>
                            </div>

                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="budget" readonly
                                    value="Order price">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white">
                                        {{ $customerBid->budget }} ৳
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- work detail -->
                    <div class=" row p-4">
                        <div class="col-12">
                            <b>Order #AO{{ $customerBid->id }}</b> <br>
                            {!! $customerBid->workerGig->description !!}
                        </div>
                    </div>
                    <hr>
                    <b>{{ __('Details:') }}</b>
                    <div>{!! $customerBid->description !!}</div>
                    <br>
                    <b>{{ __('Address:') }}</b>
                    <p>{{ $customerBid->address }}</p>
                    <br>
                    <hr>
                    <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group"
                        aria-label="Basic example">
                        <button disabled type="button" class="btn btn-outline-success active">
                            <b>{{ __('Delivery date') }}</b> <br>
                            <small>
                                {{ date('h:i:s a d/m/y', strtotime($customerBid->updated_at)) }}
                            </small>
                        </button>
                    </div>

                    <div class="w-100 mb-2 text-center">
                        <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{
                                __('অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ছিল ') }} {{ date('h:i a',
                                strtotime($customerBid->time)) }}, {{ date('d F Y', strtotime($customerBid->date)) }}
                            </small></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4"></div>
        <div class="col-4 text-center">
            <input type="hidden" id="bid-id" value="{{ $customerBid->id }}">
            @if(count(App\RattingReview::where('porpuse_id', $customerBid->worker_gig_id)->where('purpose',
            'Bid')->get()) > 0)
            <button type="button" class="mb-2 w-100 btn btn-lg btn-success mb-2" disabled=""><b>{{ __('Give Review')
                    }}</b></button>
            @else
            <button type="button" class="mb-2 w-100 btn btn-lg btn-success mb-2" id="completed-btn"><b>{{ __('Give
                    Review') }}</b></button>
            @endif
        </div>
    </div>
</div>

</div>
<!-- End Completed Bids -->
<!-- End Completed Bids -->
@elseif($customerBid->status == 'cancelled')
<!-- Start title -->
<div class="">
    <div class="alert alert-danger row" role="alert">
        <div class="col-1">
            <a href="{{ route('customer.myJob') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                    class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                </svg>
            </a>
        </div>
        <div class="col text-center">
            <b id="">{{ __('Cancelled') }}</b>
        </div>
        <div class="col-1"></div>
    </div>
</div>
<!-- End title -->
<!--Start owner info & price-->
<div class="container">
    <div class="card bg-danger shadow mt-4 h-190">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                    <figure class="avatar avatar-60"><img
                            src="{{ asset($customerBid->customer->image ?? 'uploads/images/defaults/user.png') }}"
                            alt=""></figure>
                </div>
                <div class="col pl-0 align-self-center">
                    <h5 class="mb-1">{{ $customerBid->customer->full_name }}</h5>
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
                    <h3 class="mb-0 font-weight-normal">{{ __('Price') }} ৳ </h3>
                </div>
                <div class="col-auto">
                    <button disabled class="btn btn-danger btn-rounded-54 shadow" data-toggle="modal"
                        data-target="#addmoney"> <b>{{ $customerBid->budget }}</b> </button>
                </div>
            </div>
        </div>
        <div class="card-footer bg-none">
            <div class="row">
                <div class="col">
                    <p><b>{{ $customerBid->workerGig->title }}</b></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End owner info & price-->
<!--Start work detail , address, day-->
<div class="container">
    <div class=" row p-4">
        <div class="col-12">
            <b>Order #AO{{ $customerBid->id }}</b> <br>
        </div>
    </div>
    <h4 class="mb-3"><b>{{ __('Details') }}:</b></h4>
    <div>{!! $customerBid->description !!}</div>
    <h4 class="mb-3"><b>{{ __('Address') }}:</b></h4>
    <p>{{ $customerBid->address }}</p>
    <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
        <button disabled type="button" class="btn btn-outline-danger active">
            <b>{{ __('Cancelled Date') }}</b> <br>
            <small>
                {{ date('h:i:s a d/m/y', strtotime($customerBid->updated_at)) }}
            </small>
        </button>
    </div>

    <div class="w-100 mb-2 text-center">
        <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('অর্ডারটি শুরু
                করার সম্ভাব্য তারিখ ও সময় ছিল ') }} {{ date('h:i a', strtotime($customerBid->time)) }}, {{ date('d F Y',
                strtotime($customerBid->date)) }} </small></button>
    </div>
</div>
<!--End work detail , address, day-->
<hr>
<hr>
@endif

<script>
    // Get the modal
        var modal = document.getElementById('myModal');
         
        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById('myImg');
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            modalImg.alt = this.alt;
            captionText.innerHTML = this.alt;
        }
         
         
        // When the user clicks on <span> (x), close the modal
        modal.onclick = function() {
            img01.className += " out";
            setTimeout(function() {
               modal.style.display = "none";
               img01.className = "modal-content";
             }, 400);
            
         }    
            
</script>
<!-- footer-->
<script>
    function complainNow(gig_id){
            Swal.fire({
                title: ' Write Complain ',
                input: 'textarea',
                inputAttributes: {
                    autocapitalize: 'off',
                },
                inputPlaceholder: "{{ __('Write details of job and worker information for proper complain ... ') }}",
                showCancelButton: true,
                confirmButtonText: 'Complain',
                showLoaderOnConfirm: true,
                preConfirm: (complain) => {
                    var formData = new FormData();
                    formData.append('bid', gig_id)
                    formData.append('complain', complain)
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('customer.completedCustomerBidJobAndComplain') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function (){
                            $(this).prop("disabled",true);
                        },
                        complete: function (){
                            $(this).prop("disabled",false);
                        },
                        success: function (data) {
                            if (data.type == 'success'){
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 800);//
                            }else{
                                Swal.fire({
                                    icon: data.type,
                                    title: 'Oops...',
                                    text: data.message,
                                    footer: 'Something went wrong!'
                                });
                            }
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
                            });
                        },
                    });
                },
            })
        }
        $(document).ready(function(){
            
            //Otp Verification Process
            $("#otp").keyup(function(){
                //console.log("Okay");
                var otp = $("#otp").val();
                var bid_id = $("#bid-id-otp").val();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.otpCheck') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        bid_id : bid_id,
                        otp : otp,
                    },
                    success: function (data) {
                        //console.log(data);
                        if(data.type === 'success'){
                            $("#success_otp").css('display','block');
                            $("#wrong_otp").css('display','none');
                        }else{
                            $("#success_otp").css('display','none');
                            $("#wrong_otp").css('display','block');
                        }
                        //$("#success_otp").css('display','block');
                    },
                    error: function (xhr) {
                        console.log(xhr.responseJSON.errors);
                    },
                })
            });
            
            
            
            //Update Budget with confirm alert
            $("#update_budget").click(function (){
                var worker_limit = Number($(this).attr('data-worker-limit'));
                var budget = Number($('#budget').val());
                if(budget > worker_limit) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Low Balance',
                        footer: 'অর্ডার প্রাইস বৃদ্ধি করতে সার্ভিস প্রোভাইডার বা ওয়ার্কারকে তার ব্যালেন্স বৃদ্ধি করতে বলুন।'
                    })
                }else{
                    Swal.fire({
                        title: 'Price update ?',
                        text: "",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, update now!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var formData = new FormData();
                            formData.append('bid', $('#bid-id').val())
                            formData.append('budget', $('#budget').val())
                            $.ajax({
                                method: 'POST',
                                url: "{{ route('customer.updateCustomerBidBudget') }}",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: data.type,
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    setTimeout(function() {
                                        location.reload()
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
                        }
                    })
                }
            });

            $("#accept_budget").click(function (){
                Swal.fire({
                    title: 'Accept Proposed Budget?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Accept!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('bid', $('#bid-id').val())
                        formData.append('budget', $('#proposed_budget').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.acceptGigBidBudget') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload()
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
                    }
                })
            });

            $("#cancel_budget").click(function (){
                Swal.fire({
                    title: 'Cancel Proposed Budget?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('bid', $('#bid-id').val())
                        formData.append('budget', $('#proposed_budget').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelGigBidBudget') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload()
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
                    }
                })
            });

            //Job Cancel with confirm alert
            $("#job-cancel").click(function (){
                Swal.fire({
                    title: 'Cancel this bid ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('bid', $('#bid-id').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelCustomerBid') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: data.type,
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function() {
                                    location.reload()
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
                    }
                })
            });

            //Job image upload
            $('#image').change(function(){
                var formData = new FormData();
                formData.append('bid', $('#bid-id').val())
                formData.append('image', $('#image')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.imageUploadToCustomerBid') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: data.type,
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            //your code to be executed after 1 second
                            location.reload();
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

            //Complete and rating
            $('#completed-btn').click(function (){
                $('#complete-modal').modal('show');
            });

            //Rating and completed submit
            $('#completed-submit').click(function (){
            $("#completed-submit").prop("disabled", true);
                var formData = new FormData();
                formData.append('rate', $('.rating-btn:checked').val())
                formData.append('bid', $('#bid-id').val())
                formData.append('complete_review', $('#complete_review').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.completedCustomerBidJobAndRating') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#completed-submit").prop("disabled", false);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            // timer: 1500
                        })
                        setTimeout(function() {
                            //your code to be executed after 1 second
                            location.reload();
                        }, 1000); //1 second
                    }
                });
            });
        });
</script>

<script>
    @if($customerBid->status == 'active')
            @php 
                $deadline = get_static_option('worker_job_request_accept_hour');
                $date = $customerBid->created_at;
                $ending_at = Carbon\Carbon::parse($date);
                $ending_at->addHours($deadline);
                $current_timestamp = Carbon\Carbon::now()->toDateTimeString();
            @endphp
            if ("{{ $ending_at }}" < "{{ $current_timestamp }}") {
                var formData = new FormData();
                formData.append('bid', $('#bid-id').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.cancelCustomerBid') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        setTimeout(function() {
                            location.reload()
                        });
                    },
                })
            }

            const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;

            let countDown = new Date("{{ $ending_at }}").getTime(),
                x = setInterval(function () {

                    let now = new Date().getTime(),
                        distance = countDown - now;

                    document.getElementById('days').innerText = Math.floor(distance / (day)),
                    document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
                    document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
                    document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

                    if (countDown <= now) {
                        var formData = new FormData();
                        formData.append('bid', $('#bid-id').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelCustomerBid') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                setTimeout(function() {
                                    location.reload()
                                });
                            },
                        })
                    }

                }, second)
        @endif


        @if($customerBid->status == 'running') //$customerBid->completed_at
            @php
            // $deadline = $customerBid->workerGig->day;
            // $date = $customerBid->updated_at;
            // $ending_at = Carbon\Carbon::parse($date);
            // $ending_at->addHours($deadline);
            @endphp

            // const second = 1000,
            // minute = second * 60,
            // hour = minute * 60,
            // day = hour * 24;

            // let countDown = new Date(" $ending_at ").getTime(); 
            //$customerBid->completed_at
            

            //     x = setInterval(function () {

            //         let now = new Date().getTime(),
            //         distance = countDown - now;
                   

            //         document.getElementById('days').innerText = Math.floor(distance / (day)),
            //         document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
            //         document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
            //         document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

            //         if (countDown <= now) {
            //             // alert("ok");
            //         }
            //     }, second)
        @endif
</script>
@endsection