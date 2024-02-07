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
        button{
            border-radius: 10px !important;
        }
    </style>
@endpush
@section('content')
        <!--Start active job detail view -->
    @if($serviceBid->status == 'active')
        <!-- Start title -->
            <div class="">
                <div class="alert alert-info row" role="alert">
                    <div class="col-1">
                        <button class="border-0 bg-transparent" onclick="window.location.href='{{ route('customer.myJob', session(['service_click' => TRUE, 'pending_service_click' => TRUE])) }}'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="col text-center">
                        <b id=""> {{ __('Pending Service Order') }}</b>
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
                                <figure class="avatar avatar-60"><img src="{{ asset($serviceBid->customer->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                            </div>
                            <div class="col pl-0">
                                <div class="row justify-content-between">
                                    <div class="col-12  align-self-center">
                                        <h5 class="mb-1" style="text-transform: capitalize">{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->name }}</h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="row small text-mute text-trucated mt-1 justify-content-between align-items-center">
                                            @php
                                                $sum = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->sum('rating');
                                                $count = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->count();
                                                if (App\ServiceReview::where('worker_id', $serviceBid->worker_id)->exists()) {
                                                    $total_review = $sum/$count;
                                                }else {
                                                    $total_review = 0;
                                                }

                                                if ($total_review>4.5)
                                                    $star = 5;
                                                else if ($total_review>3.5)
                                                    $star = 4;
                                                else if ($total_review>2.5)
                                                    $star = 3;
                                                else if ($total_review>1.5)
                                                    $star = 2;
                                                else if ($total_review>0.5)
                                                    $star = 1;
                                                else
                                                    $star = 0;
                                            @endphp
                                            <div class="col-auto d-flex justify-content-between">
                                                {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                                    <i class="material-icons btn-outline-warning">star</i>
                                                {{-- @endfor --}}
                                                <span class="text-right text-warning" style="font-size: 20px">{{ number_format((float)$total_review, 1, '.', '') }} ({{ $count }})</span>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->location }}" target="_blank"><i class="material-icons text-warning" style="font-size: 30px;">edit_location</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container top-100">
                <div class="card mb-4 shadow">
                    <div class="card-body border-bottom">
                        <div class="d-flex align-items-center pt-2 pb-2">
                            <strong>Order Id: </strong>
                            <div>#AO{{  $serviceBid->id }}</div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-0 font-weight-normal">{{ __('price') }} ৳ </h3>
                            </div>
                            <div class="col-auto">
                                <button disabled class="btn btn-info btn-rounded-54 shadow"> <b>{{ $serviceBid->budget }}</b> </button>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-footer bg-none">
                        <div class="row">
                            <div class="container">
                                <div class="row container">
                                        {{ __('প্রয়োজন অনুযায়ী প্রাইস পরিবর্তন করুন') }}
                                    <hr>
                                </div>
                                <div class="row P-2">
                                    <div class="col-lg-10 col-12">
                                       <div class="form-group mb-2 ">
                                            <input type="hidden" id="service-id" value="{{ $serviceBid->id }}">
                                            <input type="number" id="budget" placeholder="250" class="form-control form-control-lg text-center">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-12 text-center">
                                        <button type="button" id="update-budget" class=" btn btn-success ">{{ __('submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if ($serviceBid->proposed_budget )
                            <div class="col-12">
                                <div class="alert alert-success text-center">সার্ভিস প্রোভাইডার অর্ডারটি {{ $serviceBid->proposed_budget }} টাকায় করতে আগ্রহী। সম্মত থাকলে Accept করুন অথবা Reject করুন।</div>
                                <div class="btn-group d-flex flex-wrap">
                                    <input type="hidden" id="proposed_budget" value="{{ $serviceBid->proposed_budget }}">
                                    <button class="btn btn-lg btn-success mr-1" id="accept_budget" style="border-radius: 5px !important;">Accept</button>
                                    <button class="btn btn-lg btn-danger ml-1" id="cancel_budget" style="border-radius: 5px !important;">cancel</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div> --}}
                </div>
            </div>
            <!--End owner info & price-->

            <!--Start work detail , address, day-->
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <p class="" style="text-transform: capitalize"><b>{{ App\PageService::withTrashed()->find($serviceBid->worker_service_id)->title }}</b></p>
                    </div>
                    <div class="col-auto">
                        @php
                            $sum = App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->sum('rating');
                            $count = App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->count();
                            if (App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->exists()) {
                                $total_review = $sum/$count;
                            }else {
                                $total_review = 0;
                            }

                            if ($total_review>4.5)
                                $star = 5;
                            else if ($total_review>3.5)
                                $star = 4;
                            else if ($total_review>2.5)
                                $star = 3;
                            else if ($total_review>1.5)
                                $star = 2;
                            else if ($total_review>0.5)
                                $star = 1;
                            else
                                $star = 0;
                        @endphp
                        <div class="d-flex align-items-center">
                            {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                <i class="material-icons btn-outline-warning btn-sm p-0">star</i>
                            {{-- @endfor --}}
                            <span class="text-right text-warning" style="font-size: 15px"> {{ number_format((float)$total_review, 1, '.', '') }} ({{ $count }})</span>
                        </div>
                    </div>
                </div>
                <br>
                <h4 class="mb-3"><b>{{ __('Order details:') }}</b></h4>
                <div class="mb-2">{!! $serviceBid->description !!}</div>
                <h4 class="mb-3"><b>{{ __('Address:') }}</b></h4>
                <p>{{ $serviceBid->address }}</p>
                <hr>
                <div class="alert text-mute text-justify" style="text-align-last: center;">নির্দিষ্ট সময়ের মধ্যে সার্ভিস প্রোভাইডার /ওয়ার্কার কর্তৃক অর্ডারটি Confirm হওয়ার জন্য একটু অপেক্ষা করুন। নির্দিষ্ট সময়ের মধ্যে অর্ডার Confirm না করলে অর্ডারটি Auto Cancel হয়ে যাবে। সেক্ষেত্রে অন্য সার্ভিস প্রোভাইডার /ওয়ার্কারকে পুনরায় অর্ডার করতে পারবেন।</div>
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
                    <button disabled type="button" class="btn btn-outline-success active mr-1"><small>{{ __('time') }} </small>: {{ App\PageService::withTrashed()->find($serviceBid->worker_service_id)->day }}<small> {{ __('Hours') }}</small></button>
                    <button id="job-cancel" type="button" class="btn btn-danger ml-1">{{ __('cancel') }}</button>
                </div>

                <div class="w-100 mb-2 text-center">
                    <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __(' অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ') }} {{  date('h:i a', strtotime($serviceBid->time)) }}, {{  date('d F Y', strtotime($serviceBid->date)) }} </small></button>
                </div>
            </div>
            <!--End work detail , address, day-->
            <hr>
            <!-- End Bids -->
    @elseif($serviceBid->status == 'running')
        <!-- Start title -->
            <div class="">
                <div class="alert alert-success row" role="alert">
                    <div class="col-1">
                        <button class="border-0 bg-transparent" onclick="window.location.href='{{ route('customer.myJob', session(['service_click' => TRUE, 'running_service_click' => TRUE])) }}'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="col text-center">
                        <b id=""> {{ __('Running Serrvice Order') }}</b>
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
                                    <div class="col-auto">
                                        <figure class="avatar avatar-60"><img src="{{ asset($serviceBid->customer->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                                    </div>
                                    <div class="col pl-0">
                                        <div class="row justify-content-between">
                                            <div class="col-12  align-self-center">
                                                <h5 class="mb-1" style="text-transform: capitalize">{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->name }}</h5>
                                            </div>
                                            <div class="col-12">
                                                <div class="row small text-mute text-trucated mt-1 justify-content-between align-items-center">
                                                    @php
                                                        $sum = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->sum('rating');
                                                        $count = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->count();
                                                        if (App\ServiceReview::where('worker_id', $serviceBid->worker_id)->exists()) {
                                                            $total_review = $sum/$count;
                                                        }else {
                                                            $total_review = 0;
                                                        }

                                                        if ($total_review>4.5)
                                                            $star = 5;
                                                        else if ($total_review>3.5)
                                                            $star = 4;
                                                        else if ($total_review>2.5)
                                                            $star = 3;
                                                        else if ($total_review>1.5)
                                                            $star = 2;
                                                        else if ($total_review>0.5)
                                                            $star = 1;
                                                        else
                                                            $star = 0;
                                                    @endphp
                                                    <div class="col-auto d-flex justify-content-between">
                                                        {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                                            <i class="material-icons btn-outline-warning">star</i>
                                                        {{-- @endfor --}}
                                                        <span class="text-right text-warning" style="font-size: 20px">{{ number_format((float)$total_review, 1, '.', '') }}({{ $count }})</span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->location }}" target="_blank"><i class="material-icons text-warning" style="font-size: 30px;">edit_location</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- new budget -->
                                {{-- <div class="">
                                    <div class="alert alert-danger text-center" role="alert">
                                        <div class="alert alert-info text-center">{{ __('প্রয়োজন অনুযায়ী প্রাইস পরিবর্তন করুন') }}</div>
                                        <div class="row">
                                            @if ($serviceBid->proposed_budget )
                                            <div class="col-auto">
                                                <div class="alert alert-success text-center">সার্ভিস প্রোভাইডার অর্ডারটি {{ $serviceBid->proposed_budget }} টাকায় করতে আগ্রহী। সম্মত থাকলে Accept করুন অথবা Reject করুন।</div>
                                                <div class="btn-group d-flex flex-wrap">
                                                    <input type="hidden" id="proposed_budget" value="{{ $serviceBid->proposed_budget }}">
                                                    <button class="btn btn-lg btn-success" id="accept_budget" style="border-radius: 5px !important;">Accept</button>
                                                    <button class="btn btn-lg btn-danger" id="cancel_budget" style="border-radius: 5px !important;">cancel</button>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col text-center">
                                                <input type="hidden" id="service-id" value="{{ $serviceBid->id }}">
                                                <input type="number" id="budget" placeholder="250" class="form-control form-control-lg text-center">
                                                <button type="button" id="update-budget" class="mb-2 btn btn-lg btn-info mt-3" style="width: 100%">{{ __('submit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col p-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="phone" placeholder="phone" readonly value="{{ App\User::find($serviceBid->worker_id)->phone }}">
                                            <div class="input-group-prepend">
                                                <a href="tel:{{ App\User::find($serviceBid->worker_id)->phone }}">
                                                    <span class="input-group-text bg-success text-white dz-clickable" onclick="" id="phone">{{ __('Call') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class=" row p-4">
                                            <div class="col-6">
                                                Order #AO{{ $serviceBid->id }}
                                            </div>
                                            <div class="col-6 text-right">
                                                {{ $serviceBid->budget }} ৳
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="container">
                                        <div class="row container">
                                                {{ __('প্রয়োজন অনুযায়ী প্রাইস পরিবর্তন করুন') }}
                                            <hr>
                                        </div>
                                        <div class="row P-2">
                                            <div class="col-lg-10 col-12">
                                               <div class="form-group mb-2 ">
                                                    <input type="hidden" id="service-id" value="{{ $serviceBid->id }}">
                                                    <input type="number" id="budget" placeholder="250" class="form-control form-control-lg text-center">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-12 text-center">
                                                <button type="button" data-worker-limit="{{ App\User::worker_bid_gig_limit($serviceBid->worker_id) }}" id="update-budget" class=" btn btn-success ">{{ __('submit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if ($serviceBid->proposed_budget )
                                    <div class="col-12">
                                        <div class="alert alert-success text-center">সার্ভিস প্রোভাইডার অর্ডারটি {{ $serviceBid->proposed_budget }} টাকায় করতে আগ্রহী। সম্মত থাকলে Accept করুন অথবা Reject করুন।</div>
                                        <div class="btn-group d-flex flex-wrap">
                                            <input type="hidden" id="proposed_budget" value="{{ $serviceBid->proposed_budget }}">
                                            <button class="btn btn-lg btn-success mr-1" id="accept_budget" style="border-radius: 5px !important;">Accept</button>
                                            <button class="btn btn-lg btn-danger ml-1" id="cancel_budget" style="border-radius: 5px !important;">cancel</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <!-- work detail -->
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <p class="" style="text-transform: capitalize"><b>{{ App\PageService::withTrashed()->find($serviceBid->worker_service_id)->title }}</b></p>
                                    </div>
                                    <div class="col-auto">
                                        @php
                                            $sum = App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->sum('rating');
                                            $count = App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->count();
                                            if (App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->exists()) {
                                                $total_review = $sum/$count;
                                            }else {
                                                $total_review = 0;
                                            }

                                            if ($total_review>4.5)
                                                $star = 5;
                                            else if ($total_review>3.5)
                                                $star = 4;
                                            else if ($total_review>2.5)
                                                $star = 3;
                                            else if ($total_review>1.5)
                                                $star = 2;
                                            else if ($total_review>0.5)
                                                $star = 1;
                                            else
                                                $star = 0;
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                                <i class="material-icons btn-outline-warning btn-sm p-0">star</i>
                                            {{-- @endfor --}}
                                            <span class="text-right text-warning" style="font-size: 15px">{{ number_format((float)$total_review, 1, '.', '') }} ({{ $count }})</span>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                    @php
                                        echo App\PageService::withTrashed()->find($serviceBid->worker_service_id)->description;
                                    @endphp
                                </p>
                                <hr>
                                <b>{{ __('Details:') }}</b>
                                <div>{!! $serviceBid->description !!}</div>
                                <br>
                                <b>{{ __('Address:') }}</b>
                                <p>{{ $serviceBid->address }}</p>
                                <br>
                                
                            </br>
                                <b>{{ __('Image:') }}</b>
                                <div class="custom-file">
                                    <input type="hidden" name="page-id" id="page-id" value="{{ $serviceBid->id }}">
                                    <input type="file" accept="image/*" class="custom-file-input" @if($serviceBid->image) disabled readonly @endif id="image" required="">
                                    <label class="custom-file-label" for="image">@if($serviceBid->image) {{ __('Already uploaded') }} @else {{ __('Chose file') }} @endif</label>
                                </div>
                                @if($serviceBid->image)
                                        <img id="myImg" src="{{ asset($serviceBid->image) }}" class="text-center p-2" style="width: 100%; max-height: 2000px; ">
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
                                <hr>
                                <div class="alert text-mute text-justify" style="text-align-last: center;">অর্ডার ডেলিভারি টাইম {{ App\PageService::withTrashed()->find($serviceBid->worker_service_id)->day }} {{ __('ঘন্টা') }}</div>
                                <hr>
                                <div class="w-100 mb-2 text-center" >
                                    <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ') }} {{  date('h:i a', strtotime($serviceBid->time)) }}, {{  date('d F Y', strtotime($serviceBid->date)) }} </small></button>
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
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <button disabled type="button" class="btn btn-outline-success w-100">{{  date('h:i a, d/m/y', strtotime($serviceBid->created_at)) }}</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button disabled type="button" class="btn btn-outline-success w-100"><small>{{ __('time') }} </small>{{ App\PageService::withTrashed()->find($serviceBid->worker_service_id)->day }}<small> {{ __('Hours') }}</small></button>
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <div class="col-md-12 mb-3">
                                        <div class="btn-group d-flex flex-wrap align-items-center justify-content-center">
                                            <button  onclick="complainNow({{ $serviceBid->id }});"  type="button" class="btn btn-danger mr-1">{{ __('Complain') }}</button>
                                            <button id="completed-btn" class="btn btn-success ml-1">Complete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Active Bids -->
            <!-- End running Bids -->

    @elseif($serviceBid->status == 'completed')
        <!-- Start title -->
            <div class="">
                <div class="alert alert-success row" role="alert">
                    <div class="col-1">
                        <button class="border-0 bg-transparent" onclick="window.location.href='{{ route('customer.myJob', session(['service_click' => TRUE, 'completed_service_click' => TRUE])) }}'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="col text-center">
                        <b id=""> {{ __('Completed Service Order') }}</b>
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
                                    <div class="col-auto">
                                        <figure class="avatar avatar-60"><img src="{{ asset($serviceBid->customer->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                                    </div>
                                    <div class="col pl-0">
                                        <div class="row justify-content-between">
                                            <div class="col-12  align-self-center">
                                                <h5 class="mb-1" style="text-transform: capitalize">{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->name }}</h5>
                                            </div>
                                            <div class="col-12">
                                                <div class="row small text-mute text-trucated mt-1 justify-content-between align-items-center">
                                                    @php
                                                        $sum = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->sum('rating');
                                                        $count = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->count();
                                                        if (App\ServiceReview::where('worker_id', $serviceBid->worker_id)->exists()) {
                                                            $total_review = $sum/$count;
                                                        }else {
                                                            $total_review = 0;
                                                        }

                                                        if ($total_review>4.5)
                                                            $star = 5;
                                                        else if ($total_review>3.5)
                                                            $star = 4;
                                                        else if ($total_review>2.5)
                                                            $star = 3;
                                                        else if ($total_review>1.5)
                                                            $star = 2;
                                                        else if ($total_review>0.5)
                                                            $star = 1;
                                                        else
                                                            $star = 0;
                                                    @endphp
                                                    <div class="col-auto d-flex justify-content-between">
                                                        {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                                            <i class="material-icons btn-outline-warning">star</i>
                                                        {{-- @endfor --}}
                                                        <span class="text-right text-warning" style="font-size: 20px">{{ $star }} ({{ $count }})</span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->location }}" target="_blank"><i class="material-icons text-warning" style="font-size: 30px;">edit_location</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col p-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="phone" placeholder="phone" readonly value="{{ App\User::find($serviceBid->worker_id)->phone }}">
                                            <div class="input-group-prepend">
                                                <a href="tel:{{ App\User::find($serviceBid->worker_id)->phone }}">
                                                    <span class="input-group-text bg-success text-white dz-clickable" onclick="" id="phone">{{ __('Call') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class=" row p-4">
                                            <div class="col-6">
                                                Order #AO{{ $serviceBid->id }}
                                            </div>
                                            <div class="col-6 text-right">
                                                {{ $serviceBid->budget }} ৳
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- work detail -->
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <p class="" style="text-transform: capitalize"><b>{{ App\PageService::withTrashed()->find($serviceBid->worker_service_id)->title }}</b></p>
                                    </div>
                                    <div class="col-auto">
                                        @php
                                            $sum = App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->sum('rating');
                                            $count = App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->count();
                                            if (App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->exists()) {
                                                $total_review = $sum/$count;
                                            }else {
                                                $total_review = 0;
                                            }

                                            if ($total_review>4.5)
                                                $star = 5;
                                            else if ($total_review>3.5)
                                                $star = 4;
                                            else if ($total_review>2.5)
                                                $star = 3;
                                            else if ($total_review>1.5)
                                                $star = 2;
                                            else if ($total_review>0.5)
                                                $star = 1;
                                            else
                                                $star = 0;
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                                <i class="material-icons btn-outline-warning btn-sm p-0">star</i>
                                            {{-- @endfor --}}
                                            <span class="text-right text-warning" style="font-size: 15px">{{ $star }} ({{ $count }})</span>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                    @php
                                        echo App\PageService::withTrashed()->find($serviceBid->worker_service_id)->description;
                                    @endphp
                                </p>
                                <hr>
                                <b>{{ __('Details:') }}</b>
                                <div>{!! $serviceBid->description !!}</div>
                                <br>
                                <b>{{ __('Address:') }}</b>
                                <p>{{ $serviceBid->address }}</p>
                                <br>
                                <hr>
                                <div class="btn-group flex-wrap btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                                    <button disabled type="button" class="btn btn-outline-success active">
                                        <b>{{ __('Delivery date') }}</b> <br>
                                        <small>
                                            {{ date('h:i:s a d/m/y', strtotime($serviceBid->updated_at)) }}
                                        </small>
                                    </button>
                                    @php
                                        $review = App\ServiceReview::where('service_bid_id', $serviceBid->id)->where('customer_id', Auth::user()->id)->first();
                                    @endphp
                                    <input type="hidden" id="service-id" value="{{ $serviceBid->id }}">
                                    @if ($review)
                                        <input type="hidden" id="review-id" value="{{ $review->id }}">
                                        {{-- <button  id="edit-review-btn" class="btn btn-success">Edit Review</button> --}}
                                    @else
                                        <button id="review-btn" class="btn btn-success">Give Review</button>
                                    @endif
                                </div>
                                <div class="w-100 mb-2 text-center" >
                                    <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ছিল ') }} {{  date('h:i a', strtotime($serviceBid->time)) }}, {{  date('d F Y', strtotime($serviceBid->date)) }} </small></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Completed Bids -->
            <!-- End Completed Bids -->
    @elseif($serviceBid->status == 'cancelled')
        <!-- Start title -->
            <div class="">
                <div class="alert alert-danger row" role="alert">
                    <div class="col-1">
                        <button class="border-0 bg-transparent" onclick="window.location.href='{{ route('customer.myJob', session(['service_click' => TRUE, 'cancelled_service_click' => TRUE])) }}'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="col text-center">
                        <b id="">{{ __('Cancelled Service Order') }}</b>
                    </div>
                    <div class="col-1"></div>
                </div>
            </div>
            <!-- End title -->
            <!--Start owner info & price-->
            <div class="container">
                <div class="card bg-danger shadow pb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-60"><img src="{{ asset($serviceBid->customer->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                            </div>
                            <div class="col pl-0">
                                <div class="row justify-content-between">
                                    <div class="col-12  align-self-center">
                                        <h5 class="mb-1" style="text-transform: capitalize">{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->name }}</h5>
                                    </div>
                                    <div class="col-12">
                                        <div class="row small text-mute text-trucated mt-1 justify-content-between align-items-center">
                                            @php
                                                $sum = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->sum('rating');
                                                $count = App\ServiceReview::where('worker_id', $serviceBid->worker_id)->count();
                                                if (App\ServiceReview::where('worker_id', $serviceBid->worker_id)->exists()) {
                                                    $total_review = $sum/$count;
                                                }else {
                                                    $total_review = 0;
                                                }

                                                if ($total_review>4.5)
                                                    $star = 5;
                                                else if ($total_review>3.5)
                                                    $star = 4;
                                                else if ($total_review>2.5)
                                                    $star = 3;
                                                else if ($total_review>1.5)
                                                    $star = 2;
                                                else if ($total_review>0.5)
                                                    $star = 1;
                                                else
                                                    $star = 0;
                                            @endphp
                                            <div class="col-auto d-flex justify-content-between">
                                                {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                                    <i class="material-icons btn-outline-warning">star</i>
                                                {{-- @endfor --}}
                                                <span class="text-right text-warning" style="font-size: 20px">{{ $star }} ({{ $count }})</span>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ App\WorkerPage::where('worker_id', $serviceBid->worker_id)->first()->location }}" target="_blank"><i class="material-icons text-warning" style="font-size: 30px;">edit_location</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="phone" placeholder="phone" readonly value="{{ App\User::find($serviceBid->worker_id)->phone }}">
                        <div class="input-group-prepend">
                            <a href="tel:{{ App\User::find($serviceBid->worker_id)->phone }}">
                                <span class="input-group-text bg-success text-white dz-clickable" onclick="" id="phone">{{ __('Call') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class=" row p-4">
                        <div class="col-6">
                            Order #AO{{ $serviceBid->id }}
                        </div>
                        <div class="col-6 text-right">
                            {{ $serviceBid->budget }} ৳
                        </div>
                        
                    </div>
                </div>
            </div>
            <hr>
            <div class="container" style="margin-top: -15px">
                <div class="card mb-4 shadow">
                    <div class="card-footer bg-none">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <p class="" style="text-transform: capitalize"><b>{{ App\PageService::withTrashed()->find($serviceBid->worker_service_id)->title }}</b></p>
                            </div>
                            <div class="col-auto">
                                @php
                                    $sum = App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->sum('rating');
                                    $count = App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->count();
                                    if (App\ServiceReview::where('worker_service_id', $serviceBid->worker_service_id)->exists()) {
                                        $total_review = $sum/$count;
                                    }else {
                                        $total_review = 0;
                                    }

                                    if ($total_review>4.5)
                                        $star = 5;
                                    else if ($total_review>3.5)
                                        $star = 4;
                                    else if ($total_review>2.5)
                                        $star = 3;
                                    else if ($total_review>1.5)
                                        $star = 2;
                                    else if ($total_review>0.5)
                                        $star = 1;
                                    else
                                        $star = 0;
                                @endphp
                                <div class="d-flex align-items-center">
                                    {{-- @for ($starCounter = 1; $starCounter <= $star; $starCounter++) --}}
                                        <i class="material-icons btn-outline-warning btn-sm p-0">star</i>
                                    {{-- @endfor --}}
                                    <span class="text-right text-warning" style="font-size: 15px">{{ $star }} ({{ $count }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End owner info & price-->
            <!--Start work detail , address, day-->
            <div class="container">
                <h4 class="mb-3"><b>{{ __('Order Details') }}:</b></h4>
                <div>{!! $serviceBid->description !!}</div>
                <h4 class="mb-3"><b>{{ __('Order Address') }}:</b></h4>
                <p>{{ $serviceBid->address }}</p>
                <div class="btn-group btn-group-lg btn-group w-100 mb-2 text-center" role="group" aria-label="Basic example">
                    <button disabled type="button" class="btn btn-outline-danger active">
                        <b>{{ __('Cancelled Date') }}</b> <br>
                        <small>
                            {{ date('h:i:s a d/m/y', strtotime($serviceBid->updated_at)) }}
                        </small>
                    </button>
                </div>

                <div class="w-100 mb-2 text-center" >
                    <button disabled type="button" class="w-100 btn btn-outline-success btn-rounded"><small> {{ __('অর্ডারটি শুরু করার সম্ভাব্য তারিখ ও সময় ছিল ') }} {{  date('h:i a', strtotime($serviceBid->time)) }}, {{  date('d F Y', strtotime($serviceBid->date)) }} </small></button>
                </div>
            </div>
            <!--End work detail , address, day-->
            <hr>
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
    <!-- page level script -->
    <script>
    function complainNow(serviceBid){
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
                formData.append('serviceBid', serviceBid)
                formData.append('complain', complain)
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.completedserviceBidAndComplain') }}",
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
            //Update Budget with confirm alert
            $("#update-budget").click(function (){
                // var worker_limit = Number($(this).attr('data-worker-limit'));
                // var budget = Number($('#budget').val());
                // if(budget > worker_limit) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Worker Balance Limit',
                //         footer: 'Worker Gig limit is less than your budget!'
                //     })
                // }else{
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
                            formData.append('service', $('#service-id').val())
                            formData.append('budget', $('#budget').val())
                            $.ajax({
                                method: 'POST',
                                url: "{{ route('customer.updateserviceBidBudget') }}",
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
                // }
            });

            $("#accept_budget").click(function (){
                // var worker_limit = Number($('#update-budget').attr('data-worker-limit'));
                // var budget = Number($('#proposed_budget').val());
                // if(budget > worker_limit) {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Worker Balance Limit',
                //         footer: 'Worker Gig limit is less than your budget!'
                //     })
                // }else{
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
                            formData.append('service', $('#service-id').val())
                            formData.append('budget', $('#proposed_budget').val())
                            $.ajax({
                                method: 'POST',
                                url: "{{ route('customer.acceptServiceBidBudget') }}",
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
                // }
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
                        formData.append('service', $('#service-id').val())
                        formData.append('budget', $('#proposed_budget').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelServiceBidBudget') }}",
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
                    title: 'Cancel this Service ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('service', $('#service-id').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelserviceBid') }}",
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
                // alert($('#page-id').val());
                var formData = new FormData();
                formData.append('bid', $('#page-id').val())
                formData.append('image', $('#image')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.imageUploadTopageBid') }}",
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
            $('#completed-submit').click(function (){
            $("#completed-submit").prop("disabled", true);
                var formData = new FormData();
                formData.append('rate', $('.rating-btn:checked').val())
                formData.append('service', $('#service-id').val())
                formData.append('review', $('#complete_review').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.completedserviceBidAndRating') }}",
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
                        setTimeout(function() {
                            //your code to be executed after 1 second
                            location.reload();
                        }, 1000); //1 second
                    }
                });
            });

            $('#review-btn').click(function (){
                $('#complete-modal').modal('show');
            });

            $('#edit-review-btn').click(function (){
                $('#complete-modal').modal('show');
                @if(isset($review))
                    $("#rating-{{ $review->rating }}").trigger('click');
                    $('#complete_review').html("{{ $review->review }}");
                @endif
            });
            $('#update_review_submit').click(function (){
                $("#update_review_submit").prop("disabled", true);
                var formData = new FormData();
                formData.append('review_id', $('#review-id').val())
                formData.append('rate', $('.rating-btn:checked').val())
                formData.append('review', $('#complete_review').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.updateserviceBidAndRating') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#update_review_submit").prop("disabled", false);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
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
        @if($serviceBid->status == 'active')

            @php 
                $deadline = get_static_option('worker_job_request_accept_hour');
                $date = $serviceBid->created_at;
                $ending_at = Carbon\Carbon::parse($date);
                $ending_at->addHours($deadline);
                $current_timestamp = Carbon\Carbon::now()->toDateTimeString();
            @endphp

            if ("{{ $ending_at }}" < "{{ $current_timestamp }}") {
                var formData = new FormData();
                formData.append('service', $('#service-id').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('customer.cancelserviceBid') }}",
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
                        formData.append('service', $('#service-id').val())
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('customer.cancelserviceBid') }}",
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


        @if($serviceBid->status == 'running' && $serviceBid->completed_at)
            // const second = 1000,
            // minute = second * 60,
            // hour = minute * 60,
            // day = hour * 24;

            // let countDown = new Date("$serviceBid->completed_at }").getTime(),
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

    @if (session('cancelled_service_click'))
        {{ Session::forget('pending_service_click') }}
    @endif
@endsection
