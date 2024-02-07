@extends('customer.layout.app')
@push('title') {{ __('Special service') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="wrapper homepage">
        <!-- header -->
        <div class="header">
            <div class="row no-gutters">
                <div class="col-auto">
                    <button class="btn  btn-link text-dark menu-btn"><i class="material-icons">menu</i><span class="new-notification"></span></button>
                </div>
                <div class="col text-center"><img src="{{ asset(get_static_option('header_logo') ?? 'uploads/images/uploads/header_logo.png') }}" alt="" class="header-logo"></div>
                <div class="col-auto">
                    <a href="#" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications_none</i><span class="counts">9+</span></a>
                </div>
            </div>
        </div>
        <!-- header ends -->
        <!-- Start title -->
        <div>
            <div class="alert alert-primary text-center" role="alert">
                <b>{{ $service->name }}</b>
            </div>
        </div>


        <!-- Start worker's bid of this area-->
        <div class="container">
            <div class="row text-center">
                <div class="col-md-6 col-xl-4 col-lg-4"></div>
                <div class="col-md-6 col-xl-4 col-lg-4">
                    <div class="card shadow border-0 mb-3">
                        <div class="card-body">
                            <button class="btn btn-md btn-success m-2">{{ $service->name }}</button><br>
                            <div class="btn-group btn-group-sm btn-group w-100 mt-2 mb-2 text-center" role="group" aria-label="Basic example">
                                <button disabled="" type="button" class="btn btn-outline-success active" style="border-radius: 0px;"><small> {{ $special_profiles->phone }} </small></button>
                                <a href="tel:{{ $special_profiles->phone }}" class="btn btn-success" style="border-radius: 0px;"> {{ __('Call Now') }}</a>
                            </div>
                            <div class="avatar avatar-60 no-shadow border-0 mt-2 mb-2">
                                <div class="overlay"></div>
                                <figure class="avatar avatar-60 border-0">
                                    <img src="{{ asset($special_profiles->image ?? 'uploads/images/defaults/user.png') }}" alt="" height="70px" width="70px">
                                </figure>
                            </div>
                            <p class="mt-3 mb-3 ">{!! $special_profiles->description !!}</p>
                            <a href="{{ route('customer.showSpecialServiceOrder',$special_profiles->id) }}" class="btn btn-success"> <p class="">{{ __('Order Now') }}</p></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 col-lg-4"></div>
            </div>
        </div>
        <!-- End worker's bid of this area-->
        <!-- footer-->
        {{-- <div class="footer">
            <div class="no-gutters">
                <div class="col-auto mx-auto">
                    <div class="row no-gutters justify-content-center">
                        <div class="col-auto">
                            <a href="{{ route('customer.home.index') }}" class="btn btn-link-default active">
                                <i class="material-icons">home</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-link-default">
                                <i class="material-icons">insert_chart_outline</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-link-default">
                                <i class="material-icons">account_balance_wallet</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-link-default">
                                <i class="material-icons">widgets</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-link-default">
                                <i class="material-icons">account_circle</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- footer ends-->
    </div>

    <script>
    </script>
@endsection
