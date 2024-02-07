@extends('admin.layout.app')
@push('title') Dashboard @endpush
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
                                <h4 class="text-white">{{ \App\User::all()->where('role', 'customer')->count() }}</h4>
                                <span class="text-white">{{ __('Total Customer') }}</span>
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
                                <h4 class="text-white">{{ \App\User::all()->where('role', 'worker')->count() }}</h4>
                                <span class="text-white">{{ __('Total Worker') }}</span>
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
                                <h4 class="text-white">{{ \App\User::all()->where('role', 'membership')->count() }}</h4>
                                <span class="text-white">{{ __('Total Member') }}</span>
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
                                <h4 class="text-white">{{ \App\User::all()->where('role', 'controller')->count() }}</h4>
                                <span class="text-white">{{ __('Total Controller') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-user text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->
        <!--Start Districe, Upazila, Ads, notice Content-->
        <div class="row mt-4">
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-scooter">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\District::all()->count() }}</h4>
                                <span class="text-white">{{ __('Total District') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-bloody">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\Upazila::all()->count() }}</h4>
                                <span class="text-white">{{ __('Total Upazila') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-quepal">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\AdminAds::all()->count() +  \App\ControllerAds::all()->count() }}</h4>
                                <span class="text-white">{{ __('Total Ads.') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-blooker">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\AdminNotice::all()->count() +  \App\ControllerNotice::all()->count() }}</h4>
                                <span class="text-white">{{ __('Total Notice.') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->
        <!--Start Dashboard Service Category and Service Content-->
        <div class="row mt-4">
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-scooter">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\WorkerServiceCategory::all()->count() }}</h4>
                                <span class="text-white">{{ __('Total Worker Service Categories') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-bloody">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\WorkerService::all()->count() }}</h4>
                                <span class="text-white">{{ __('Total  Worker Services') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-quepal">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\MembershipServiceCategory::all()->count() }}</h4>
                                <span class="text-white">{{ __('Total Membership Service Categories') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-blooker">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\MembershipService::all()->count() }}</h4>
                                <span class="text-white">{{ __('Total Membership Service') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->
        <!--Start Job active, running, completed, cancelled, Content-->
        <div class="row mt-4">
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-scooter">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ App\CustomerBid::all()->where('status', 'active')->count() + \App\CustomerGig::all()->where('status', 'active')->count()}}</h4>
                                <span class="text-white">{{ __('Total Active Jobs') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-bloody">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ App\CustomerBid::all()->where('status', 'running')->count() + \App\CustomerGig::all()->where('status', 'running')->count()}}</h4>
                                <span class="text-white">{{ __('Total Running Jobs') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-quepal">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ App\CustomerBid::all()->where('status', 'completed')->count() + \App\CustomerGig::all()->where('status', 'completed')->count()}}</h4>
                                <span class="text-white">{{ __('Completeed Jobs') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-blooker">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ App\CustomerBid::all()->where('status', 'cancelled')->count() + \App\CustomerGig::all()->where('status', 'cancelled')->count()}}</h4>
                                <span class="text-white">{{ __('Total Cancel Jobs') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->
        <!--Start Income, Due, Referral Income, Referral Withdraw Content-->
        <div class="row mt-4">
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-scooter">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\Balance::all()->sum('job_income') }}</h4>
                                <span class="text-white">{{ __('Total Worker\'s Income') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-bloody">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\Balance::all()->sum('due') }}</h4>
                                <span class="text-white">{{ __('Total Worker\'s Due Amount') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-quepal">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\Balance::all()->sum('referral_income') }}</h4>
                                <span class="text-white">{{ __('Total Referral Income') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-6 col-xl-3">
                <div class="card gradient-blooker">
                    <div class="card-body p-4">
                        <div class="media">
                            <div class="media-body text-left">
                                <h4 class="text-white">{{ \App\Balance::all()->sum('withdrawn') }}</h4>
                                <span class="text-white">{{ __('Total Withdrawn Amount') }}</span>
                            </div>
                            <div class="align-self-center w-icon"><i class="icon-pie-chart text-white"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->
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
