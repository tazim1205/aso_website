@extends('worker.layout.app')
@push('title') {{ __('Home') }} @endpush
@section('content')
    @if(!auth()->user()->membership))
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
                    <div class="col-6 bg-warning "><b class="three_month_price">{{ $package->three_month_price }} ৳</b>/ <br> {{__('3 Month')}}</div>
                    <input type="hidden" class="six_month_price" value="{{ $package->six_month_price }} ৳">
                    <div class="col-6 bg-danger "><b class="twelve_month_price">{{ $package->twelve_month_price }} ৳</b>/ <br>{{ __('12 Month') }}</div>
                </div>
                <hr>
                <div class="row package-detail">
                    <div class="col-8">
                        <li>{{ __('Mobile number') }}</li>
                        <li>{{ __('Description') }}</li>
                        <li>{{ __('Images') }}</li>
                        <li>{{ __('Rank') }}</li>
                    </div>
                    <div class="col-4">
                        @if($package->mobile_availability == 1)
                            <span class="badge badge-success shadow-success m-1">{{ __('Yes') }}</span>
                        @else
                            <span class="badge badge-danger shadow-danger m-1">{{ __('No') }}</span>
                        @endif
                        <br>
                        @if($package->description_availability == 1)
                            <span class="badge badge-success shadow-success m-1">{{ __('Yes') }}</span>
                        @else
                            <span class="badge badge-danger shadow-danger m-1">{{ __('No') }}</span>
                        @endif
                        <br>
                        <span class="badge badge-success shadow-success m-1">{{ $package->image_count }}</span>
                        <br>
                        <span class="badge badge-success shadow-success m-1">{{ $package->position }}</span>
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
        <div class="">
            <div class="alert alert-info text-center" role="alert">
                <b id=""> {{ __('My PACKAGE : '.auth()->user()->membership->membershipPackage->name) }} </b>
            </div>
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
                    {{ __('Images') }}
                    <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->membershipPackage->image_count }}</span>
                </li>
            </ul>
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
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center active">
                    {{ __('Duration') }}
                     <span class="badge badge-success shadow-success m-1">{{ auth()->user()->membership->duration }} months</span>
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
        {{--End duration--}}
        {{--Start Update--}}
        <br>
        <br>
        <br>
        <div class="">
            <div class="alert alert-success text-center" role="alert">
                <b id=""> {{ __('Update') }} </b>
            </div>
            <form action="{{ route('worker.buyMembership') }}" method="post">
                @csrf
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center active">
                        {{ __('3 months') }}

                        <button type="submit" name="duration" class="btn badge badge-success shadow-success m-1" value="3">Buy</button>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ __('6 months') }}

                        <button type="submit" name="duration" class="btn badge badge-success shadow-success m-1" value="6">Buy</button>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ __('12 months') }}

                        <button type="submit" name="duration" class="btn badge badge-success shadow-success m-1" value="12">Buy</button>
                    </li>
                </ul>
            </form>
        </div>
        {{--End Update--}}
        {{--Start Change Package--}}
        <br>
        <br>
        <br>
        <div class="">
            <div class="alert alert-warning text-center" role="alert">
                <b id=""> {{ __('Change Package') }} </b>
            </div>
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
        {{--End Change Package--}}
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
        <!-- Start controller notice box -->
        @foreach(auth()->user()->upazila->controllers as $controller)
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
        @endforeach
        <!-- Start top ads. by controller this upazila -->
        <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
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
        </div>
        <!-- End top ads.  by controller this upazila -->
        <hr>
        <!-- Start middle ads. by admin for all-->
        <div class="swiper-container offer-slide swiper-container-horizontal swiper-container-android">
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
        </div>
        <!-- End middle ads. by admin for all-->
    @endif
    <script>
        $(document).ready(function (){
            $('.select-package-btn').click(function (){
                $('.package_name_modal').html($(this).parent().parent().find('.name').text())
                $('.package-detail-modal').html($(this).parent().parent().find('.package-detail').html())
                $('.three_month_modal').html($(this).parent().parent().find('.three_month_price').html())
                $('.six_month_modal').html($(this).parent().parent().find('.six_month_price').val())
                $('.twelve_month_modal').html($(this).parent().parent().find('.twelve_month_price').html())
                $('#hidden_package_id_modal').val($(this).val())
            });
        });
    </script>
@endsection
