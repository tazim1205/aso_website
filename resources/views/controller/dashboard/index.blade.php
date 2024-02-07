@extends('controller.layout.app')
@push('title') {{ __('Dashboard') }} @endpush
@push('head')
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-body  container-fluid">
                    <!-- Minimal statistics section start -->
                    <section id="minimal-statistics">

                        <!-- card start -->
                        <div class="row mt-1">
                            <!--Card 1-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Users</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ auth()->user()->upazila->users->count() }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">people_outline</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 2-->

                            <!--Card 3-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Customer</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{auth()->user()->upazila->customers->count() }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">people_outline</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 4 -->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Worker</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ auth()->user()->upazila->workers->count() }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">people_outline</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 5 -->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Marketer</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ auth()->user()->upazila->marketers->count() }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">people_outline</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Memberships</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{auth()->user()->upazila->memberships->count() }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">people_outline</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Pourashava /Union
                                                        /Area</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{auth()->user()->upazila->pouroshova->count() }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">location_on</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 7-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Ward/Road</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">location_on</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 8-->
                            <!--Card 9-->

                        </div>
                        <!-- card start -->
                        <!-- row end -->

                        <!-- Income & Exp select option row -->
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <div class="card card-background-blue">
                                    <div class="card-content">
                                        <div class="card-body select-card-design">
                                            <h4 class="select-title white">Income & Exp</h4>

                                            <select name="month" class="form-control width-30-percent">
                                                <option value=''>--Select Month--</option>
                                                <option selected value='1'>Janaury</option>
                                                <option value='2'>February</option>
                                                <option value='3'>March</option>
                                                <option value='4'>April</option>
                                                <option value='5'>May</option>
                                                <option value='6'>June</option>
                                                <option value='7'>July</option>
                                                <option value='8'>August</option>
                                                <option value='9'>September</option>
                                                <option value='10'>October</option>
                                                <option value='11'>November</option>
                                                <option value='12'>December</option>
                                            </select>
                                            <select name="year" class="form-control width-30-percent">
                                                <option value=''>--Select Year--</option>
                                                <option value="2030">2030</option>
                                                <option value="2029">2029</option>
                                                <option value="2028">2028</option>
                                                <option value="2027">2027</option>
                                                <option value="2026">2026</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option selected value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- select option row end -->
                        <!-- Income & Exp card start -->
                        <div class="row">
                            <!--Card 1-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Income</span>
                                                    <h5 class="mb-0 font-weight-bolder">500</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">account_balance_wallet
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 2-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Affiliate Marketing
                                                        Cost</span>
                                                    <h5 class="mb-0 font-weight-bolder">930</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">account_balance_wallet
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 3-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Fund Exp</span>
                                                    <h5 class="mb-0 font-weight-bolder">500</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">account_balance_wallet
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 4 -->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Fund Reserve</span>
                                                    <h5 class="mb-0 font-weight-bolder">930</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">account_balance_wallet
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Income & Exp card end -->

                        <!-- Order Quantity select option row -->
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <div class="card card-background-blue">
                                    <div class="card-content">
                                        <div class="card-body select-card-design">
                                            <h4 class="select-title white">Order Quantity</h4>
                                            <select name="month" class="form-control width-12-percent">
                                                <option value=''>--Select Month--</option>
                                                <option selected value='1'>Janaury</option>
                                                <option value='2'>February</option>
                                                <option value='3'>March</option>
                                                <option value='4'>April</option>
                                                <option value='5'>May</option>
                                                <option value='6'>June</option>
                                                <option value='7'>July</option>
                                                <option value='8'>August</option>
                                                <option value='9'>September</option>
                                                <option value='10'>October</option>
                                                <option value='11'>November</option>
                                                <option value='12'>December</option>
                                            </select>
                                            <select name="year" class="form-control width-10-percent">
                                                <option value=''>--Select Year--</option>
                                                <option value="2030">2030</option>
                                                <option value="2029">2029</option>
                                                <option value="2028">2028</option>
                                                <option value="2027">2027</option>
                                                <option value="2026">2026</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option selected value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                            </select>
                                            <select name="pourashava" class="form-control width-25-percent">
                                                <option selected>Pourashava/Union/Area</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                            <select name="ward" class="form-control width-25-percent">
                                                <option selected>Ward/Road</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- select option row end -->
                        @php
                            $total_worker_bids=0;
                            foreach (auth()->user()->upazila->workers as $worker){
                                $total_worker_bids += $worker->workerBids->count();
                            }

                            $total_worker_gigs=0;
                            foreach (auth()->user()->upazila->workers as $worker){
                                $total_worker_gigs += $worker->workerGigs->count();
                            }

                            $total_customer_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_worker_bids += $worker->customerBids->count();
                            }

                            $total_customer_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_worker_gigs += $worker->customerGigs->count();
                            }

                            $total_worker_selected_bids=0;
                            foreach (auth()->user()->upazila->workers as $worker){
                                $total_worker_selected_bids += $worker->workerBids->where('is_selected', 1)->count();
                            }
                            $total_worker_cancelled_bids=0;
                            foreach (auth()->user()->upazila->workers as $worker){
                                $total_worker_cancelled_bids += $worker->workerBids->where('is_cancelled', 1)->count();
                            }
                            $total_worker_pending_bids=0;
                            foreach (auth()->user()->upazila->workers as $worker){
                                $total_worker_pending_bids += $worker->workerBids->where('is_cancelled', 0)->where('is_selected', 0)->count();
                            }
                            $total_customer_pending_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_pending_bids += $worker->customerBids->where('is_cancelled', 0)->where('is_selected', 0)->count();
                            }
                            $total_customer_selected_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_selected_bids += $worker->customerBids->where('is_selected', 1)->count();
                            }
                            $total_customer_cancelled_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_cancelled_bids += $worker->customerBids->where('is_cancelled', 1)->count();
                            }
                            $total_customer_active_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_active_gigs += $worker->customerGigs->where('status', 'active')->count();
                            }
                            $total_customer_running_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_running_gigs += $worker->customerGigs->where('status', 'running')->count();
                            }

                            $total_customer_pending_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_pending_gigs += $worker->customerGigs->where('status', 'pending')->count();
                            }

                            $total_customer_complete_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_complete_gigs += $worker->customerGigs->where('status', 'complete')->count();
                            }
                            $total_customer_cancelled_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_cancelled_gigs += $worker->customerGigs->where('status', 'cancelled')->count();
                            }

                            $total_running_bid_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_running_bid_order += $worker->customerBids->where('status', 'running')->count();
                            }

                            $total_complete_bid_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_complete_bid_order += $worker->customerBids->where('status', 'completed')->count();
                            }

                            $total_cancelled_bid_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_cancelled_bid_order += $worker->customerBids->where('status', 'cancelled')->count();
                            }

                            // Service Order

                            $total_pending_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_pending_service_order += $worker->serviceOrder->where('status', 'pending')->count();
                            }

                            $total_running_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_running_service_order += $worker->serviceOrder->where('status', 'running')->count();
                            }

                            $total_completed_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_completed_service_order += $worker->serviceOrder->where('status', 'completed')->count();
                            }

                            $total_cancelled_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_cancelled_service_order += $worker->serviceOrder->where('status', 'cancelled')->count();
                            }

                            //Special Service Order
                            $total_pending_special_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_pending_special_service_order += $worker->specialServiceOrder->where('status', 'pending')->count();
                            }

                            $total_running_special_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_running_special_service_order += $worker->specialServiceOrder->where('status', 'running')->count();
                            }

                            $total_completed_special_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_completed_special_service_order += $worker->specialServiceOrder->where('status', 'completed')->count();
                            }

                            $total_cancelled_special_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_cancelled_special_service_order += $worker->specialServiceOrder->where('status', 'cancelled')->count();
                            }

                        @endphp
                        <!-- Order Quantity card start -->
                        <div class="row">
                            <!--Card 1-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Pending Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_customer_pending_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">shopping_cart</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 2-->

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Running Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_running_bid_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">shopping_cart</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 5 -->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Completed Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_complete_bid_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3"
                                                        style="color:#17ad37">shopping_cart
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Canceled Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_cancelled_bid_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue red font-large-3">remove_shopping_cart
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->

                            <!--Card 3-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Pending Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_customer_pending_gigs }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">shopping_cart</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 4 -->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Running Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_customer_running_gigs }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">shopping_cart</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 5 -->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Completed Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_customer_complete_gigs }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3"
                                                        style="color:#17ad37">shopping_cart
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Canceled Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_customer_cancelled_gigs }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue red font-large-3">remove_shopping_cart
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Pending Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_pending_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">beach_access
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Running Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_running_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">beach_access
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Completed Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_completed_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons green font-large-3">beach_access
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Canceled Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_cancelled_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">beach_access
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->



                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Pending Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_pending_special_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">blur_circular
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Running Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_running_special_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">blur_circular
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Completed Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_completed_special_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons green font-large-3">blur_circular
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Canceled Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_cancelled_special_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">blur_circular
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Auto canceled Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">confirmation_number
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Auto canceled Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">confirmation_number
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1"> Auto canceled Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">confirmation_number
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Auto canceled Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">confirmation_number
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1"> Total Worker Bids</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_worker_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">texture</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--Card 10-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Workers Pending Bid</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_worker_pending_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">card_giftcard</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 11-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Workers Selected Bid</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_worker_selected_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">card_giftcard</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 13-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Workers Cancelled
                                                        Bid</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_worker_cancelled_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">card_giftcard</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 12-->

                            <!-- end -->
                        </div>
                        <!-- Order Quantity card end -->


                        <!-- Order Price select option row -->
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <div class="card card-background-blue">
                                    <div class="card-content">
                                        <div class="card-body select-card-design">
                                            <h4 class="select-title white">Order Price</h4>
                                            <select name="month" class="form-control width-12-percent">
                                                <option value=''>--Select Month--</option>
                                                <option selected value='1'>Janaury</option>
                                                <option value='2'>February</option>
                                                <option value='3'>March</option>
                                                <option value='4'>April</option>
                                                <option value='5'>May</option>
                                                <option value='6'>June</option>
                                                <option value='7'>July</option>
                                                <option value='8'>August</option>
                                                <option value='9'>September</option>
                                                <option value='10'>October</option>
                                                <option value='11'>November</option>
                                                <option value='12'>December</option>
                                            </select>
                                            <select name="year" class="form-control width-10-percent">
                                                <option value=''>--Select Year--</option>
                                                <option value="2030">2030</option>
                                                <option value="2029">2029</option>
                                                <option value="2028">2028</option>
                                                <option value="2027">2027</option>
                                                <option value="2026">2026</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option selected value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                            </select>
                                            <select name="pourashava" class="form-control width-25-percent">
                                                <option selected>Pourashava/Union/Area</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                            <select name="ward" class="form-control width-25-percent">
                                                <option selected>Ward/Road</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Order Price select option row end -->

                        @php
                            $total_pending_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_pending_bids += $worker->customerBids->where('status', 'pending')->sum('budget');
                            }
                            $total_running_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_running_bids += $worker->customerBids->where('status', 'running')->sum('budget');
                            }
                            $total_completed_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_completed_bids += $worker->customerBids->where('status', 'completed')->sum('budget');
                            }
                            $total_cancelled_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_cancelled_bids += $worker->customerBids->where('status', 'cancelled')->sum('budget');
                            }

                            //Gig
                            $total_pending_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_pending_gigs += $worker->customerGigs->where('status', 'pending')->sum('budget');
                            }
                            $total_running_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_running_gigs += $worker->customerGigs->where('status', 'running')->sum('budget');
                            }
                            $total_completed_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_completed_gigs += $worker->customerGigs->where('status', 'completed')->sum('budget');
                            }
                            $total_cancelled_gigs=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_cancelled_gigs += $worker->customerGigs->where('status', 'cancelled')->sum('budget');
                            }

                            // Service Order

                            $total_pending_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_pending_service_order += $worker->serviceOrder->where('status', 'pending')->sum('budget');
                            }

                            $total_running_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_running_service_order += $worker->serviceOrder->where('status', 'running')->sum('budget');
                            }

                            $total_completed_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_completed_service_order += $worker->serviceOrder->where('status', 'completed')->sum('budget');
                            }

                            $total_cancelled_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_cancelled_service_order += $worker->serviceOrder->where('status', 'cancelled')->sum('budget');
                            }

                            //Special Service Order
                            $total_pending_special_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_pending_special_service_order += $worker->specialServiceOrder->where('status', 'pending')->sum('fee');
                            }

                            $total_running_special_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_running_special_service_order += $worker->specialServiceOrder->where('status', 'running')->sum('fee');
                            }

                            $total_completed_special_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_completed_special_service_order += $worker->specialServiceOrder->where('status', 'completed')->sum('fee');
                            }

                            $total_cancelled_special_service_order = 0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_cancelled_special_service_order += $worker->specialServiceOrder->where('status', 'cancelled')->sum('fee');
                            }

                            $total_worker_bids=0;
                            foreach (auth()->user()->upazila->workers as $worker){
                                $total_worker_bids += $worker->workerBids->sum('budget');
                            }
                            $total_worker_pending_bids=0;
                            foreach (auth()->user()->upazila->workers as $worker){
                                $total_worker_pending_bids += $worker->workerBids->where('is_cancelled', 0)->where('is_selected', 0)->sum('budget');
                            }

                            $total_customer_selected_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_selected_bids += $worker->customerBids->where('is_selected', 1)->sum('budget');
                            }
                            $total_customer_cancelled_bids=0;
                            foreach (auth()->user()->upazila->customers as $worker){
                                $total_customer_cancelled_bids += $worker->customerBids->where('is_cancelled', 1)->sum('budget');
                            }
                        @endphp
                        <!-- Order Price card start -->
                        <div class="row">
                            <!--Card 1-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Pending Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{$total_pending_bids}}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">timelapse</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 2-->

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Running Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_running_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">timelapse</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 5 -->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Completed Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_completed_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3"
                                                        style="color:#17ad37">timelapse
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Canceled Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_cancelled_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue red font-large-3">timelapse
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->

                            <!--Card 3-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Pending Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_pending_gigs }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">timelapse</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 4 -->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Running Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_running_gigs }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">timelapse</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 5 -->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Completed Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_completed_gigs }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3"
                                                        style="color:#17ad37">timelapse
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Canceled Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_cancelled_gigs }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue red font-large-3">timelapse
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Pending Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_pending_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">beach_access
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Running Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_running_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">beach_access
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Completed Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_completed_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons green font-large-3">beach_access
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Canceled Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_cancelled_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">beach_access
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->



                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Pending Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_pending_special_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">blur_circular
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Running Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_running_special_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">blur_circular
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Completed Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_running_special_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons green font-large-3">blur_circular
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Canceled Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_cancelled_special_service_order }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">blur_circular
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Auto canceled Bid
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">confirmation_number
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Auto canceled Gig
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">confirmation_number
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1"> Auto canceled Service
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">confirmation_number
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Auto canceled Special
                                                        Order</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons red font-large-3">confirmation_number
                                                    </i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 6 -->

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1"> Total Worker Bids</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_worker_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">texture</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--Card 10-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Workers Pending Bid</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_worker_pending_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">card_giftcard</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 11-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Workers Selected Bid</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_customer_selected_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">card_giftcard</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 13-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Workers Cancelled
                                                        Bid</span>
                                                    <h5 class="mb-0 font-weight-bolder">{{ $total_customer_cancelled_bids }}</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">card_giftcard</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Card 12-->
                        </div>
                        <!-- Order Price card end -->

                        <!-- Member Package Quantity select option row -->
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <div class="card card-background-blue">
                                    <div class="card-content">
                                        <div class="card-body select-card-design">
                                            <h4 class="select-title white">Membership Package Quantity</h4>
                                            <select name="month" class="form-control width-12-percent">
                                                <option value=''>--Select Month--</option>
                                                <option selected value='1'>Janaury</option>
                                                <option value='2'>February</option>
                                                <option value='3'>March</option>
                                                <option value='4'>April</option>
                                                <option value='5'>May</option>
                                                <option value='6'>June</option>
                                                <option value='7'>July</option>
                                                <option value='8'>August</option>
                                                <option value='9'>September</option>
                                                <option value='10'>October</option>
                                                <option value='11'>November</option>
                                                <option value='12'>December</option>
                                            </select>
                                            <select name="year" class="form-control width-10-percent">
                                                <option value=''>--Select Year--</option>
                                                <option value="2030">2030</option>
                                                <option value="2029">2029</option>
                                                <option value="2028">2028</option>
                                                <option value="2027">2027</option>
                                                <option value="2026">2026</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option selected value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                            </select>
                                            <select name="pourashava" class="form-control width-20-percent">
                                                <option selected>Pourashava/Union/Area</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                            <select name="ward" class="form-control width-20-percent">
                                                <option selected>Ward/Road</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Member Package Quantity select option row end -->
                        <!-- Member Package Quantity card start -->
                        <div class="row">
                            @php
                            $membershipPackage = App\MembershipPackage::latest()->get();
                            // active membership package
                            $activeMembershipPackage = \App\Helpers\Controller\Helper::countActiveMembershipsForPackages();

                            @endphp
                            <!--Card 1-->
                            @foreach($membershipPackage as $package)
                                <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="media-body text-left align-self-bottom">
                                                        <span class="d-block mb-1 font-medium-1">Total {{ $package->name }}</span>
                                                        <h5 class="mb-0 font-weight-bolder">{{ $package->service_count }}</h5>
                                                    </div>
                                                    <div class="align-self-top">
                                                        <i class="material-icons dark-blue font-large-3">today</i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
{{--                            Active Package--}}
                            @foreach($activeMembershipPackage as $package)
                                <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="media-body text-left align-self-bottom">
                                                        <span class="d-block mb-1 font-medium-1">Active {{ $package['package_name'] }}</span>
                                                        <h5 class="mb-0 font-weight-bolder">{{ $package['active_memberships_count'] }}</h5>
                                                    </div>
                                                    <div class="align-self-top">
                                                        <i class="material-icons dark-blue font-large-3">today</i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <!-- Member Package Quantity card end -->

                        <!-- Member package Price select option row -->
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <div class="card card-background-blue">
                                    <div class="card-content">
                                        <div class="card-body select-card-design">
                                            <h4 class="select-title white">Membership package Price</h4>
                                            <select name="month" class="form-control width-12-percent">
                                                <option value=''>--Select Month--</option>
                                                <option selected value='1'>Janaury</option>
                                                <option value='2'>February</option>
                                                <option value='3'>March</option>
                                                <option value='4'>April</option>
                                                <option value='5'>May</option>
                                                <option value='6'>June</option>
                                                <option value='7'>July</option>
                                                <option value='8'>August</option>
                                                <option value='9'>September</option>
                                                <option value='10'>October</option>
                                                <option value='11'>November</option>
                                                <option value='12'>December</option>
                                            </select>
                                            <select name="year" class="form-control width-10-percent">
                                                <option value=''>--Select Year--</option>
                                                <option value="2030">2030</option>
                                                <option value="2029">2029</option>
                                                <option value="2028">2028</option>
                                                <option value="2027">2027</option>
                                                <option value="2026">2026</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option selected value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                            </select>
                                            <select name="pourashava" class="form-control width-20-percent">
                                                <option selected>Pourashava/Union/Area</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                            <select name="ward" class="form-control width-20-percent">
                                                <option selected>Ward/Road</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Member package Price select option row end -->
                        <!-- Member package Price card start -->
                        <div class="row">
                            @foreach($membershipPackage as $package)
                                <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="media-body text-left align-self-bottom">
                                                        <span class="d-block mb-1 font-medium-1">Total {{ $package->name }}</span>
                                                        <h5 class="mb-0 font-weight-bolder">{{$package->monthly_price}}</h5>
                                                    </div>
                                                    <div class="align-self-top">
                                                        <i class="material-icons dark-blue font-large-3">chrome_reader_mode</i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!--Card 1-->
                                @foreach($activeMembershipPackage as $package)
                                    <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="media d-flex">
                                                        <div class="media-body text-left align-self-bottom">
                                                            <span class="d-block mb-1 font-medium-1">Active {{ $package['package_name'] }}</span>
                                                            <h5 class="mb-0 font-weight-bolder">{{$package['package_price']}}</h5>
                                                        </div>
                                                        <div class="align-self-top">
                                                            <i class="material-icons dark-blue font-large-3">chrome_reader_mode</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                        </div>
                        <!-- Member package Price card end -->

                        <!-- Git Page and Service select option row -->
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <div class="card card-background-blue">
                                    <div class="card-content">
                                        <div class="card-body select-card-design">
                                            <h4 class="select-title white">Git, Page and Service</h4>
                                            <select name="month" class="form-control width-12-percent">
                                                <option value=''>--Select Month--</option>
                                                <option selected value='1'>Janaury</option>
                                                <option value='2'>February</option>
                                                <option value='3'>March</option>
                                                <option value='4'>April</option>
                                                <option value='5'>May</option>
                                                <option value='6'>June</option>
                                                <option value='7'>July</option>
                                                <option value='8'>August</option>
                                                <option value='9'>September</option>
                                                <option value='10'>October</option>
                                                <option value='11'>November</option>
                                                <option value='12'>December</option>
                                            </select>
                                            <select name="year" class="form-control width-10-percent">
                                                <option value=''>--Select Year--</option>
                                                <option value="2030">2030</option>
                                                <option value="2029">2029</option>
                                                <option value="2028">2028</option>
                                                <option value="2027">2027</option>
                                                <option value="2026">2026</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option selected value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                            </select>
                                            <select name="pourashava" class="form-control width-20-percent">
                                                <option selected>Pourashava/Union/Area</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                            <select name="ward" class="form-control width-20-percent">
                                                <option selected>Ward/Road</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Git Page and Service select option row end -->
                        <!-- Git Page and Service card start -->
                        <div class="row">

                            <!--Card 1-->
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Gig</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">equalizer</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Active Gig</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">equalizer</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Inactive Gig</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">equalizer</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">In Review Gig</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">equalizer</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Page</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">grain</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Active Page</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">grain</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Inactive Page</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">grain</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">In Review Page</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">grain</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Total Service</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">gradient</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Active Service</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">gradient</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">Inactive Service</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">gradient</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-6 col-xl-3 col-md-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body text-left align-self-bottom">
                                                    <span class="d-block mb-1 font-medium-1">In Review Service</span>
                                                    <h5 class="mb-0 font-weight-bolder">0</h5>
                                                </div>
                                                <div class="align-self-top">
                                                    <i class="material-icons dark-blue font-large-3">gradient</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Git Page and Service package Price card end -->

                    </section>
                    <!-- // Minimal statistics section end -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('foot')

@endpush
