@extends('marketer.layout.app')
@push('title') {{ __('Home') }} @endpush
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ asset('assets/owlcarousel/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/owlcarousel/assets/owl.theme.default.min.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="{{ asset('assets/owlcarousel/owl.carousel.js') }}"></script>
@endpush
@section('content')

<!-- Start title -->
<div>
    <div class="alert alert-success text-center" role="alert">

    </div>
</div>
<!-- End title -->

@php $isAdsAndNoticeShow = ""; $isCategoryShow = ""; $loopCount = 0; @endphp
<!--If job offer smaller than 5 show notice and top ads. as last -->
@if($isAdsAndNoticeShow!='yes')
<!-- Start admin notice box -->
@foreach($adminNotice as $adminNotice)
<section class="jumbotron  mt-1 bg-white shadow-sm">
    <div class="container">
        <p class="lead">{{ $adminNotice->title }}</p>
        <div>
            {!! $adminNotice->detail !!}
        </div>
    </div>
</section>
@endforeach
<!-- End admin notice box -->

<!-- Start top ads. by controller this upazila -->
<div class="swiper-container ">
    <div class="swiper-wrapper">
        <div class="owl-carousel owl-theme topOwl">
            @foreach($adminAds as $controllerAds)
            <div class="item">
                <div class="swiper-slide ">
                    <div class="card">
                        <div class="card-body">
                            <a @if($controllerAds->url) href="{{ $controllerAds->url }}" target="_blank" @endif >
                                <img src="{{ asset($controllerAds->image) }}" height="100%" width="100%"
                                    style="border-radius: 5px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
</div>
<!-- End top ads.  by controller this upazila -->
<!-- Start worker service category -->
<div>
    <div class="alert alert-info text-center" role="alert">
        <span>Promote by Gig's</span>
    </div>
</div>
<div class="container">
    <div class="row text-center mt-4">
        @foreach($categories as $category)
        <div class="col-6 col-md-3">
            <div class="card shadow border-0 mb-3">
                <div class="card-body">
                    <div class="avatar avatar-60 no-shadow border-0">
                        <div class="overlay"></div>
                        <img src="{{ asset('uploads/images/worker/service-category/'.$category->icon) }}" height="50px"
                            width="50px" style="border-radius: 15px;">
                    </div>
                    <a
                        href="{{ route('marketer.showServices',\Illuminate\Support\Facades\Crypt::encryptString($category->id)) }}">
                        <p class="mt-3 mb-0 font-weight-bold">{{ $category->name }}</p>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- End worker service category -->
@endif

<hr>
<!--If job offer smaller than 10 show category & bottom ads. as last -->

<!-- End title -->
<!-- Start marketer balance option -->
<div class="container">
    <div class="row text-center mt-4">
        <div class="col-6 col-md-3">
            <div class="card shadow border border-info mb-3">
                <div class="card-body">
                    <div class="font-weight-bold">

                        {{ __('Current Balance') }}

                    </div>
                    <p class="mt-2 mb-0 font-weight-bold">{{ __($currentBalance) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-center mt-4">
        <div class="col-6 col-md-3">
            <div class="card shadow border border-primary mb-3">
                <div class="card-body">
                    <div class="font-weight-bold">

                        {{ __('Total Income') }}

                    </div>
                    <p class="mt-2 mb-0 font-weight-bold">{{ __($totalIncome) }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow border border-success mb-3">
                <div class="card-body">
                    <div class="font-weight-bold">
                        {{date('F')}} {{ __('Total Income') }}

                    </div>
                    <p class="mt-2 mb-0 font-weight-bold">{{ __($TotalCurrentMonthIncome) }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow border border-danger   mb-3 ">
                <div class="card-body">
                    <div class="font-weight-bold">
                        {{ __('Withdraw') }}
                    </div>
                    <p class="mt-2 mb-0 font-weight-bold">{{ __($totalWidraw) }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow border border-warning mb-3 ">
                <div class="card-body">
                    <div class="font-weight-bold">
                        {{ __('Pending') }}
                    </div>
                    <p class="mt-2 mb-0 font-weight-bold">{{ __($totalWidrawPainding) }}</p>
                </div>
            </div>
        </div>
        <div class="col-1 col-md-3"></div>
        <div class="col-5 col-md-3">
            <div>
                <i class="fa fa-dollar"></i>
            </div>
            <a href="{{route('marketer.withdrawHistoryPage')}}" class="btn ">{{ __('Withdraw History') }}</a>


        </div>
        <div class="col-5 col-md-3">
            <div>
                <i class="fa-solid fa-square-caret-right"></i>
            </div>
            <a href="{{route('marketer.withdrawpage')}}" class="btn ">{{ __('Make Withdraw') }}</a>
        </div>
        <div class="col-1 col-md-3"></div>
    </div>
</div>
<!-- End marketer balance option -->

<!-- Start income and target bonus -->
<section class="jumbotron  mt-4 bg-white shadow-sm">
    <div class="container">
        <!-- Start income and target bonus -->
        <div class="row pt-4 border" style="border-radius: 10px;">
            <div class="col-12 table-responsive-sm">
                <table class="table table-bordered">
                    <thead>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th colspan="4" class="text-center">
                                {{__('আপনার আয় এবং টার্গেট পূরণে বোনাস')}}
                            </th>
                        </tr>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th scope="col" class="text-center border-0">{{__('বিবরণ')}}</th>
                            <th scope="col" class="text-center border-0">{{__('আমার আয় ')}}</th>
                            <th scope="col" class="text-center border-0">{{__('প্রাপ্ত বোনাস')}}</th>
                            <th scope="col" class="text-center border-0">{{__('বোনাস সহ মোট আয়')}}</th>
                        </tr>
                        <tr>
                            <th scope="col" class="text-center border-0">{{__('লাইফটাইম')}}</th>
                            <th scope="col" class="text-center border-0">{{__($totalLifetimeIncome)}}</th>
                            <th scope="col" class="text-center border-0">{{__($targetFilupBonus)}}</th>
                            <th scope="col" class="text-center border-0">{{__($totalLifetimeIncome +
                                $targetFilupBonus)}}</th>
                        </tr>
                        <tr class="">
                            <th colspan="4" class="text-left">
                                <div class="row">
                                    <div class="col-4 col-lg-4 form-group">
                                        <select class="form-control bg-warning" id="yearForTargetFilup"
                                            name="yearForTargetFilup">
                                            @for($i = 2021; $i <= 2050; $i++) <option value="{{  $i }}"
                                                @if($i==date('Y')) selected="" @endif>{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyForTargetArea">

                    </tbody>
                </table>
            </div>
        </div>
        <!-- end income and target bonus -->

        <!-- start order income -->
        <div class="row mt-5 pt-4 border" style="border-radius: 10px;">
            <div class="col-12 table-responsive-sm">
                <table class="table table-bordered">
                    <thead>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th colspan="3" class="text-center">
                                {{__('অর্ডার কমিশন ')}}
                            </th>
                        </tr>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th scope="col" class="text-center border-0">{{__('অর্ডার কমপ্লিট')}}</th>
                            <th scope="col" class="text-center border-0">{{__('অর্ডার বাজেট')}}</th>
                            <th scope="col" class="text-center border-0">{{__('মোট প্রাপ্ত আয়')}} </th>
                        </tr>
                        <tr>
                            <th scope="col" class="text-center border-0">{{__('লাইফটাইম ')}}</th>
                            <th scope="col" class="text-center border-0">{{__($totalOrderBudget)}}</th>
                            <th scope="col" class="text-center border-0">{{__($totalOrderCommissionBonus)}}</th>
                        </tr>
                        <tr class="">
                            <th colspan="3" class="text-left">
                                <div class="row">
                                    <div class="col-4 col-lg-4 form-group">
                                        <select class="form-control bg-warning" id="yearForOrderCommission"
                                            name="yearForOrderCommission">
                                            @for($i = 2021; $i <= 2050; $i++) <option value="{{  $i }}"
                                                @if($i==date('Y')) selected="" @endif>{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyForOrderCommission">

                    </tbody>
                </table>
            </div>
            <div class="col-12 text-center mb-3">
                <a href="{{route('marketer.orderunderme')}}" class="btn btn-success">{{ __('আপনার অধীনে অর্ডার সমূহ
                    দেখুন') }}</a>
            </div>
        </div>
        <!-- end order income -->

        <!-- start warker signup comission -->
        <div class="row mt-5 pt-4 border" style="border-radius: 10px;">
            <div class="col-12 table-responsive-sm">
                <table class="table table-bordered">
                    <thead>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th colspan="5" class="text-center">
                                {{__('ওয়ার্কার সাইন আপ কমিশন')}}
                            </th>
                        </tr>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th scope="col" class="text-center border-0">{{__('ওয়ার্কার সাইন আপ')}}</th>
                            <th scope="col" class="text-center border-0">{{__('সংখ্যা')}}</th>
                            <th scope="col" class="text-center border-0">{{ get_static_option('job_complete_amount') }}
                                {{__('টাকার জব সম্পন্ন')}}</th>
                            <th scope="col" class="text-center border-0">{{__('মোট প্রাপ্ত আয়')}}</th>
                            <th scope="col" class="text-center border-0">{{__('মোট পেন্ডিং আয়')}}</th>
                        </tr>
                        <tr>
                            <th scope="col" class="text-center border-0">{{__('লাইফটাইম ')}}</th>
                            <th scope="col" class="text-center border-0">{{__($totalWorker)}} জন</th>
                            <th scope="col" class="text-center border-0">{{__($workerJobCondition)}} জন</th>
                            <th scope="col" class="text-center border-0">{{__($totalWorkerSignupBonus)}}</th>
                            <th scope="col" class="text-center border-0">{{__($pendingIncome)}}</th>
                        </tr>
                        <tr class="">
                            <th colspan="5" class="text-left">
                                <div class="row">
                                    <div class="col-4 col-lg-4 form-group">
                                        <select class="form-control bg-warning" id="yearForWorkerSignup"
                                            name="yearForWorkerSignup">
                                            @for($i = 2021; $i <= 2050; $i++) <option value="{{  $i }}"
                                                @if($i==date('Y')) selected="" @endif>{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyForWorkerSignup">

                    </tbody>
                </table>
            </div>
            <div class="col-12 text-center mb-3">
                <a href="{{route('marketer.workerunderme')}}" class="btn btn-success">{{ __('আপনার অধীনে ওয়ার্কারদের
                    দেখুন') }}</a>
            </div>
        </div>
        <!-- end worker signup comission -->

        <!-- start membership signup comission -->
        <div class="row mt-5 pt-4 border" style="border-radius: 10px;">
            <div class="col-12 table-responsive-sm">
                <table class="table table-bordered">
                    <thead>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th colspan="4" class="text-center">
                                {{__('পেইজ মেম্বারশীপ কমিশন')}}
                            </th>
                        </tr>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th scope="col" class="text-center border-0">{{__('পেইজ মেম্বারশীপ')}}</th>
                            <th scope="col" class="text-center border-0">{{__('সংখ্যা')}}</th>
                            <th scope="col" class="text-center border-0">{{__('প্যাকেজ ক্রয়')}}</th>
                            <th scope="col" class="text-center border-0">{{__('মোট প্রাপ্ত আয়')}} </th>
                        </tr>
                        <tr>
                            <th scope="col" class="text-center border-0">{{__('লাইফটাইম ')}}</th>
                            <th scope="col" class="text-center border-0">{{__($totalMembership)}} জন</th>
                            <th scope="col" class="text-center border-0">{{__($totalPackegBye)}} জন</th>
                            <th scope="col" class="text-center border-0">{{__($totalMembershipSignupCommission)}}</th>
                        </tr>
                        <tr class="">
                            <th colspan="4" class="text-left">
                                <div class="row">
                                    <div class="col-4 col-lg-4 form-group">
                                        <select class="form-control bg-warning" id="yearForMembershipSignup"
                                            name="yearForMembershipSignup">
                                            @for($i = 2021; $i <= 2050; $i++) <option value="{{  $i }}"
                                                @if($i==date('Y')) selected="" @endif>{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyForMembershipSignupCommission">

                    </tbody>
                </table>
            </div>
            <div class="col-12 text-center mb-3">
                <a href="{{route('marketer.memberunderme')}}" class="btn btn-success">{{ __('আপনার অধীনে পেইজসমূহ
                    দেখুন') }}</a>
            </div>
        </div>
        <!-- end membership signup comission -->

        <!-- start membership signup comission -->
        <div class="row mt-5 pt-4 border" style="border-radius: 10px;">
            <div class="col-12 table-responsive-sm">
                <table class="table table-bordered">
                    <thead>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th colspan="5" class="text-center">
                                {{__('কাস্টমার সাইন আপ কমিশন')}}
                            </th>
                        </tr>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th scope="col" class="text-center border-0">{{__('কাস্টমার সাইন আপ')}}</th>
                            <th scope="col" class="text-center border-0">{{__('সংখ্যা')}}</th>
                            <th scope="col" class="text-center border-0">{{__('টোটাল অর্ডার ')}}</th>
                            <th scope="col" class="text-center border-0">{{__('অর্ডার বাজেট ')}}</th>
                            <th scope="col" class="text-center border-0">{{__('মোট প্রাপ্ত আয়')}}</th>
                        </tr>
                        <tr>
                            <th scope="col" class="text-center border-0">{{__('লাইফটাইম ')}}</th>
                            <th scope="col" class="text-center border-0">{{__($totalCustomer)}} জন</th>
                            <th scope="col" class="text-center border-0">{{__($totalCustomerOrder)}} </th>
                            <th scope="col" class="text-center border-0">{{__($totalCustomerSignUpBudget)}} </th>
                            <th scope="col" class="text-center border-0">{{__($totalCustomerOrderBonus)}}</th>
                        </tr>
                        <tr class="">
                            <th colspan="5" class="text-left">
                                <div class="row">
                                    <div class="col-4 col-lg-4 form-group">
                                        <select class="form-control bg-warning" id="yearForcustomerSignup"
                                            name="yearForcustomerSignup">
                                            @for($i = 2021; $i <= 2050; $i++) <option value="{{  $i }}"
                                                @if($i==date('Y')) selected="" @endif>{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyForcustomerSignup">

                    </tbody>
                </table>
            </div>
            <div class="col-12 text-center mb-3">
                <a href="{{route('marketer.customerunderme')}}" class="btn btn-success">{{ __('আপনার অধীনে কাস্টমারদের
                    দেখুন') }}</a>
                
            </div>
        </div>
        <!-- end membership signup comission -->

        <!-- start marketer comission -->
        <div class="row mt-5 pt-4 border" style="border-radius: 10px;">
            <div class="col-12 table-responsive-sm">
                <table class="table table-bordered">
                    <thead>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th colspan="4" class="text-center">
                                {{__('মার্কেটারের কমিশন')}}
                            </th>
                        </tr>
                        <tr class="" style="background: linear-gradient(45deg, #ffdf40, #ff8359)!important;">
                            <th scope="col" class="text-center border-0">{{__('বিবরণ')}}</th>
                            <th scope="col" class="text-center border-0">
                                {{__('মিনিমাম')}} {{get_static_option('marketer_monthly_income') }} {{__('টাকা আয়ের শর্ত পূরণ')}}
                                ({{ $currentMonth }})
                            </th>
                            <th scope="col" class="text-center border-0">{{__('মার্কেটারের আয়')}}</th>
                            <th scope="col" class="text-center border-0">{{__('মোট প্রাপ্ত আয়')}}</th>
                        </tr>
                        <tr>
                            <th scope="col" class="text-center border-0">{{__('লাইফটাইম ')}}</th>
                            <th scope="col" class="text-center border-0">{{__($conditionFilup)}}</th>
                            <th scope="col" class="text-center border-0">{{__($allMarketerIncome)}}</th>
                            <th scope="col" class="text-center border-0">{{__($totalMarketerCommission)}}</th>
                        </tr>
                        <tr class="">
                            <th colspan="4" class="text-left">
                                <div class="row">
                                    <div class="col-4 col-lg-4 form-group">
                                        <select class="form-control bg-warning" id="yearForMarketerCommission"
                                            name="yearForMarketerCommission">
                                            @for($i = 2021; $i <= 2050; $i++) <option value="{{  $i }}"
                                                @if($i==date('Y')) selected="" @endif>{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyForMarketerCommission">

                    </tbody>
                </table>
            </div>
            <div class="col-12 text-center mb-3">
                <a href="{{route('marketer.marketerunderme')}}" class="btn btn-success">{{ __('আপনার অধীনে মার্কেটারদের
                    দেখুন') }}</a>
            </div>
        </div>
        <!-- end membership signup comission -->

    </div>
</section>
<!-- End income and target bonus-->

<script type="text/javascript">
    $(document).ready(function() {
                    jQuery.noConflict();
                  $('.topOwl').owlCarousel({
                    loop: true,
                    margin: 10,
                    autoplay: true,
                    responsiveClass: true,
                    responsive: {
                      0: {
                        items: 4,
                        nav: true,
                        dots: false,
                      },
                      600: {
                        items: 4,
                        nav: false,
                        dots: false,
                      },
                      1000: {
                        items: 6,
                        nav: false,
                        dots: false,
                        loop: false,
                        margin: 20
                      }
                    }
                  })
                })
</script>

<script>
    $(document).ready(function() {

            // target filup function
            function showTargetFilupTable(year){
                $.ajax({  
                    url: "{{  url('/get/marketer/targetfilupdata/') }}/"+year,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#tableBodyForTargetArea').empty();
                        $('#tableBodyForTargetArea').html(data);
                    },
                });
            }
            showTargetFilupTable(0);

            $('#yearForTargetFilup').on('change', function(e){
                e.preventDefault();

                var year = $(this).val();
                showTargetFilupTable(year);

            });
            // order commission function
            function showOrderCommissionTable(year){
                $.ajax({  
                    url: "{{  url('/get/marketer/ordercompletecommission/') }}/"+year,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#tableBodyForOrderCommission').empty();
                        $('#tableBodyForOrderCommission').html(data);
                    },
                });
            }
            showOrderCommissionTable(0);
            $('#yearForOrderCommission').on('change', function(e){
                e.preventDefault();
                var year = $(this).val();
                showOrderCommissionTable(year);

            });

            // customer signup commission
            function showcustomerSignupTable(year){
                $.ajax({  
                    url: "{{  url('/get/marketer/customersignupbonus/') }}/"+year,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#tableBodyForcustomerSignup').empty();
                        $('#tableBodyForcustomerSignup').html(data);
                    },
                });
            }
            showcustomerSignupTable(0);
            $('#yearForcustomerSignup').on('change', function(e){
                e.preventDefault();
                var year = $(this).val();
                showcustomerSignupTable(year);
            });

            // worker signup commission
            function showWorkerSignupTable(year){
                $.ajax({  
                    url: "{{  url('/get/marketer/workersignupbonus/') }}/"+year,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#tableBodyForWorkerSignup').empty();
                        $('#tableBodyForWorkerSignup').html(data);
                    },
                });
            }
            
            showWorkerSignupTable(0);
            $('#yearForWorkerSignup').on('change', function(e){
                e.preventDefault();
                var year = $(this).val();
                showWorkerSignupTable(year);
            });

            // membership signup commission 
            function showMembershipSignupCommissionTable(year){
                $.ajax({  
                    url: "{{  url('/get/marketer/membershipsignupcommission/') }}/"+year,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#tableBodyForMembershipSignupCommission').empty();
                        $('#tableBodyForMembershipSignupCommission').html(data);
                    },
                });
            }
            showMembershipSignupCommissionTable(0);
            $('#yearForMembershipSignup').on('change', function(e){
                e.preventDefault();
                var year = $(this).val();
                showMembershipSignupCommissionTable(year);
            });

             // marketer commission 
            function showMarketerCommissionTable(year){
                $.ajax({  
                    url: "{{  url('/get/marketer/marketers/') }}/"+year,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#tableBodyForMarketerCommission').empty();
                        $('#tableBodyForMarketerCommission').html(data);
                    },
                });
            }
            showMarketerCommissionTable(0);
            $('#yearForMarketerCommission').on('change', function(e){
                e.preventDefault();
                var year = $(this).val();
                showMarketerCommissionTable(year);
            });

            //Submit new Job
            $('#job-submit-button').click(function(){
                var formData = new FormData();
                formData.append('title', $('#title').val())
                formData.append('description', $('#description').val())
                formData.append('address', $('#address').val())
                formData.append('service', $('#service').val())
                formData.append('day', $('#day').val())
                formData.append('budget', $('#budget').val())

                $.ajax({
                    method: 'POST',
                    url: '/customer/job',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#title').val('');
                        $('#description').val('');
                        $('#address').val('');
                        //$('#service').val('');
                        $('#day').val('');
                        $('#budget').val('');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully add new job.',
                            showConfirmButton: false,
                            timer: 1500
                        })
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
        });
</script>
@endsection