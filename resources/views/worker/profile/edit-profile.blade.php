@extends('worker.layout.app')
@push('title') {{ __('Edit Profile') }} @endpush
@push('head')

@endpush
@section('content')
    





    <div class="my-container">
    
        <div class="ab-head">
            <h1>Service Provider Profile Update</h1>
        </div>        
    
        <div class="login-form help-line edit">
            <form action="{{ route('updateUsersSelfProfileInfo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <!--Image upload with preview start -->
                    <div class="figure-profile shadow my-4">
                        <figure><img id="profile-image-preview" style="width:15%;margin-left: 40%;border-radius: 50%;" alt="" src="{{ asset(auth()->user()->image ?? get_static_option('no_image')) }}"></figure>
                        <div class="floating-btn">
                            <input style="padding: 10px;" accept="image/*" type="file" name="profile_image" id="profile-image" class="float-file"/>
                        </div>
                    </div>
                    <!--Image upload with preview end -->
                </div>
                <input type="text" required name="full_name" id="" placeholder="Name" value="{{ auth()->user()->full_name }}">
                <input type="text" required name="user_name" id="" placeholder="Username" value="{{ auth()->user()->user_name }}">
                <input type="number" name="phone" required placeholder="মোবাইল " value="{{ auth()->user()->phone }}" readonly="">
                <input type="email" name="email" placeholder="ইমেইল" value="{{ auth()->user()->email }}">    
                <select name="gender">
                    <option @if(auth()->user()->gender == 'male') selected @endif value="male">Male</option>
                    <option @if(auth()->user()->gender == 'female') selected @endif value="female">Female</option>    
                </select>
                <br>
                <select name="worker_service[]" id="worker_service" multiple = "multiple" class="form-control" style="width: 100%;">
                    @foreach($categories as $category)
                        <optgroup label="{{ $category->name }}">
                            @foreach($category->services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                    
                <input type="submit" name="" id="SUBMIT">    
    
            </form>
    
        </div>
    
    </div>
@endsection

