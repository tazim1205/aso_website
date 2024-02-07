@extends('customer.layout.app')
@push('title') {{ __('Profile') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="order-area">
        <div class="profile-area">
            <div class="profile-area-left">
                <img src="{{ asset(auth()->user()->image ?? get_static_option('no_image')) }}" alt="">
            </div>
            <div class="profile-area-right">
                <h2>{{ auth()->user()->full_name }}</h2>
                <div class="profile-btn">
                    <a href="{{ route('customer.profile.edit') }}"><input type="submit" value="Edit Profile" style="cursor: pointer"></a>
                    <input type="submit" value="Change Password" class="cn-pass">
                </div>
            </div>
        </div>
        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p> <a href="{{ route('customer.service.details') }}">Service Details</a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section profile-border">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p><a href="{{ route('customer.training.video') }}">Video training </a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p> <a href="{{ route('customer.helpline') }}">Help line </a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p> <a href="{{ route('customer.about') }}">About </a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p><a href="{{ route('customer.faq') }}">FAQ</a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p><a href="{{ route('customer.terms.condition') }}">Terms and condition</a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section profile-border">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p> <a href="{{ route('customer.privacy.policy') }}">Privacy and policy</a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section">
            <div class="profile-section-left signout">
                <p><i class="fas fa-tools"></i></p><p>Sign out</p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
    </div>
    <div class="write-pass my-container">
        <h2>Write password</h2>
        <div class="login-form">
            <form method="post" action="{{ route('authedUserPasswordChange') }}">
                @csrf
                <input type="password" name="current" placeholder="Current password">
                <input type="password" name="password" placeholder="New password">
                <div class="pre-next">
                    <input type="text" value="Cancel" class="btn-n-1 cn-2">
                    <input type="submit" value="Submit">
                </div>
            </form>


        </div>
    </div>
    <div class="write-pass-1 my-container">
        <div class="edit-image ">
            <i class="fas fa-exclamation"></i>
        </div>
        <h2>Are you sure?</h2>
        <h3>আপনি পুনরায় আসো তে সাইন ইন করতে পারবেন।
        </h3>
        <div class="login-form">
            <div class="pre-next">
                <input type="text" value="Cancel" class="btn-n-1 cn-2">
                <input type="submit" value="Submit" onclick="logout()">
            </div>

        </div>
    </div>
@endsection

