@extends('guest.layout')
@push('title')  {{ __('All Gig') }} @endpush
@push('head')
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="wrapper">
       
        <!-- Start title -->
        <div>
            <div class="alert alert-primary text-center" role="alert">
                <b>{{ $service->name }}</b>
            </div>
            <input type="hidden" name="" id="service_id" value="{{ $service->id }}">
        </div>


        <!-- Start worker's bid of this area-->
        <div class="container">
            <div class="row mb-2">
                <div class="col-lg-6 col-sm-6 col-6 text-center mb-1">
                    <button class="btn btn-success active w-100" type="button" id="gig-btn">গিগ</button>
                </div>
                <div class="col-lg-6 col-sm-6 col-6 text-center mb-1">
                    <button class="btn btn-default w-100" type="button" id="page-btn">পেইজ</button>
                </div>
                {{-- <div class="col-12 text-center">
                    <button id="gig-btn" type="button" class="mb-2 btn btn-success">{{ __('GIG') }}
                    </button>
                    <button id="page-btn" type="button" class="mb-2 btn btn-default">{{ __('PAGE') }}
                    </button>
                </div> --}}
            </div>    
            <div class="row" id="gig_area">
                <div class="col-12 mb-2 pb-3" style="border-bottom: 1px solid #e6e6e6;">
                    <div class="row">
                        <div class="col-lg-2 col-5">
                            <div class="dropdown">
                                <button class="btn bg-light dropdown-toggle w-100" type="button" id="budget_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('বাজেট') }}</button>
                                <div class="dropdown-menu p-3" aria-labelledby="budget_dropdown" style="width: 400px;">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Min.</label>
                                            <input type="number" name="min_budget" id="min_budget" class="form-control" min="1" placeholder="৳" required="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Max.</label>
                                            <input type="number" name="max_budget" id="max_budget" class="form-control" min="1" placeholder="৳" required="">
                                        </div>
                                        <div class="form-group col-12">
                                            <input type="radio" id="high" name="budget" value="High To Low"> Hig To Low
                                            <input type="radio" id="low" name="budget" value="Low To High"> Low To High
                                        </div>
                                        <div class="form-group col-12 text-right">
                                            <button id="budget_apply_btn" class="btn btn-info">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-7">
                            <button class="btn bg-light dropdown-toggle w-100" type="button" id="deliverytime_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('ডেলিভারি টাইম') }}</button>
                            <div class="dropdown-menu p-3" aria-labelledby="deliverytime_dropdown" style="width: 400px;">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Up to</label>
                                    </div>
                                    <div class="form-group col-6">
                                        <input type="number" name="delivery_time" id="delivery_time" class="form-control" min="1" placeholder="5" required="">
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Hours</label>
                                    </div>
                                    <div class="form-group col-12 text-right">
                                        <button id="delivery_time_btn" class="btn btn-info">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-5">
                            <div class="form-group">
                                <select class="form-control" id="rating" name="rating">
                                    <option>{{ __('রেটিং') }}</option>
                                    <option value="1">{{ __('Up to 1') }} </option>
                                    <option value="10">{{ __('Up to 1.5') }} </option>
                                    <option value="20">{{ __('Up to 2') }} </option>
                                    <option value="30">{{ __('Up to 2.5') }} </option>
                                    <option value="40">{{ __('Up to 3') }} </option>
                                    <option value="50">{{ __('Up to 3.5') }} </option>
                                    <option value="60">{{ __('Up to 4') }} </option>
                                    <option value="70">{{ __('Up to 4.5') }} </option>
                                    <option value="80">{{ __('5') }} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-7">
                            <div class="form-group">
                                <select class="form-control" id="timely_delivery_rate" name="timely_delivery_rate">
                                    <option>{{ __('সময়মতো ডেলিভারি হার') }}</option>
                                    <option value="100">{{ __('100%') }} </option>
                                    <option value="90">{{ __('90%') }} </option>
                                    <option value="80">{{ __('80%') }} </option>
                                    <option value="70">{{ __('70%') }} </option>
                                    <option value="60">{{ __('60%') }} </option>
                                    <option value="50">{{ __('50%') }} </option>
                                    <option value="25">{{ __('25%') }} </option>
                                    <option value="1">{{ __('1%') }} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-7">
                            <div class="form-group">
                                <select class="form-control" id="order_complete_rate" name="order_complete_rate">
                                    <option>{{ __('অর্ডার সম্পন্ন হার') }}</option>
                                    <option value="100">{{ __('100%') }} </option>
                                    <option value="90">{{ __('90%') }} </option>
                                    <option value="80">{{ __('80%') }} </option>
                                    <option value="50">{{ __('50%') }} </option>
                                    <option value="1">{{ __('1%') }} </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 now_online_area">
                            <a href="" id="now_online" title="Click To Active" class="btn btn-sm btn-default now_online_deactive"><i class="fa fa-toggle-off text-white now_online_icon" id="now_online_icon"></i></a> {{ __('এখন অনলাইন') }}
                        </div>
                        <div class="col-lg-3 recent_online_area">
                            <a href="" id="recent_online" title="Click To Active" class="btn btn-sm btn-default recent_online_deactive"> <i class="fa fa-toggle-off text-white recent_online_icon" id="recent_online_icon"></i></a> {{ __('সাম্প্রতিক অনলাইন') }}
                        </div>
                        <div class="col-lg-3 recent_order_delivery_area">
                            <a href="" id="recent_order_delivery" title="Click To Active" class="btn btn-sm btn-default recent_order_delivery_deactive"> <i class="fa fa-toggle-off text-white recent_order_delivery_icon" id="recent_order_delivery_icon"></i></a> {{ __('সাম্প্রতিক অর্ডার ডেলিভারি') }}
                        </div>
                    </div>
                </div>
                <div class="col-12 px-0">
                    <div class="row mt-3" id="gig_list_area">
                        
                    </div>
                </div>
            </div>
            <div class="row" id="page_area">
                <div class="col-12 mb-2 pb-3" style="border-bottom: 1px solid #e6e6e6;">
                    <div class="row">
                        <div class="col-lg-2 col-5">
                            <div class="dropdown">
                                <button class="btn bg-light dropdown-toggle w-100" type="button" id="budget_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('Budget') }}</button>
                                <div class="dropdown-menu p-3" aria-labelledby="budget_dropdown" style="width: 400px;">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Min.</label>
                                            <input type="number" name="page_min_budget" id="page_min_budget" class="form-control" min="1" placeholder="৳" required="">
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Max.</label>
                                            <input type="number" name="page_max_budget" id="page_max_budget" class="form-control" min="1" placeholder="৳" required="">
                                        </div>
                                        <div class="form-group col-12">
                                            <input type="radio" id="page_high" name="page_budget" value="High To Low"> Hig To Low
                                            <input type="radio" id="page_low" name="page_budget" value="Low To High"> Low To High
                                        </div>
                                        <div class="form-group col-12 text-right">
                                            <button id="page_budget_apply_btn" class="btn btn-info">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-7">
                            <button class="btn bg-light dropdown-toggle w-100" type="button" id="deliverytime_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Delivery Time') }}</button>
                            <div class="dropdown-menu p-3" aria-labelledby="deliverytime_dropdown" style="width: 400px;">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Up to</label>
                                    </div>
                                    <div class="form-group col-6">
                                        <input type="number" name="page_delivery_time" id="page_delivery_time" class="form-control" min="1" placeholder="5" required="">
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Hours</label>
                                    </div>
                                    <div class="form-group col-12 text-right">
                                        <button id="page_delivery_time_btn" class="btn btn-info">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-5">
                            <div class="form-group">
                                <select class="form-control" id="page_rating" name="page_rating">
                                    <option>{{ __('Rating') }}</option>
                                    <option value="1">{{ __('Up to 1') }} </option>
                                    <option value="10">{{ __('Up to 1.5') }} </option>
                                    <option value="20">{{ __('Up to 2') }} </option>
                                    <option value="30">{{ __('Up to 2.5') }} </option>
                                    <option value="40">{{ __('Up to 3') }} </option>
                                    <option value="50">{{ __('Up to 3.5') }} </option>
                                    <option value="60">{{ __('Up to 4') }} </option>
                                    <option value="70">{{ __('Up to 4.5') }} </option>
                                    <option value="80">{{ __('5') }} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-7">
                            <div class="form-group">
                                <select class="form-control" id="page_timely_delivery_rate" name="page_timely_delivery_rate">
                                    <option>{{ __('Timely delivery rate') }}</option>
                                    <option value="100">{{ __('100%') }} </option>
                                    <option value="90">{{ __('90%') }} </option>
                                    <option value="80">{{ __('80%') }} </option>
                                    <option value="70">{{ __('70%') }} </option>
                                    <option value="60">{{ __('60%') }} </option>
                                    <option value="50">{{ __('50%') }} </option>
                                    <option value="25">{{ __('25%') }} </option>
                                    <option value="1">{{ __('1%') }} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-7">
                            <div class="form-group">
                                <select class="form-control" id="page_order_complete_rate" name="page_order_complete_rate">
                                    <option>{{ __('Order complete rate') }}</option>
                                    <option value="100">{{ __('100%') }} </option>
                                    <option value="90">{{ __('90%') }} </option>
                                    <option value="80">{{ __('80%') }} </option>
                                    <option value="50">{{ __('50%') }} </option>
                                    <option value="1">{{ __('1%') }} </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 now_online_area">
                            <a href="" id="page_now_online" title="Click To Active" class="btn btn-sm btn-default page_now_online_deactive"><i class="fa fa-toggle-off text-white page_now_online_icon" id="page_now_online_icon"></i></a> {{ __('Now Online') }}
                        </div>
                        <div class="col-lg-2 recent_online_area">
                            <a href="" id="page_recent_online" title="Click To Active" class="btn btn-sm btn-default page_recent_online_deactive"> <i class="fa fa-toggle-off text-white page_recent_online_icon" id="page_recent_online_icon"></i></a> {{ __('Recent Online') }}
                        </div>
                        <div class="col-lg-3 recent_order_delivery_area">
                            <a href="" id="page_recent_order_delivery" title="Click To Active" class="btn btn-sm btn-default page_recent_order_delivery_deactive"> <i class="fa fa-toggle-off text-white page_recent_order_delivery_icon" id="page_recent_order_delivery_icon"></i></a> {{ __('Recently Order Delivery') }}
                        </div>
                    </div>
                </div>
                <div class="col-12 px-0">
                    <div class="row mt-3" id="page_list_area">
                        @foreach ($mamberships as $membership)
                            {{-- {{ $membership->position }} --}}
                            @foreach ($pages as $page)
                                @if (isset($membership->position) && App\MembershipPackage::withTrashed()->find(App\Membership::find($page->membership_id)->membership_package_id)->position == $membership->position)
                                    @if ($membership = App\Membership::where('user_id', $page->worker_id)->where('ending_at', '>=', carbon\Carbon::now()->format('Y-m-d H:i:s'))->first())
                                        @if ($membership->id == $page->membership_id)
                                            @foreach (Str::of($page->services)->explode(',') as $service_id)
                                                @if ($service_id == $service->id)
                                                    @php 
                                                    $check = false;
                                                    $worker = App\User::find($page->worker_id);

                                                    $Word = $worker->word_road_id;
                                                    $workerWord = explode(',', $Word);
                                                    @endphp
                                                    @if ($Word != NULL)
                                                        @foreach ($workerWord as $w)
                                                            @if ($w == auth()->user()->word_road_id && $worker->out_of_work == 0) 
                                                                @php $check = true; @endphp
                                                            @endif
                                                        @endforeach
                                                        @if ($check == true)
                                                            <div class="col-12 col-lg-12" style="border-bottom: 1px solid #e6e6e6;">
                                                                <div class="d-flex">
                                                                    <button class="p-2 w-10 page_id" style="border: 0; background: none" value="{{ $page->id }}">
                                                                        <a href="{{ route('customer.showPages', $page->id) }}">
                                                                            <img src="{{ asset($page->image)}}" class="rounded-circle" alt="Cinque Terre" width="80" height="80">
                                                                        </a>
                                                                    </button>
                                                                    <div class="p-2">
                                                                        <a data-toggle="modal" data-target="#LoginModalWhenClickOrder">
                                                                            <h6 class="m-0">
                                                                                {{ Str::of($page->name)->limit(40, '(...)') }}
                                                                                <span class="text-right text-warning"><i class="fa fa-star"></i>
                                                                                    @php
                                                                                        $sum = App\ServiceReview::where('worker_id', $page->worker_id)->sum('rating');
                                                                                        $count = App\ServiceReview::where('worker_id', $page->worker_id)->count();
                                                                                        if (App\ServiceReview::where('worker_id', $page->worker_id)->exists()) {
                                                                                            $total_review = $sum/$count;
                                                                                        }else {
                                                                                            $total_review = 0;
                                                                                        }
                                                                                        if ($total_review != 0) {
                                                                                            echo number_format((float)$total_review, 1, '.', '');
                                                                                        }
                                                                                    @endphp
                                                                                    ({{$count}})
                                                                                </span>
                                                                            </h6>
                                                                        </a>
                                                                        <div>
                                                                            <span style="font-size: 15px">{{ Str::of($page->title)->limit(80, '(...)') }}</span>
                                                                        </div>

                                                                       </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- End worker's bid of this area-->
    </div>
    <script>
        $(document).ready( function () {
            var service_id = $('#service_id').val();
            $('#page_area').hide();

            $('#gig-btn').on('click', function(e){
                $('#gig_area').show();
                $('#page_area').hide();

                $('#gig-btn').removeClass( "btn-default" );
                $('#gig-btn').addClass( "btn-success" );

                $('#page-btn').removeClass( "btn-success" );
                $('#page-btn').addClass( "btn-default" );
            });

            $('#page-btn').on('click', function(e){
                $('#gig_area').hide();
                $('#page_area').show();

                $('#page-btn').removeClass( "btn-default" );
                $('#page-btn').addClass( "btn-success" );
                
                $('#gig-btn').removeClass( "btn-success" );
                $('#gig-btn').addClass( "btn-default" );
            });

            function getGigList(service_id,budget,min_budget,max_budget,delivery_time,rating,timely_delivery_rate,order_complete_rate,now_online,recent_online,recent_order_delivery){
                $.ajax({  
                    url: "{{  url('/get/guest/gig-list/') }}/"+service_id+"/"+budget+"/"+min_budget+"/"+max_budget+"/"+delivery_time+"/"+rating+"/"+timely_delivery_rate+"/"+order_complete_rate+"/"+now_online+"/"+recent_online+"/"+recent_order_delivery,
                    type:"GET",
                    dataType : 'html',
                    success:function(data) {
                        var d =$('#gig_list_area').empty();
                        $('#gig_list_area').html(data);
                    },
                });
            }
            getGigList(service_id);

            $("input[name=budget]").on('change', function(e){
                e.preventDefault();
                var budget = $(this).val();
                // alert(budget);
                getGigList(service_id,budget);
            });

            $('#budget_apply_btn').on('click', function(e){
                e.preventDefault();
                var min_budget = $('#min_budget').val();
                var max_budget = $('#max_budget').val();
                // alert(max_budget + min_budget);
                getGigList(service_id,0,min_budget,max_budget);
            });

            $('#delivery_time_btn').on('click', function(e){
                e.preventDefault();
                var delivery_time = $('#delivery_time').val();
                // alert(delivery_time);
                getGigList(service_id,0,0,0,delivery_time);
            });

            $("#rating").on('change', function(e){
                e.preventDefault();
                var rating = $(this).val();
                // alert(rating);
                getGigList(service_id,0,0,0,0,rating);
            });

            $("#timely_delivery_rate").on('change', function(e){
                e.preventDefault();
                var timely_delivery_rate = $(this).val();
                // alert(rating);
                getGigList(service_id,0,0,0,0,0,timely_delivery_rate);
            });

            $("#order_complete_rate").on('change', function(e){
                e.preventDefault();
                var order_complete_rate = $(this).val();
                // alert(rating);
                getGigList(service_id,0,0,0,0,0,0,order_complete_rate);
            });

            $("#order_complete_rate").on('change', function(e){
                e.preventDefault();
                var order_complete_rate = $(this).val();
                // alert(rating);
                getGigList(service_id,0,0,0,0,0,0,order_complete_rate);
            });

            $("#now_online, #now_online_icon").on('click', function(e){
                e.preventDefault();
                if(event.target.className == "btn btn-sm btn-default now_online_deactive"){
                    $('#now_online').removeClass("btn-default now_online_deactive");
                    $('#now_online').addClass("btn-success now_online_active");
                    $('.now_online_icon').removeClass("fa-toggle-off");
                    $('.now_online_icon').addClass("fa-toggle-on");
                    getGigList(service_id,0,0,0,0,0,0,0,1);
                    
                }else{
                    $('#now_online').removeClass("btn-success now_online_active");
                    $('#now_online').addClass("btn-default now_online_deactive");
                    $('.now_online_icon').removeClass("fa-toggle-on");
                    $('.now_online_icon').addClass("fa-toggle-off");
                    getGigList(service_id,0,0,0,0,0,0,0,0);
                }
                
            });

            $("#recent_online, #recent_online_icon").on('click', function(e){
                e.preventDefault();
                if(event.target.className == "btn btn-sm btn-default recent_online_deactive"){
                    $('#recent_online').removeClass("btn-default recent_online_deactive");
                    $('#recent_online').addClass("btn-success recent_online_active");
                    $('.recent_online_icon').removeClass("fa-toggle-off");
                    $('.recent_online_icon').addClass("fa-toggle-on");
                    getGigList(service_id,0,0,0,0,0,0,0,0,1);
                }else{
                    $('#recent_online').removeClass("btn-success recent_online_active");
                    $('#recent_online').addClass("btn-default recent_online_deactive");
                    $('.recent_online_icon').removeClass("fa-toggle-on");
                    $('.recent_online_icon').addClass("fa-toggle-off");
                    getGigList(service_id,0,0,0,0,0,0,0,0,0);
                }
            });

            $("#recent_order_delivery, #recent_order_delivery_icon").on('click', function(e){
                e.preventDefault();
                if(event.target.className == "btn btn-sm btn-default recent_order_delivery_deactive"){
                    $('#recent_order_delivery').removeClass("btn-default recent_order_delivery_deactive");
                    $('#recent_order_delivery').addClass("btn-success recent_order_delivery_active");
                    $('.recent_order_delivery_icon').removeClass("fa-toggle-off");
                    $('.recent_order_delivery_icon').addClass("fa-toggle-on");
                    getGigList(service_id,0,0,0,0,0,0,0,0,0,1);
                }else{
                    $('#recent_order_delivery').removeClass("btn-success recent_order_delivery_active");
                    $('#recent_order_delivery').addClass("btn-default recent_order_delivery_deactive");
                    $('.recent_order_delivery_icon').removeClass("fa-toggle-on");
                    $('.recent_order_delivery_icon').addClass("fa-toggle-off");
                    getGigList(service_id,0,0,0,0,0,0,0,0,0,0);
                }
            });

        });
    </script>
@endsection