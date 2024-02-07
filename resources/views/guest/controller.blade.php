@extends('guest.layout')

@section('content')
    <div class="wrapper">

        <!-- header -->
        <div class="header">
            <div class="row no-gutters">
                <div class="col-auto">
                    <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn  btn-link text-dark"><i class="material-icons">navigate_before</i></a>
                </div>
                <div class="col text-center"><img src="img/logo-header.png" alt="" class="header-logo"></div>
            </div>
        </div>
        <!-- header ends -->

        <div class="container">
            <!-- page content here -->
            <div class="alert alert-primary" role="alert">
                আপনার একাউন্ট সফলভাবে তৈরি হয়েছে। আপনার সব ডকুমেন্ট চেক করে ২৪ ঘন্টার মধ্যে আপনার একাউন্ট এক্টিভ করা হবে। কাস্টমারদের নিরাপত্তার স্বার্থে আপনার মূল ডকুমেন্ট "aso" কর্তৃপক্ষ সংরক্ষণ করবে। আমাদেরকে পর্যাপ্ত সময় দিয়ে সহযোগিতা করার জন্য ধন্যবাদ। একাউন্ট এক্টিভ হলে তারপর "aso" তে আপনার সার্ভিস দিতে পারবেন। ২৪ ঘন্টার মধ্যে একাউন্ট এক্টিভ না হলে তারপরে আপনার উপজেলা / মেট্রোপলিটন থানার এরিয়া কন্ট্রোলার অফিসে মোবাইলে / ইমেলে / সরাসরি যোগাযোগ করুন।
            </div>
            <br>

            @foreach($upazila->helplines as $helpline)
                {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-primary  justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-white">
                                <i class="fa fa-home"></i> {{ $helpline->full_name }}</a>
                        </li>
                    </ol>
                </nav> --}}
                <div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="font-weight-normal mb-1 phone-number">{{ $helpline->phone }}</h5>
                                <p class="text-mute small text-secondary mb-2">{{ $helpline->email }}</p>
                            </div>
                            <div class="col-auto pl-0">
                                <a href="tel:{{ $helpline->phone }}">
                                    <button class="call-button avatar avatar-50 no-shadow border-0 bg-template">
                                        <i class="material-icons">call</i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
