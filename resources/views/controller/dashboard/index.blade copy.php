@extends('controller.layout.app')
@push('title') {{ __('Dashboard') }} @endpush
@push('head')
    <!-- notifications css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/notifications/css/lobibox.min.css') }}"/>
    <!-- Vector CSS -->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
@endpush
@section('content')
    <div class="content-wrapper">
        <!-- Start container-fluid-->
        <div class="container-fluid">

            <!--Start Customer, Worker, Member, Controller Content-->
            <div class="row mt-4">
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card gradient-scooter">
                        <div class="card-body p-4">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h4 class="text-white">{{ auth()->user()->upazila->users->count() }}</h4>
                                    <span class="text-white">{{ __('Total Users') }}</span>
                                </div>
                                <div class="align-self-center w-icon"><i class="icon-user text-white"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card gradient-bloody">
                        <div class="card-body p-4">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h4 class="text-white">{{auth()->user()->upazila->memberships->count() }}</h4>
                                    <span class="text-white">{{ __('Total Memberships') }}</span>
                                </div>
                                <div class="align-self-center w-icon"><i class="icon-user text-white"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card gradient-quepal">
                        <div class="card-body p-4">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h4 class="text-white">{{auth()->user()->upazila->customers->count() }}</h4>
                                    <span class="text-white">{{ __('Total Customers') }}</span>
                                </div>
                                <div class="align-self-center w-icon"><i class="icon-user text-white"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card gradient-blooker">
                        <div class="card-body p-4">
                            <div class="media">
                                <div class="media-body text-left">
                                    <h4 class="text-white">{{ auth()->user()->upazila->workers->count() }}</h4>
                                    <span class="text-white">{{ __('Total Workers') }}</span>
                                </div>
                                <div class="align-self-center w-icon"><i class="icon-user text-white"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        $total_customer_complete_gigs=0;
                        foreach (auth()->user()->upazila->customers as $worker){
                            $total_customer_complete_gigs += $worker->customerGigs->where('status', 'complete')->count();
                        }
                        $total_customer_cancelled_gigs=0;
                        foreach (auth()->user()->upazila->customers as $worker){
                            $total_customer_cancelled_gigs += $worker->customerGigs->where('status', 'cancelled')->count();
                        }

                @endphp
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card gradient-violet">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-basket-loaded"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('All worker bids') }}</h6>
                                    <h4 class="text-white">{{ $total_worker_bids }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card gradient-violet">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-basket-loaded"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('All worker gigs') }}</h6>
                                    <h4 class="text-white">{{ $total_worker_gigs }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card gradient-violet">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-basket-loaded"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('All customer bids') }}</h6>
                                    <h4 class="text-white">{{ $total_customer_bids }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card gradient-violet">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-basket-loaded"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('All customer gigs') }}</h6>
                                    <h4 class="text-white">{{ $total_customer_gigs }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-info shadow-info">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-like"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Workers Selected bid') }}</h6>
                                    <h4 class="text-white">{{ $total_worker_selected_bids }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-info shadow-info">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-dislike"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Workers Cancelled bid') }}</h6>
                                    <h4 class="text-white">{{ $total_worker_cancelled_bids }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-info shadow-info">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-eye"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Workers Pending bid') }}</h6>
                                    <h4 class="text-white">{{ $total_worker_pending_bids }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-danger shadow-danger">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-eye"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Customers Pending bid') }}</h6>
                                    <h4 class="text-white">{{ $total_customer_pending_bids }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-danger shadow-danger">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-like"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Customers Selected bid') }}</h6>
                                    <h4 class="text-white">{{ $total_customer_selected_bids }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-danger shadow-danger">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-dislike"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Customers Cancelled bid') }}</h6>
                                    <h4 class="text-white">{{ $total_customer_selected_bids }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-success shadow-success">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-layers"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Customers running gig') }}</h6>
                                    <h4 class="text-white">{{ $total_customer_running_gigs }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-success shadow-success">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-layers"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Customers complete gig') }}</h6>
                                    <h4 class="text-white">{{ $total_customer_complete_gigs }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-success shadow-success">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-layers"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Customers cancelled gig') }}</h6>
                                    <h4 class="text-white">{{ $total_customer_cancelled_gigs }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card bg-success shadow-success">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-icons-big">
                                    <span class="border-top-left-radius"></span> <i class="icon-layers"></i>
                                </div>
                                <div class="media-body text-right mt-3">
                                    <h6 class="text-uppercase text-white">{{ __('Customers active gig') }}</h6>
                                    <h4 class="text-white">{{ $total_customer_active_gigs }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--End Row-->

            <!--Start Districe, Upazila, Ads, notice Content-->
        </div>
        <!-- End container-fluid-->
    </div>
@endsection
@push('foot')
    <!-- Vector map JavaScript -->
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Sparkline JS -->
    <script src="{{ asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
    <!-- Chart js -->
    <script src="{{ asset('assets/plugins/Chart.js/Chart.min.js') }}"></script>
    <!--notification js -->
    <script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>
    <!-- Index js -->
    <script src="{{ asset('assets/js/index.js') }}"></script>
@endpush
