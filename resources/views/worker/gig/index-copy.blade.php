@extends('worker.layout.app')
@push('title') {{ __('Gigs') }} @endpush
@push('head')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
        <div id="top_gap"></div>
        <div class="container">
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
                
            </style>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="btn-group d-flex flex-wrap align-items-center justify-content-center">
                        <button class="service_btn btn active" type="button" onclick="openService('gigs')" id="active_service">Gig</button>
                        {{-- <button class="service_btn btn" type="button" id="bid_load" onclick="openService('bids')">Bid</button> --}}
                        <button class="service_btn btn" type="button" id="service_load" onclick="openService('services')">Service</button>
                        <button class="service_btn btn" type="button" id="page_load" onclick="openService('pages')">Page</button>
                        <button class="service_btn btn" id="package_load" type="button" onclick="openService('packages')">Membership</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="service_wrap">
                    
            <div  id="gigs" class="service_item">

                <!-- Start job posting area -->
                <div class="container">
                    <div class="card shadow mt-4 h-500">
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    <form action="" id="gig-form">
                                        <div class="form-group">
                                            <input type="text" id="title" class="form-control form-control-lg" placeholder="{{ __('Title here...') }}">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control form-control-lg" id="description" rows="4" placeholder="{{ __('Gig Description...') }}"></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <select id="gig_category" class="form-control form-control-lg">
                                                        <option disabled selected>{{ __('Category') }}</option>
                                                        @foreach($categories as $category)
                                                            @php
                                                                $visible = 0;
                                                            @endphp
                                                            @foreach($category->services as $service)
                                                                @if ($service->gig_post == 1)
                                                                    @php
                                                                        $visible += 1;
                                                                    @endphp
                                                                @endif
                                                            @endforeach

                                                            @if ($visible != 0)
                                                                <optgroup label="{{ $category->name }}">
                                                                    @foreach($category->services as $service)
                                                                        @if($service->gig_post == 1)
                                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                            @endif         
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="number" id="day" class="form-control form-control-lg" placeholder="{{ __('Hours 1') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" id="tags" class="form-control form-control-lg" placeholder="{{ __('Search tags') }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="number" id="price" class="form-control form-control-lg" placeholder="{{ __('Price') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            {{-- <div class="col">
                                                <div class="form-group">
                                                    <input type="file" id="cover_photo" class="form-control form-control-lg" placeholder="{{ __('Cover Photo') }}">
                                                </div>
                                            </div> --}}
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="file" id="thambline_photo" class="form-control form-control-lg" placeholder="{{ __('Thambline Photo') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <button type="button" id="gig-submit-button" class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('Post Gig') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End job posting area -->
                <hr>

                <!-- Start My Gigs -->
                <div class="container my-gig" id="">
                    @foreach(auth()->user()->workerGigs as $gig)
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="font-weight-normal mb-1"><b>{{ $gig->title }}</b></h5>
                                        <div class="row text-center">
                                            <div class="col-3 text-center color-border">
                                                <p class="text text-success mb-2">{{ __('Created') }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($gig->created_at)) }}</p>
                                            </div>
                                            <div class="col-3 text-center color-border">
                                                <p class="text text-success mb-2">{{ $gig->customerBids->where('status', '!=', 'cancelled')->count() }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ __('Orders') }}</p>
                                            </div>
                                            <div class="col-3 text-center color-border">
                                                <p class="text text-success mb-2">{{ $gig->click }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ __('Click') }}</p>
                                            </div>
                                            <div class="col-3 text-center">
                                                <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showWorkerGig', \Illuminate\Support\Facades\Crypt::encryptString($gig->id)) }}'">
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
                <!-- End My Gigs -->
        
            </div>


           


            <div  id="services" class="service_item">
                <!-- Start My page service -->
                <div class="create-service">
                    <!-- page service post start-->
                    <div class="container">
                        <div class="card shadow mt-4 h-500">
                            <div class="card-body">
                                <div class="row">
                                    <div class="container">
                                        <form action="" id="gig-form" >
                                            <div class="form-group">
                                                <input type="text" id="service_title" class="form-control form-control-lg" placeholder="{{ __('Service Title here...') }}">
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control form-control-lg" id="service_description" rows="4" placeholder="{{ __('Service Description...') }}"></textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input type="number" id="service_day" class="form-control form-control-lg" placeholder="{{ __('Hours 1') }}">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input type="text" id="service_tags" class="form-control form-control-lg" placeholder="{{ __('Search tags') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input type="number" id="service_price" class="form-control form-control-lg" placeholder="{{ __('Price') }}">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input type="file" id="service_photo" class="form-control form-control-lg" placeholder="{{ __('Thambline Photo') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <button type="button" id="service-submit-button" class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('Create Service') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- page service post end -->
                </div>
                <!-- End My page service -->
                <hr>

                <!-- Start My page service -->
                <div class="container my-service">
                    @foreach(auth()->user()->pageServices as $service)
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="font-weight-normal mb-1"><b>{{ $service->title }}</b></h5>
                                        <div class="row text-center">
                                            <div class="col-5 text-center color-border">
                                                <p class="text text-success mb-2">{{ __('Created') }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($service->created_at)) }}</p>
                                            </div>
                                            <div class="col-3 text-center color-border">
                                                {{-- <p class="text text-success mb-2">{{ App\ServiceBid::where('worker_service_id', $service->id)->where('status', '!=', 'cancelled')->count() }}</p> --}}
                                                <p class="text-mute small text-secondary mb-2">{{ App\ServiceBid::where('worker_service_id', $service->id)->where('status', '!=', 'cancelled')->count() }} {{ __('Orders') }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ $service->click }}</p>
                                            </div>
                                            <div class="col-3 text-center">
                                                <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showWorkerService', \Illuminate\Support\Facades\Crypt::encryptString($service->id)) }}'">
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
                <!-- End My page service -->

            </div>

            <div id="pages" class="service_item" style="display: none">
                <!-- Start page posting area -->
                <div class="container">
                    <div class="card shadow mt-4 h-500">
                        
                        @if (auth()->user()->membership)
                            @if (!App\WorkerPage::where('worker_id', auth()->user()->id)->exists())
                            <div class="card-body">
                                <div class="row">
                                    <div class="container">
                                        <form action="" id="page-form" enctype="multipart/form-data">
                                            <input type="hidden" name="page_package_id" id="page_package_id" value="{{ auth()->user()->membership->membership_package_id }}">
                                            <div class="form-group">
                                                <input type="text" name="name" id="page_name" class="form-control form-control-lg" placeholder="{{ __('Page Name here...') }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="title" id="page_title" class="form-control form-control-lg" placeholder="{{ __('Page title here...') }}">
                                            </div>
                                            @if (auth()->user()->membership->membershipPackage->description_availability == 1)
                                            <div class="form-group">
                                                <textarea class="form-control form-control-lg" id="page_description" name="description" rows="4" placeholder="{{ __('page Description...') }}"></textarea>
                                            </div>
                                            @endif
                                            @if (auth()->user()->membership->membershipPackage->description_availability == 1)
                                            <div class="form-group">
                                                <textarea class="form-control form-control-lg" id="page_address" name="address" rows="1" placeholder="{{ __('Your Address') }}"></textarea>
                                            </div>
                                            @endif

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select id="page_service" name="service[]" class="form-control form-control-lg" style="width: 100%" multiple = "multiple">
                                                            {{-- @if (auth()->user()->membership->count() != 0) --}}
                                                                @foreach($categories as $category)
                                                                    @php
                                                                        $visible = 0;
                                                                    @endphp

                                                                    @foreach($category->services as $service)
                                                                        @foreach (Str::of(auth()->user()->membership->sub_categories)->explode(',') as $service_id)
                                                                            @if ($service_id)
                                                                                @if ($service->id == $service_id)
                                                                                    @php
                                                                                        $visible += 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach

                                                                    @if ($visible != 0)
                                                                        <optgroup label="{{ $category->name }}">
                                                                            @foreach($category->services as $service)
                                                                                @foreach (Str::of(auth()->user()->membership->sub_categories)->explode(',') as $service_id)
                                                                                    @if ($service_id)
                                                                                        @if ($service->id == $service_id)
                                                                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        </optgroup>
                                                                    @endif
                                                                    {{-- <optgroup label="{{ $category->name }}">
                                                                        @foreach($category->services as $service)
                                                                            @foreach (Str::of(auth()->user()->membership->sub_categories)->explode(',') as $service_id)
                                                                                @if ($service_id)
                                                                                    @if ($service->id == $service_id)
                                                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                    </optgroup> --}}
                                                                @endforeach
                                                            {{-- @endif --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select id="worker_service" name="worker_service[]" class="form-control form-control-lg" style="width: 100%" multiple = "multiple">
                                                            {{-- <option disabled>Select your services to show in page</option> --}}
                                                            @foreach($your_services as $service)
                                                                <option value="{{ $service->id }}">{{ $service->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                @if (auth()->user()->membership->membershipPackage->mobile_availability == 1)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" id="page_phone" name="phone" class="form-control form-control-lg" placeholder="{{ __('Phone Number') }}">
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="file" id="page_image"  class="form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" id="page_location" class="form-control form-control-lg" placeholder="Your google map link" value="">
                                                    </div>
                                                </div>
                                                <div class="col-6 m-auto">
                                                    <div class="form-group">
                                                        <button type="button" id="page-submit-button" class="mb-2 btn btn-lg btn-success w-100 btn-rounded">{{ __('Create Page') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            @else 
                                <div class="card-body mt-3">
                                    @if(auth()->user()->membership && !auth()->user()->membershipActive)
                                        <div class="alert alert-danger">Your Membership is Expired For Page please update your package! </div>
                                    @else
                                        <div class="alert alert-success">Your Membership is Running For Page </div>
                                    @endif
                                </div>
                            @endif
                        @else 
                        <div class="card-body mt-3">
                            <div class="alert alert-danger">Please Buy a Membership Package to create or see pages</div>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- End page posting area -->
                <hr>
                <!-- Start My Pages -->
                @if (auth()->user()->membership)
                    @foreach(auth()->user()->workerPages as $page)
                    <div class="container cancelled-bid-job" id="">
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="font-weight-normal mb-1"><b>{{ $page->name }}</b></h5>
                                        <div class="row text-center">
                                            <div class="col-5 text-center color-border">
                                                <p class="text text-success mb-2">{{ __('Created') }}</p>
                                                <p class="text-mute small text-secondary mb-2">{{ date('h:i a d/m/y', strtotime($page->created_at)) }}</p>
                                            </div>
                                            <div class="col-3 text-center color-border">
                                                {{-- <p class="text text-success mb-2">{{ $page->customerBids->where('status', '!=', 'cancelled')->count() }}</p> --}}
                                                @if(auth()->user()->membership && !auth()->user()->membershipActive)
                                                    <p class="text-mute small text-secondary mb-2">Inactive</p>
                                                @else
                                                    <p class="text-mute small text-secondary mb-2">{{ ($page->status == 1) ? "Active": "Page is Under Review" }}</p>
                                                @endif
                                                <p class="text-mute small text-secondary mb-2">{{ $page->click }} clicks</p>
                                            </div>
                                            <div class="col-3 text-center">
                                                <button type="button" class="mb-2 btn btn-lg btn-success view-btn" onclick="window.location.href='{{ route('worker.showWorkerPage', \Illuminate\Support\Facades\Crypt::encryptString($page->id)) }}'">
                                                    <i class="material-icons">visibility</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
                <!-- End My Pages -->
            </div>

            <div id="packages" class="service_item" style="display: none">
                <div class="pt-4">
                    @if (session('success_buy_package'))
                        <div class="alert alert-success" id="alert_success">
                            <div class="container">
                                {{ session('success_buy_package') }}
                            </div>
                        </div>
                    @endif
                    @if (session('success_update_package'))
                        <div class="alert alert-success" id="alert_success">
                            <div class="container">
                                {{ session('success_update_package') }}
                            </div>
                        </div>
                    @endif
                    @if (session('danger_update_package'))
                        <div class="alert alert-danger" id="alert_danger">
                            <div class="container">
                                {{ session('danger_update_package') }}
                            </div>
                        </div>
                    @endif

                    @if(!auth()->user()->membership)
                        <!-- Start title -->

                        <div class="">
                            <div class="alert alert-info text-center" role="alert">
                                <b id=""> {{ __('MEMBERSHIP PACKAGES') }} </b>
                            </div>
                        </div>
                        <!-- End title -->
                        <div class="container">
                            @foreach($packages as $package)
                                <div class="alert alert-dark shadow-dark" role="alert">
                                    <h4 class="alert-heading name">{{ $package->name }}</h4>
                                    <div class="row text-center">
                                        {{-- <div class="col-12 bg-warning "><b class="monthly_price">{{ $package->monthly_price }} ৳</b>/ <br> {{__('Monthly Price')}}</div> --}}
                                        <div class="col-6 bg-warning py-1"><b class="monthly_price">{{ $package->monthly_price }} ৳</b>/ <br> {{__('Monthly Price')}}</div>
                                        <div class="col-6 bg-danger py-1"><b class="extendable_price">{{ $package->extendable_price }} ৳</b>/ <br> {{__('Price per extra category')}}</div>
                                        <input type="hidden" class="monthly_price" value="{{ $package->monthly_price }} ৳">
                                    </div>
                                    <hr>
                                    <div class="row package-detail">
                                        <div class="col-8"><span style="padding: 2px 0 2px 0">{{ __('Monthly Price') }}</span></div>
                                        <div class="col-4"><span class="badge m-1" style="border: 1px solid green">{{ __($package->monthly_price) }}</span></div>

                                        <div class="col-8"><span style="padding: 2px 0 2px 0">{{ __('Extra Price Per Category') }}</span></div>
                                        <div class="col-4"><span class="badge m-1" style="border: 1px solid green">{{ __($package->extendable_price) }}</span></div>

                                        <div class="col-8"><span style="padding: 2px 0 2px 0">{{ __('Maximum Services') }}</span></div>
                                        <div class="col-4"><span class="badge m-1" style="border: 1px solid green">{{ $package->service_count }}</span></div>

                                        <div class="col-8"><span style="padding: 2px 0 2px 0">{{ __('Rank') }}</span></div>
                                        <div class="col-4"><span class="badge m-1" style="border: 1px solid green">{{ $package->position }}</span></div>

                                        <div class="col-8"><span style="padding: 2px 0 2px 0">{{ __('Phone Number') }}</span></div>
                                        <div class="col-4">
                                            @if($package->mobile_availability == 1)
                                                <span class="badge m-1" style="border: 1px solid green">{{ __('Yes') }}</span>
                                            @else
                                                <span class="badge m-1" style="border: 1px solid red">{{ __('No') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-8"><span style="padding: 2px 0 2px 0">{{ __('Description') }}</span></div>
                                        <div class="col-4">
                                            @if($package->description_availability == 1)
                                            <span class="badge m-1" style="border: 1px solid green">{{ __('Yes') }}</span>
                                            @else
                                            <span class="badge m-1" style="border: 1px solid red">{{ __('No') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-8"><span style="padding: 2px 0 2px 0">{{ __('Categories') }}</span></div>
                                        <div class="col-4">
                                            <button class="badge badge-success shadow-success m-1 view_category btn py-1" style="font-size: 11px;" value="{{ $package->id }}">{{ __('View') }}</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="mb-0 text-center">
                                        <button type="button" value="{{ $package->id }}" class="mb-2 btn btn-sm btn-success select-package-btn">{{ __('SELECT') }}</button>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Start title -->
                        <div class="text-center">
                            @if(auth()->user()->membership && !auth()->user()->membershipActive)
                                <div class="alert alert-danger">Your Membership is Expired For Page please update your package! </div>
                            @else
                                <div class="alert alert-success">Your Membership is Running For Page </div>
                            @endif
                        </div>
                        <div class="">
                            <div class="alert alert-info text-center" role="alert">
                                <b id=""> {{ __('My PACKAGE : '.auth()->user()->membership->membershipPackage->name) }} </b>
                            </div>
                            <div class="container">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center active">
                                        {{ __('Mobile number') }}
                                        @if(auth()->user()->membership->membershipPackage->mobile_availability == 1)
                                            <span class="badge badge-success shadow-success m-1">{{ __('Yes') }}</span>
                                        @else
                                            <span class="badge badge-danger shadow-danger m-1">{{ __('No') }}</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ __('Description') }}
                                        @if(auth()->user()->membership->membershipPackage->description_availability == 1)
                                            <span class="badge badge-success shadow-success m-1">{{ __('Yes') }}</span>
                                        @else
                                            <span class="badge badge-danger shadow-danger m-1">{{ __('No') }}</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ __('Maximum Services') }}
                                        <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->membershipPackage->service_count }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End title -->
                        {{--End my package--}}
                        {{--Start duration--}}
                        <br>
                        <br>
                        <br>
                        <div class="">
                            <div class="alert alert-danger text-center" role="alert">
                                <b id=""> {{ __('Duration') }} </b>
                            </div>
                            <div class="container">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center active">
                                        {{ __('Status') }}
                                        @if(Carbon\Carbon::now()->diffInDays(auth()->user()->membership->ending_at) > 0)
                                            <span class="badge badge-success shadow-success m-1">Running</span>
                                        @else
                                            <span class="badge badge-success shadow-success m-1">Complete</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ __('Duration') }}
                                        @if (auth()->user()->membership->payment_status == 'trial')
                                        <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->created_at->diffInDays(auth()->user()->membership->ending_at) }} Days</span>
                                        @else 
                                        <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->duration }} months</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ __('Start') }}
                                        <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->created_at->format('d/m/Y') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ __('Renew') }}
                                        <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->updated_at->format('d/m/Y') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ __('Ending Date') }}
                                        <span class="badge badge-success shadow-success m-1">{{  date('d/m/Y', strtotime(auth()->user()->membership->ending_at)) }}</span>
                                    </li>
                                </ul>
                                <div class="d-flex mt-3 mb-3">
                                    @if (auth()->user()->membership->payment_status != 'trial')
                                    <button type="button" class="btn btn-success w-50 mr-1" id="update_package_btn">Update Package</button>
                                    @else 
                                    <button type="button" class="btn btn-info w-50" id="buy_package_btn">Buy Package</button>
                                    @endif
                                    <button type="button" class="btn btn-default  w-50 ml-1" id="change_package_btn">Change Package</button>
                                </div>
                                <div id="update_package">
                                    <form action="{{ route('worker.updateMembership') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="membership_id" id="membership_id" value="{{ Crypt::encryptString(auth()->user()->membership->id)  }}">
                                        <div class="form-group">
                                            <label for="">Months</label>
                                            <select name="duration" class="form-control  text-center" id="update_duration">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}"
                                                        @if (auth()->user()->membership->duration == $i)
                                                            {{ "selected" }}
                                                        @else 
                                                            {{ "" }}
                                                        @endif
                                                    >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Services</label>
                                            <select id="update_service" name="sub_categories[]" class="form-control  form-control-lg" multiple="multiple" style="width: 100%" data-mdb-filter="true">
                                                @foreach($categories as $category)
                                                    <optgroup label="{{ $category->name }}">
                                                        @foreach($category->services as $service)
                                                            @foreach (Str::of(App\MembershipPackage::withTrashed()->find(auth()->user()->membership->membership_package_id)->sub_categories)->explode(',') as $service_id)
                                                                    @if ($service->id == $service_id)
                                                                        <option value="{{ $service->id }}"
                                                                        @foreach (Str::of(auth()->user()->membership->sub_categories)->explode(',') as $package_servce_id)
                                                                            @if ($service_id == $package_servce_id)
                                                                                {{ "selected" }}
                                                                            @else 
                                                                                {{ "" }}
                                                                            @endif
                                                                        @endforeach
                                                                        >{{ $service->name }}</option>
                                                                    @endif
                                                            @endforeach
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="update_total_amount"></div>
                                        <button type="submit" class="btn btn-sm btn-info mt-3">Update Package</button>
                                    </form>
                                </div>
                                <div id="buy_package">
                                    <form action="{{ route('worker.buyMembership') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="membership_id" id="membership_id" value="{{ Crypt::encryptString(auth()->user()->membership->id)  }}">
                                        <div class="form-group">
                                            <label for="">Months</label>
                                            <select name="duration" class="form-control  text-center" id="update_duration">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}"
                                                        @if (auth()->user()->membership->duration == $i)
                                                            {{ "selected" }}
                                                        @else 
                                                            {{ "" }}
                                                        @endif
                                                    >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div id="update_total_amount"></div>
                                        <button type="submit" class="btn btn-sm btn-info mt-3">Buy</button>
                                    </form>
                                </div>
                                <div id="change_package">
                                    <form action="{{ route('worker.changeMembership')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="membership_id" id="membership_id" value="{{ Crypt::encryptString(auth()->user()->membership->id)  }}">
                                        <div class="form-group">
                                            <label for="">Package</label>
                                            <select name="package_id" class="form-control change_package_id text-center" id="change_package_id">
                                               @foreach(App\MembershipPackage::all() as $row)
                                                    <option value="{{$row->id}}"
                                                        @if (auth()->user()->membership->membership_package_id == $row->id)
                                                            {{ "selected" }}
                                                        @else 
                                                            {{ "" }}
                                                        @endif
                                                    >{{$row->name}}</option>
                                               @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Months</label>
                                            <select name="duration" class="form-control  text-center" id="change_duration">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}"
                                                        @if (auth()->user()->membership->duration == $i)
                                                            {{ "selected" }}
                                                        @else 
                                                            {{ "" }}
                                                        @endif
                                                    >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Services</label>
                                            <select id="change_service" name="sub_categories[]" class="form-control form-control-lg multiselect" multiple="multiple" style="width: 100%" data-mdb-filter="true">
                                                @foreach($categories as $category)
                                                    <optgroup label="{{ $category->name }}">
                                                        @foreach($category->services as $service)
                                                            @foreach (Str::of(App\MembershipPackage::withTrashed()->find(auth()->user()->membership->membership_package_id)->sub_categories)->explode(',') as $service_id)
                                                                    @if ($service->id == $service_id)
                                                                        <option value="{{ $service->id }}"
                                                                        @foreach (Str::of(auth()->user()->membership->sub_categories)->explode(',') as $package_servce_id)
                                                                            @if ($service_id == $package_servce_id)
                                                                                {{ "selected" }}
                                                                            @else 
                                                                                {{ "" }}
                                                                            @endif
                                                                        @endforeach
                                                                        >{{ $service->name }}</option>
                                                                    @endif
                                                            @endforeach
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="change_total_amount"></div>
                                        <button type="submit" class="btn btn-sm btn-info mt-3">Change</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{--End duration--}}
                        {{--Start Change Package--}}
                        <br>
                        <br>
                        <br>
                        {{-- <div class="">
                            <div class="alert alert-warning text-center" role="alert">
                                <b id=""> {{ __('Change Package') }} </b>
                            </div>
                            <div class="container">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center active">
                                        {{ __('Duration') }}
                                        <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->duration }} {{ __('months') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ __('Start/Renew') }}
                                        <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->created_at->format('d/m/Y') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ __('Ending Date') }}
                                        <span class="badge badge-success shadow-success m-1">{{  date('d/m/Y', strtotime(auth()->user()->membership->ending_at)) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
                        {{--End Change Package--}}
                        <!-- Start admin notice box -->
                       {{--  @foreach($adminNotice as $adminNotice)
                            <section class="jumbotron  mt-1 bg-white shadow-sm">
                                <div class="container">
                                    <p class="lead">{{ $adminNotice->title }}</p>
                                    <div>
                                        {!! $adminNotice->detail !!}
                                    </div>
                                </div>
                            </section>
                        @endforeach --}}
                        <!-- End admin notice box -->
                        <!-- Start controller notice box -->
                        {{-- @foreach(auth()->user()->upazila->controllers as $controller)
                            @foreach($controller->controllerNotice as $controllerNotice)
                                <section class="jumbotron mt-1 bg-white shadow-sm">
                                    <div class="container">
                                        <div class="container">
                                            <p class="lead">{{ $controllerNotice->title }}</p>
                                            <div>
                                                {!! $controllerNotice->detail !!}
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @endforeach
                        @endforeach --}}
                        <!-- Start top ads. by controller this upazila -->
                        {{-- <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
                            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                @foreach(auth()->user()->upazila->controllers as $controller)
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
                        </div> --}}
                        <!-- End top ads.  by controller this upazila -->
                        {{-- <hr> --}}
                        <!-- Start middle ads. by admin for all-->
                       {{--  <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
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
                        </div> --}}
                        <!-- End middle ads. by admin for all-->
                    @endif
                </div>
            </div>

        </div>

    {{-- gigs script start  --}}
    <script>
        $(document).ready(function() {
            //Submit new Job
            $('#gig-submit-button').click(function(){
                var formData = new FormData();
                formData.append('title', $('#title').val())
                formData.append('description', $('#description').val())
                formData.append('service', $('#gig_category').val())
                formData.append('day', $('#day').val())
                formData.append('tags', $('#tags').val())
                formData.append('price', $('#price').val())
                // formData.append('cover_photo', $('#cover_photo')[0].files[0])
                formData.append('thambline_photo', $('#thambline_photo')[0].files[0])
                $.ajax({
                    method: 'POST',
                    url: "{{ route('worker.gig.store') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#title').val('');
                        $('#description').val('');
                        $('#tags').val('');
                        $('#gig_category').val('');
                        $('#day').val('');
                        $('#price').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully add new gig.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
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

            $('.note-btn').click(function(){
                $('.note-modal-backdrop').css("z-index", "0");
            });
        });
    </script>
    <script>
        $('#description').summernote({
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['fontname', ['fontname']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link',  'video']],
            ],
            placeholder: 'Description',
            tabsize: 2,
            height: 120,
            
        });
    </script>
    

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
    {{-- gigs script end  --}}

    {{-- services script start  --}}
    <script>

        $(document).ready(function() {
            //Submit new Job
            $('#service-submit-button').click(function(){
                var balance = {{ App\User::worker_bid_gig_limit(auth()->user()->id) }}
                if(Number($('#service_price').val()) <= Number(balance)) {
                    var formData = new FormData();
                    formData.append('title', $('#service_title').val())
                    formData.append('description', $('#service_description').val())
                    // formData.append('service', $('#service_category').val())
                    formData.append('day', $('#service_day').val())
                    formData.append('tags', $('#service_tags').val())
                    formData.append('price', $('#service_price').val())
                    formData.append('thambline_photo', $('#service_photo')[0].files[0])
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('worker.service.store') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#service_title').val('');
                            $('#service_description').val('');
                            $('#service_tags').val('');
                            // $('#service_category').val('');
                            $('#service_day').val('');
                            $('#pservice_rice').val('');
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Successfully added new service.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
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
                }else{
                    $('#rechargeModalforBid').modal('show');
                }
            });

        });
    </script>
    <script>
        $('#service_description').summernote({
            placeholder: 'Description',
            tabsize: 2,
            height: 120,
            toolbar: [

            ]
        });
    </script>
    {{-- services script end  --}}

    {{-- page script start  --}}
    <script>
        $(document).ready(function (){

            $("#page_service").select2({
                placeholder: "Services Where Page Will Show",
                allowClear: true,
            });



            $("#worker_service").select2({
                placeholder: "Select Your Services to Show in Page",
                allowClear: true,
                @if(auth()->user()->membership)
                    maximumSelectionLength: {{ App\MembershipPackage::withTrashed()->find(auth()->user()->membership->membership_package_id)->service_count }}
                @endif
            });

            $("#location_source").keyup(function(){
                var location_source = $('#location_source').val();
                var location = $($(location_source)).filter('iframe').attr('src');
                $("#page_location").attr("value", location);
            });
            
            // $('#worker_service').select2();

            $('#page-submit-button').click(function(){
                var formData = new FormData();
                formData.append('package_id', $('#page_package_id').val())
                formData.append('name', $('#page_name').val())
                formData.append('title', $('#page_title').val())
                formData.append('description', $('#page_description').val())
                formData.append('address', $('#page_address').val())
                formData.append('service', $('#page_service').val())
                formData.append('phone', $('#page_phone').val())
                formData.append('image', $('#page_image')[0].files[0])
                formData.append('worker_service', $('#worker_service').val())
                formData.append('location', $('#page_location').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('worker.workerpagestore') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        // $('#page_package_id').val('');
                        $('#page_title').val('');
                        $('#page_description').val('');
                        $('#page_address').val('');
                        $('#page_service').val('');
                        $('#page_phone').val('');
                        $('#page_image').val('');
                        $('#worker_service').val('');
                        $('#page_location').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully add new Page.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1000); //1 second
                        $("#page_load").trigger("click");
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

            $("#page_edit_form").hide();
            $('#edit_page').click(function(){
                $("#page_edit_form").show();
                $("#show_page").hide();
            });
            $('#cancel_page_edit').click(function(){
                $("#page_edit_form").hide();
                $("#show_page").show();
            });
            $("#edit_page_service").select2({
                placeholder: "Select Service",
                allowClear: true,
            });

            // $('#edit_page-submit-button').click(function(){
            //     var formData = new FormData();
            //     formData.append('page_package_id', $('#edit_page_package_id').val())
            //     formData.append('page_id', $('#edit_page_id').val())
            //     formData.append('title', $('#edit_page_title').val())
            //     formData.append('description', $('#edit_page_description').val())
            //     formData.append('address', $('#edit_page_address').val())
            //     formData.append('service[]', $('#edit_page_service').val())
            //     formData.append('phone', $('#edit_page_phone').val())
            //     formData.append('page_images', $('#edit_page_images').val())
            //     $.ajax({
            //         method: 'POST',
            //         url: "{{ route('worker.workerpageupdate') }}",
            //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //         data: formData,
            //         processData: false,
            //         contentType: false,
            //         success: function (data) {
            //             $('#edit_page_package_id').val('');
            //             $('#edit_page_id').val('');
            //             $('#edit_page_title').val('');
            //             $('#edit_page_description').val('');
            //             $('#edit_page_address').val('');
            //             $('#edit_page_service').val('');
            //             $('#edit_page_phone').val('');
            //             $('#edit_page_images').val('');
            //             Swal.fire({
            //                 position: 'top-end',
            //                 icon: 'success',
            //                 title: 'Successfully add new gig.',
            //                 showConfirmButton: false,
            //                 timer: 1500
            //             })
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 1000); //1 second
            //             $("#page_load").trigger("click");
            //         },
            //         error: function (xhr) {
            //             var errorMessage = '<div class="card bg-danger">\n' +
            //                 '                        <div class="card-body text-center p-5">\n' +
            //                 '                            <span class="text-white">';
            //             $.each(xhr.responseJSON.errors, function(key,value) {
            //                 errorMessage +=(''+value+'<br>');
            //             });
            //             errorMessage +='</span>\n' +
            //                 '                        </div>\n' +
            //                 '                    </div>';
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: 'Oops...',
            //                 footer: errorMessage
            //             })
            //         },
            //     })
            // });

        });
    </script>
    <script>
        $('#page_description').summernote({
            placeholder: 'Page Description',
            tabsize: 2,
            height: 120,
            toolbar: [

            ]
        });
    </script>
    {{-- page script end  --}}

    {{-- packages script start  --}}
    <script>
        $(document).ready(function (){
            $('.view_category').click(function (){
                $("#package-modal").modal('hide');
                var package_id = $(this).val();
                // alert(package_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: "{{ route('worker.ViewMembershipPackageCategories') }}",
                    data: {package_id:package_id},
                    success: function(data){
                        // alert(data);
                        $('#view_service').html(data);
                    }
                });
            });

            $('.select-package-btn').click(function (){
                $('.package_name_modal').html($(this).parent().parent().find('.name').text())
                $('.package-detail-modal').html($(this).parent().parent().find('.package-detail').html())
                $('#total_amount_modal').html("<small class='text-danger'>Please Select Service</small>")
                // $('.three_month_modal').html($(this).parent().parent().find('.three_month_price').html())
                // $('.six_month_modal').html($(this).parent().parent().find('.six_month_price').val())
                // $('.twelve_month_modal').html($(this).parent().parent().find('.twelve_month_price').html())
                $('#hidden_package_id_modal').val($(this).val())

                // load categories with ajax on click 
                var package_id = $(this).val();
                // alert(package_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: "{{ route('worker.MembershipPackageCategories') }}",
                    data: {package_id:package_id},
                    success: function(data){
                        // alert(data);
                        $('#service').html(data);
                    }
                });
            });

            $("#service").select2({
                placeholder: "Select Service",
                allowClear: true,
            });

            $("#update_service").select2({
                placeholder: "Select Service",
                allowClear: true,
            });

            $("#change_service").select2({
                placeholder: "Select Service",
                allowClear: true,
            });

            $("#service").change(function(){
                // load categories with ajax on click 
                var sub_category_id = $(this).val();
                var duration = $("#duration").val();
                var package_id = $("#hidden_package_id_modal").val();
                // alert(package_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: "{{ route('worker.MembershipPackageAmount') }}",
                    data: {sub_category_id:sub_category_id, duration:duration, package_id:package_id},
                    success: function(data){
                        // alert(data);
                        $('#total_amount_modal').html(data);
                        // $('#update_total_amount').html(data);
                    }
                });
            });

            $('.change_package_id').change(function(){
                var package = $(this).val();
                if(package) {
                    $.ajax({
                        url: "{{  url('/worker/package/service/') }}/"+package,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            var d =$('#change_service').empty();
                            setTimeout(function() {
                                $('#change_service').html(data);
                                $("#change_service").select2({
                                    placeholder: "Select Service",
                                    allowClear: true,
                                });
                            }, 1000);
                        },
                    });
                } else {
                    alert('danger');
                }
            });

            $("#duration").change(function(){
                // load categories with ajax on click 
                var sub_category_id = $("#service").val();
                var duration = $(this).val();
                var package_id = $("#hidden_package_id_modal").val();
                // alert(sub_category_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: "{{ route('worker.MembershipPackageAmount') }}",
                    data: {sub_category_id:sub_category_id, duration:duration, package_id:package_id},
                    success: function(data){
                        // alert(data);
                        $('#total_amount_modal').html(data);
                    }
                });
            });

            $("#update_package").hide();
            $("#update_package_btn").click(function(){
                $("#update_package").toggle();
                $("#change_package").hide();
            });

            $("#buy_package").hide();
            $("#buy_package_btn").click(function(){
                $("#buy_package_btn").toggle();
            });

            $("#change_package").hide();
            $("#change_package_btn").click(function(){
                $("#change_package").toggle();
                $("#update_package").hide();
            });

            $("#update_duration").change(function(){
                // load categories with ajax on click 
                var duration = $(this).val();
                var services_id = $("#update_service").val();
                var membership_id = $("#membership_id").val();
                // alert(duration);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: "{{ route('worker.MembershipPackageAmountUpdate') }}",
                    data: {duration:duration, membership_id:membership_id, services_id:services_id},
                    success: function(data){
                        // alert(data);
                        $('#update_total_amount').html(data);
                    }
                });
            });


            $("#update_service").change(function(){
                // load categories with ajax on click 
                var duration = $("#update_duration").val();
                var services_id = $(this).val();
                var membership_id = $("#membership_id").val();
                // alert(duration);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: "{{ route('worker.MembershipPackageAmountUpdate') }}",
                    data: {duration:duration, membership_id:membership_id, services_id:services_id},
                    success: function(data){
                        // alert(data);
                        $('#update_total_amount').html(data);
                    }
                });
            });


            $("#change_service, #change_package_id, #change_duration").change(function(){
                // load categories with ajax on click 
                var duration = $("#change_duration").val();
                var services_id = $('#change_service').val();
                var membership_id = $("#membership_id").val();
                var change_package_id = $("#change_package_id").val();
                // alert(duration);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: "{{ route('worker.MembershipPackageAmountChange') }}",
                    data: {duration:duration, membership_id:membership_id, services_id:services_id,change_package_id:change_package_id},
                    success: function(data){
                        // alert(data);
                        $('#change_total_amount').html(data);
                    }
                });
            });


        });
    </script>
    <script>
        if ("{{ session('success_buy_package') }}") {
            $("#package_load").trigger("click");
        }
        if ("{{ session('success_update_package') }}") {
            $("#package_load").trigger("click");
        }
        if ("{{ session('danger_update_package') }}") {
            $("#package_load").trigger("click");
        }
        if ("{{ session('page_click') }}") {
            $("#page_load").trigger("click");
        }
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
    {{ Session::forget('page_click') }}
    {{ Session::forget('service_click') }}
    {{ Session::forget('pending_service_click') }}
    {{ Session::forget('cancelled_service_click') }}
    {{ Session::forget('running_service_click') }}
    {{ Session::forget('completed_service_click') }}
@endsection
