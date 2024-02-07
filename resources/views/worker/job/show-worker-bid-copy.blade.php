@extends('worker.layout.app')
@push('title') {{ __('Order') }} @endpush
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
@endpush
@section('content')

    <!--Start active job detail view -->
    @if($customerGig->status == 'active' && $customerGig->workerBids->where('worker_id', auth()->user()->id)->first()->is_cancelled == 0)
        <!-- Start title -->
        <div class="">
            <div class="alert alert-success row" role="alert">
                <div class="col-1">
                    <a href="{{ route('worker.job.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </a>
                </div>
                <div class="col text-center">
                    <b id=""> {{ __('Pending BID ORDER') }}</b>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
        <!-- End title -->
            <!--Start owner info & price-->
            <div class="container">
                <div class="card bg-info shadow mt-4 h-190">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <figure class="avatar avatar-60"><img src="{{ asset($customerGig->customer->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                                </div>
                                <div class="col pl-0 align-self-center">
                                    <h5 class="mb-1">{{ $customerGig->customer->full_name }}</h5>
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
                                    <button disabled class="btn btn-info btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b>{{ $customerGig->budget }}</b> </button>
                                </div>
                            </div>
                        </div>
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
            <div class="container">
                <h4 class="mb-3"><b>{{ __('Work details:') }}</b></h4>
                <div>{!! $customerGig->description !!}</div>
                <h4 class="mb-3"><b>{{ __('Address:') }}</b></h4>
                <p>{{ $customerGig->address }}</p>
                <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                    <button disabled type="button" class="btn btn-outline-success active col"><small>{{ __('Time') }}  </small>{{ $customerGig->day }}<small> {{ __('Hours') }}</small></button>
                    <button disabled type="button" class="btn btn-success col">{{  date('h:i a d/m/y', strtotime($customerGig->created_at)) }}</button>
                </div>
                <div class="w-100 mb-2 text-center" >
                    <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়') }} {{  date('h:i a', strtotime($customerGig->time)) }}, {{  date('d F Y', strtotime($customerGig->date)) }} । {{ __('যথাসময়ে সার্ভিস শুরু করার চেষ্টা করবেন। অথবা কাস্টমারের সাথে কথা বলে নিবেন। ') }}</small></button>
                </div>
            </div>
            <!--End work detail , address, day-->
                <hr>
            <!-- Start bid title -->
            <div class="">
                <div class="alert alert-info text-center" role="alert">
                    <b id=""> {{ __('MY BIDS') }}</b>
                </div>
            </div>
            <!-- End title -->
            <!--Start worker info & price-->
            <div class="container">
                <div class="card bg-warning shadow mt-4 h-190">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-60"><img src="{{ asset(auth()->user()->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                            </div>
                            <div class="col pl-0 align-self-center">
                                <h5 class="mb-1">{{ $customerGig->workerBids->where('worker_id', auth()->user()->id)->first()->worker->full_name }}</h5>
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
                                <h3 class="mb-0 font-weight-normal">{{ __('Price ৳') }} </h3>
                            </div>
                            <div class="col-auto">
                                <button disabled class="btn btn-warning btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b>{{ $customerGig->workerBids->where('worker_id', auth()->user()->id)->first()->budget }}</b> </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-none">
                        <div class="row">
                            <div class="col">
                                <div>{!! $customerGig->workerBids->where('worker_id', auth()->user()->id)->first()->description !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-none">
                        <div class="row">
                            <div class="col text-center">
                                <button type="button" id="canceller-btn" value="{{ $customerGig->workerBids->where('worker_id', auth()->user()->id)->first()->id }}" class="mb-2 btn btn-outline-danger btn-rounded">{{ __('Cancel this bid') }}</button>
                            </div>
                        </div>
                    </div>

                </div>

                <hr>
                <div class="alert text-mute text-justify" style="text-align-last: center;"> আপনার বিডটিতে অর্ডার Confirm করলে অর্ডারটি রানিং হবে, অন্যথায় অফারটি Auto Cancel হয়ে যাবে।</div>
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

            </div>
            <!--End worker info & price-->

            <!-- End title -->
        @foreach($customerGig->workerBids->where('worker_id', '!=', auth()->user()->id)->where('is_cancelled', 0) as $bid)
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
        @endforeach

    @elseif($customerGig->status == 'running' && $customerGig->workerBids->where('is_selected', '1')->where('worker_id', auth()->user()->id)->first())
        <!-- Start title -->
            <div class="">
                <div class="alert alert-info row" role="alert">
                    <div class="col-1">
                        <a href="{{ route('worker.job.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col text-center">
                        <b id="">{{ __(' RUNNING ORDER') }}</b>
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
                            @foreach($customerGig->workerBids->where('is_selected', '1')->where('worker_id', auth()->user()->id) as $bid)
                                <div class="list-group-item border-top text-dark">
                                    <!-- worker profile -->
                                    <div class="row">
                                        <div class="col-auto align-self-center text-center">
                                            <i class="material-icons text-template-primary">
                                                <figure class="avatar avatar-60 border-0">
                                                    <img src="{{ asset($bid->customerGig->customer->image ?? 'uploads/images/defaults/user.png') }}" alt="">
                                                </figure>
                                            </i>
                                        </div>
                                        <div class="col pl-0">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <p class="mb-0">{{ $bid->customerGig->customer->full_name }}</p>
                                                </div>
                                                <div class="col-auto pl-0">
                                                    <p class="small text-mute text-trucated mt-1">
                                                        @php
                                                            $percent = 100 - (($bid->customerGig->customer->rating->max_rate - $bid->customerGig->customer->rating->rate)/$bid->customerGig->customer->rating->max_rate)*100;
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
                                                        @for($starCounter = 1; $starCounter <= $star; $starCounter++)
                                                            <i class="material-icons btn-outline-warning small">star</i>
                                                        @endfor
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
										<div class="col-auto pl-0 pt-4">
											<a href="{{ $customerGig->customer->location }}" target="_blank" class="text-warning p-4"> <i class="fa fa-map-marker"></i> Location</a>
										</div>
                                    </div>
                                    <hr>
									<div class="row">
										<div class="col">
											<div class="input-group">
                                                <input type="text" class="form-control" id="phone" placeholder="phone" readonly value="{{ $bid->customerGig->customer->phone }}">
                                                <div class="input-group-prepend">
                                                    <a href="tel:{{ $bid->customerGig->customer->phone }}">
                                                        <span class="input-group-text bg-success text-white dz-clickable" onclick="" id="phone">{{ __('Call') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <br>

											<div class=" row p-4">
                                                <div class="col-6">
                                                    Order #AO{{ $bid->id }}
                                                </div>
                                                <div class="col-6 text-right">
                                                    {{ $bid->budget }} ৳
                                                </div>

                                            </div>

										</div>
									</div>
                                    <!-- new budget -->
                                    <div class="">
                                        <div class="alert alert text-center" role="alert">
                                            <div class="row">
												<div class="container">
                                                    <div class="row container">
															{{ __('প্রয়োজন অনুযায়ী প্রাইস পরিবর্তন করুন') }}
                                                        <hr>
                                                    </div>
                                                    <div class="row P-2">
                                                        <div class="col-lg-10 col-12">
                                                           <div class="form-group mb-2 ">
                                                                <input type="number" class="form-control text-center" id="budget" placeholder="550">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-12 text-center">
                                                            <input type="hidden" id="bid-id" value="{{ $bid->id }}">

                                                            @if($bid->budget <= App\User::worker_bid_gig_limit(auth()->user()->id))
                                                                <button type="button" id="update-budget" class="btn btn-success mb-2" style="width: 100%">{{ __('Submit') }}</button>
                                                            @else
                                                                <button type="button" class="btn btn-success mb-2" style="width: 100%" data-toggle="modal" data-target="#rechargeModal">
                                                                <b>{{ __('Submit') }}</b>
                                                                </button>
                                                            @endif


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<hr>
									<div class="row">
                                        @if ($bid->proposed_budget)
                                        <div class="col-auto">
                                            <div class="alert alert-success text-center"> <i class="fa fa-exclamation-circle text-danger"></i>  আপনার প্রত্যাশিত নতুন প্রাইস {{ $bid->proposed_budget }} টাকা Pending এ রয়েছে। কাস্টমার কর্তৃক Accept এর জন্য অপেক্ষা করুন।</div>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- work detail -->
                                    <div>{!! $bid->customerGig->title !!}</div>
                                    <hr>
                                    <b>{{ __('Details:') }}</b>
                                    <div>{!! $bid->customerGig->description !!}</div>
                                    <br>
                                    <b>{{ __('Address:') }}</b>
                                    <p>{{ $bid->customerGig->address }}</p>
                                    <br>
                                    <b>{{ __('Image:') }}</b><br>

                                    @if($bid->customerGig->image)
                                        <img id="myImg" src="{{ asset($bid->customerGig->image) }}" class="text-center p-2" style="width: 100%; max-height: 2000px; border-radius: 25px;">
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
                                            #myImg:hover {opacity: 0.7;}

                                            /* The Modal (background) */
                                            .modal {
                                                display: none; /* Hidden by default */
                                                position: fixed; /* Stay in place */
                                                z-index: 99; /* Sit on top */
                                                padding-top: 100px; /* Location of the box */
                                                left: 0;
                                                top: 0;
                                                width: 100%; /* Full width */
                                                height: 100%; /* Full height */
                                                overflow: auto; /* Enable scroll if needed */
                                                background-color: rgb(0,0,0); /* Fallback color */
                                                background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
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
                                                from {-webkit-transform:scale(1)}
                                                to {-webkit-transform:scale(2)}
                                            }

                                            @keyframes zoom {
                                                from {transform:scale(0.4)}
                                                to {transform:scale(1)}
                                            }

                                            @-webkit-keyframes zoom-out {
                                                from {transform:scale(1)}
                                                to {transform:scale(0)}
                                            }
                                            @keyframes zoom-out {
                                                from {transform:scale(1)}
                                                to {transform:scale(0)}
                                            }
                                            /* Add Animation */
                                            .modal-content, #caption {
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
                                            @media only screen and (max-width: 700px){
                                                .modal-content {
                                                    width: 100%;
                                                }
                                            }

                                        </style>
                                    @else
                                        <b>{{ __('Image not uploaded') }}</b>
                                    @endif
                                    <div class="w-100 mb-2 text-center" >
                                        <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময়') }} {{  date('h:i a', strtotime($customerGig->time)) }}, {{  date('d F Y', strtotime($customerGig->date)) }} । {{ __('যথাসময়ে সার্ভিস শুরু করার চেষ্টা করবেন। অথবা কাস্টমারের সাথে কথা বলে নিবেন। ') }}</small></button>
                                    </div>
                                    <hr>
                                    <div class="alert text-mute text-justify" style="text-align-last: center;">নির্দিষ্ট সময় {{ $bid->customerGig->day }} মধ্যে অর্ডার Complete করুন।</div>
                                    {{-- <hr>

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
                                    </div> --}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <button disabled type="button" class="btn btn-success w-100">{{  date('h:i a d/m/y', strtotime($customerGig->created_at)) }}</button>
                                        </div>
                                        <div class="col-6 text-center">
                                            {{-- <a href="{{ route('worker.completedCustomerGigJob', $bid->id) }}" class="btn btn-success w-100" ><b>{{ __('Complete') }}</b></a> --}}

                                            <button type="button" class="btn btn-success w-100 completed-btn" id="{{ $bid->id }}"><b>{{ __('Completed') }}</b></button>
                                            {{-- <a href="#" class="btn btn-success w-100" ><b>{{ __('Complete') }}</b></a> --}}
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Active Bids -->
            <!-- End running Bids -->
    @elseif($customerGig->status == 'completed' && $customerGig->workerBids->where('is_selected', '1')->where('worker_id', auth()->user()->id)->first())
        <!-- Start title -->
            <div class="">
                <div class="alert alert-success row" role="alert">
                    <div class="col-1">
                        <a href="{{ route('worker.job.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col text-center">
                        <b id=""> {{ __('COMPLETED ORDER') }}</b>
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
                            @foreach($customerGig->workerBids->where('is_selected', '1')->where('worker_id', auth()->user()->id) as $bid)
                                <div class="list-group-item border-top text-dark">
                                    <!-- worker profile -->
                                    <div class="row">
                                        <div class="col-auto align-self-center text-center">
                                            <i class="material-icons text-template-primary">
                                                <figure class="avatar avatar-60 border-0">
                                                    <img src="{{ asset($bid->customerGig->customer->image?? 'uploads/images/defaults/user.png') }}" alt="">
                                                </figure>
                                            </i>
                                        </div>
                                        <div class="col pl-0">
                                            <div class="row mb-1">
                                                <div class="col">
                                                    <p class="mb-0">{{ $bid->customerGig->customer->full_name }}</p>
                                                </div>
                                                <div class="col-auto pl-0">
                                                    <p class="small text-mute text-trucated mt-1">
                                                        @php
                                                            $percent = 100 - (($bid->customerGig->customer->rating->max_rate - $bid->customerGig->customer->rating->rate)/$bid->customerGig->customer->rating->max_rate)*100;
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
                                                            <i class="material-icons btn-outline-warning small">star</i>
                                                        @endfor
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="input-group">
                                                <input type="text" class="form-control" id="budget" placeholder="budget" readonly value="Order price">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white" id="budget">
                                                        {{ $bid->budget }} ৳
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- work detail -->
                                    <div>
                                        <div class=" row ">
                                            <div class="col-12">
                                                <b>Order #AO{{  $bid->id }} </b> <br>
                                                {!! $bid->description !!}</div>
                                            </div>
                                        </div>
                                    <hr>
                                    <b>{{ __('Details:') }}</b>
                                    <div>{!! $bid->customerGig->description !!}</div>
                                    <br>
                                    <b>{{ __('Address:') }}</b>
                                    <p>{{ $bid->customerGig->address }}</p>
                                    <br>
                                    <hr>
                                    <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                                        <button disabled type="button" class="btn btn-outline-success active">
                                            <b>{{ __('Delivery Date') }}</b> <br>
                                            <small>
                                                {{ date('h:i:s a d/m/y', strtotime($customerGig->updated_at)) }}
                                            </small>
                                        </button>
                                    </div>

                                    <div class="w-100 mb-2 text-center" >
                                        <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ছিল ') }} </small>{{  date('h:i a', strtotime($customerGig->time)) }}, {{  date('d F Y', strtotime($customerGig->date)) }} </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Completed Bids -->
            <!-- End Completed Bids -->
    @elseif($customerGig->status == 'cancelled' || $customerGig->workerBids->where('is_cancelled', '1')->where('worker_id', auth()->user()->id))
            <!-- Start title -->
            <div class="">
                <div class="alert alert-danger row" role="alert">
                    <div class="col-1">
                        <a href="{{ route('worker.job.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col text-center">
                        <b id=""> {{ __('CANCELLED ORDER') }}</b>
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
                                    <figure class="avatar avatar-60"><img src="{{ asset($customerGig->customer->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                                </div>
                                <div class="col pl-0 align-self-center">
                                    <h5 class="mb-1">{{ $customerGig->customer->full_name }}</h5>
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
                                    <button disabled class="btn btn-danger btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"> <b>{{ $customerGig->budget }}</b> </button>
                                </div>
                            </div>
                        </div>
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
                <div class="container">
                    <div class=" row ">
                        <div class="col-12">
                            <b>Order #AO{{  $customerGig->id }} </b> <br>
                        </div>
                    </div>
                    <h4 class="mb-3"><b>{{ __('Work detail:') }}</b></h4>
                    <div>{!! $customerGig->description !!}</div>
                    <h4 class="mb-3"><b>{{ __('Address:') }}</b></h4>
                    <p>{{ $customerGig->address }}</p>
                    <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                        <button disabled type="button" class="btn btn-outline-danger active">
                            <b>{{ __('Cancelled Date') }}</b> <br>
                            <small>
                                    {{ date('h:i:s a d/m/y', strtotime($customerGig->workerBids->where('worker_id', auth()->user()->id)->first()->updated_at)) }}
                            </small>
                        </button>
                    </div>

                    <div class="w-100 mb-2 text-center" >
                        <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ছিল ') }} </small>{{  date('h:i a', strtotime($customerGig->time)) }}, {{  date('d F Y', strtotime($customerGig->date)) }} </button>
                    </div>
                </div>
                <!--End work detail , address, day-->
                <hr>
    @endif
    <!-- footer-->
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
<script>
    $(document).ready(function() {
        //Cancel worker bid with confirm alert
        $('#canceller-btn').click(function(){
            $("#canceller-btn").prop("disabled", true);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData();
                    formData.append('bid', $(this).val())
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('worker.cancelWorkerBid') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $("#canceller-btn").prop("disabled", false);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Successfully bid cancelled.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                //your code to be executed after 1 second
                                location.reload()
                            }, 1000);//2 second
                        },
                        error: function (xhr) {
                            $("#canceller-btn").prop("disabled", false);
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

        //Price update by worker with confirm alert
        $("#update-budget").click(function (){
            $("#update-budget").prop("disabled", true);
            var balance = {{ App\User::worker_bid_gig_limit(auth()->user()->id) }}
            if(Number($('#budget').val()) <= Number(balance)) {
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
                        formData.append('price', $('#budget').val())
                        formData.append('bid', $('#bid-id').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('worker.changePriceForMoreWork') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $("#update-budget").prop("disabled", false);
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
                                $("#update-budget").prop("disabled", false);
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
            }else{
                $('#rechargeModalforBid').modal('show');
            }
        });


        $('#completed-btn').click(function (){
            $("#completed-btn").prop("disabled", true);
            $('.modal-backdrop').css("z-index", "0")
            $('#complete-modal').modal('show');
        });
        $('.completed-btn').click(function (){
            $(".completed-btn").prop("disabled", true);
            let id = $(this).attr('id');
            Swal.fire({
                title: 'Are You Sure?',
                showCancelButton: true,
                confirmButtonText: 'Complete',
                showLoaderOnConfirm: true,
                preConfirm: (review) => {
                    var formData = new FormData();
                    formData.append('bid', id)
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('worker.completedCustomerGigJob') }}",
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
                            $(".completed-btn").prop("disabled", false);
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
                            $(".completed-btn").prop("disabled", false);
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
        });

        //Rating and completed submit
        $('#completed-submit').click(function (){
            $("#completed-submit").prop("disabled", true);
            var formData = new FormData();
            formData.append('bid', $('#bid-id').val())
            formData.append('review', $('#complete_review').val())
            $.ajax({
                method: 'POST',
                url: "{{ route('worker.completedCustomerGigJob') }}",
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
                        timer: 1500
                    })
                    setTimeout(function () {
                        location.reload()
                    }, 1000); //1 second
                }
            });



        });

    });
</script>

<script>
    @php
        $deadline = get_static_option('worker_job_request_accept_hour');
        $date = $customerGig->created_at;
        $ending_at = Carbon\Carbon::parse($date);
        $ending_at->addHours($deadline);
        $current_timestamp = Carbon\Carbon::now()->toDateTimeString();
    @endphp

    @if($customerGig->status == 'active')
        if ("{{ $ending_at }}" < "{{ $current_timestamp }}") {

            // $("#job-cancel").click();

            var formData = new FormData();
            formData.append('bid', $('#canceller-btn').val())
            $.ajax({

                method: 'POST',
                url: "{{ route('worker.cancelWorkerBid') }}",
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
                    formData.append('bid', $('#canceller-btn').val())
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('worker.cancelWorkerBid') }}",
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

            }, 2000)
    @endif



    @if($customerGig->status == 'running' && $ending_at)
        @php
            // $deadline = $customerGig->day;
            // $date = $customerGig->updated_at;
            // $ending_at = Carbon\Carbon::parse($date);
            // $ending_at->addHours($deadline);
        @endphp
        // const second = 1000,
        // minute = second * 60,
        // hour = minute * 60,
        // day = hour * 24;

        // let countDown = new Date("{ $ending_at }}").getTime(),
        //     x = setInterval(function () {

        //         let now = new Date().getTime(),
        //             distance = countDown - now;

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
