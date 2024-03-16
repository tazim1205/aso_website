@extends('guest.layout')

@section('content')
<div class="my-container">
        <div class="pera">
            <p>আপনার একাউন্ট সফলভাবে তৈরি হয়েছে..আপনার সব ডকুমেন্ট চেক
                করে ২৪ ঘন্টার মধ্যে আপনার একাউন্ট এক্টিভ করা হবে..কাস্টমারদের
                নিরাপত্তার স্বার্থে আপনার মূল ডকুমেন্ট "aso" কর্তৃপক্ষ সংরক্ষণ করবে
                ..আমাদেরকে পর্যাপ্ত সময় দিয়ে সহযোগীতা করার জন্য ধন্যবাদ..
                একাউন্ট এক্টিভ হলে তারপর "aso" তে আপনার সার্ভিস দিতে পারবেন
                ..২৪ ঘন্টার মধ্যে একাউন্ট এক্টিভ না হলে তারপরে উপজেলা / 
                মেট্রোপলিটন থানার এরিয়া কন্ট্রোলার অফিসে মোবাইলে / ইমেইলে / 
                সরাসরি যোগাযোগ করুন।</p>
        </div>

        <div class="info-area">
            @foreach($upazila->helplines as $helpline)
            <div class="info-cont">
                <div class="info-left">
                    <h4>{{ $helpline->full_name }}</h4>
                    <p>{{ $helpline->phone }}</p>
                    <p>{{ $helpline->email }}</p>
                </div>
                <div class="info-right">
                    <div class="info-img">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- <div class="login-form sign-4 my-container">
        <div class="pre-next"> 
            <a href="sign_up_page_5.html"><input type="text" value="Sign In" class="btn-n-1"></a>
            <a href="Home_page_1.html"><input type="submit" value="Sign Up"></a>
        </div>
    </div> -->
@endsection
