@extends('customer.layout.app')
@push('title') {{ __('Details') }} @endpush
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
                <div class="col text-center"><img src="{{ asset(get_static_option('header_logo') ?? get_static_option('no_image')) }}" alt="" class="header-logo"></div>
                <div class="col-auto">
                    <a href="#" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications_none</i><span class="counts">9+</span></a>
                </div>
            </div>
        </div>
        <!-- header ends -->
        <div class="container">
            <!-- page content here -->
            <section class="jumbotron text-center mt-3 bg-white shadow-sm">
                <div class="container">
                    <img src="{{ asset($membershipPage->logo ?? get_static_option('no_image')) }}" alt="" class="header-logo">
                    <h5 class="jumbotron-heading font-weight-normal"><b>{{ $membershipPage->name ?? ''}}</b></h5>
                    <p class="lead">{{ $membershipPage->title ?? 'Title Empty' }}</p>
                    <p class="text-secondary text-mute small"></p>
                    <p>
                        <a @if($membershipPage->mobile) href="tel:{{ $membershipPage->mobile }}" @endif class="btn btn-default btn-rounded shadow my-2">Call {{ $membershipPage->mobile ?? '+880 xxxx-xxxxxx' }}</a>
                    </p>
                </div>
            </section>
            <h3 class="mb-3">{{ __('Description') }}</h3>
            <p>{{ $membershipPage->description ?? 'No Description' }}</p>
            <br>
            <br>
        </div>

        <div class="container">
            @for($image_amount=1; $image_amount <= $membershipPage->user->membership->membershipPackage->image_count; $image_amount++)
                @php
                    $img = 'image'.$image_amount;
                @endphp
                <div class="row text-center mt-4">
                    <div class="col-12 col-md-12">
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <img src="{{ asset($membershipPage->$img) }}" alt="" width="200px">
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
                <div class="row">
                    <div class="col text-center">
                        <h5 class="subtitle">{{ $membershipPage->address }}</h5>
                    </div>
                </div>
        </div>
        <!-- footer-->
        <div class="footer">
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
        </div>
        <!-- footer ends-->
    </div>

    <script>
    </script>
@endsection
