@extends('customer.layout.master')
@push('title') {{ __('Edit Profile') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="my-container">
    
        <div class="ab-head">
            <h1>Customer Profile Update</h1>
        </div>        
    
        <div class="login-form help-line edit">
            <form action="{{ route('updateUsersSelfProfileInfo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="edit-image" style="margin-bottom: 10px">
                    <img id="profile-image-preview" alt="" src="{{ asset(auth()->user()->image ?? get_static_option('no_image')) }}">
                </div>
                <input type="text" required name="full_name" id="" placeholder="Name" value="{{ auth()->user()->full_name }}">
                <input type="text" required name="user_name" id="" placeholder="Username" value="{{ auth()->user()->user_name }}">
                <input type="number" name="phone" required placeholder="মোবাইল " value="{{ auth()->user()->phone }}" readonly="">
                <input type="email" name="email" placeholder="ইমেইল" value="{{ auth()->user()->email }}">    
                <select name="gender">
                    <option @if(auth()->user()->gender == 'male') selected @endif value="male">Male</option>
                    <option @if(auth()->user()->gender == 'female') selected @endif value="female">Female</option>    
                </select>
                <input type="submit" name="" id="SUBMIT">    
    
            </form>
    
        </div>
    
    </div>
@endsection

