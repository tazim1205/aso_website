@extends('guest.layout')

@section('content')
    <div class="wrapper">
        <!-- Swiper intro -->
        <div class="swiper-container introduction pt-5">
            <div class="swiper-wrapper">
                <div class="swiper-slide overflow-hidden text-center">
                    <div class="row no-gutters">
                        <div class="col align-self-center px-3">
                            <img src="{{ asset( get_static_option('logo')  ?? 'uploads/images/defaults/logo.png') }}" alt="" class="mx-100 my-5">
                            <div class="row">
                                <div class="container mb-5">
                                    <h3 class="text-success"><b>{{ __('Service on Demand') }}</b></h3>
                                    <p>{{ __('Top & Best Service Marketplace in Bangladesh') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Swiper intro ends -->

        <hr class="bg-success">
        <div class="row mx-0">
            <div class="container">
                <div class="text-center">
                    <h3 class="btn btn-default btn-lg btn-rounded shadow my-2"><b>{{ __('Privacy Policy') }}</b></h3>
                </div>
                <div class="card shadow border-0 mb-3">
                    {{--# ১ --}}
                    <div class="card-body">
                        <div class="row">
                           <div>
                               @if(current_language() != 'en')
                                   {!! $privacy_policy->en_description !!}
                               @else
                                   {!! $privacy_policy->bn_description !!}
                               @endif
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
@endsection
