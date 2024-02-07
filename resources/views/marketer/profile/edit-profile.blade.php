@extends('marketer.layout.app')
@push('title') {{ __('Edit Profile') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="container">
        <div class="row no-gutters login-row">
            <div class="col align-self-center px-3 text-center">
                <br>
                <br>
               
                <h4 class="mt-3">{{ __('Profile Update') }}</h4>
                <a href="{{ route('language') }}">
                    <img height="30px;" width="30px;" src="{{ asset(  'uploads/images/defaults/language-icon-bd-en.png') }}" alt="logo" class="">
                    @if(current_language() != 'en')
                        বাংলা
                    @else
                        English
                    @endif
                </a>
                <hr>
                <form class="form-signin mt-3" action="{{ route('updateUsersSelfProfileInfo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <!--Image upload with preview start -->
                        <div class="figure-profile shadow my-4">
                            <figure><img id="profile-image-preview" alt="" src="{{ asset(auth()->user()->image ?? get_static_option('no_image')) }}"></figure>
                            <div class="btn btn-dark text-white floating-btn">
                                <i class="material-icons">camera_alt</i>
                                <input accept="image/*" type="file" name="profile_image" id="profile-image" class="float-file"/>
                            </div>
                        </div>
                        <!--Image upload with preview end -->
                    </div>
                    <div class="form-group">
                        <input type="text" required name="full_name" placeholder="Full Name"  class="form-control form-control-lg text-center" value="{{ auth()->user()->full_name }}"/>
                    </div>
                    <div class="form-group">
                        <input type="text" required name="user_name" placeholder="Username"  class="form-control form-control-lg text-center" value="{{ auth()->user()->user_name }}"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" required placeholder="Phone" class="form-control form-control-lg text-center" value="{{ auth()->user()->phone }}" readonly="" />
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Email" required class="form-control form-control-lg text-center"   value="{{ auth()->user()->email }}"/>
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-lg text-center"  name="gender" >
                            <option @if(auth()->user()->gender == 'male') selected @endif value="male">{{ __('Male') }}</option>
                            <option @if(auth()->user()->gender == 'female') selected @endif value="female">{{ __('Female') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-primary bg-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        //Profile image upload preview
        $("#profile-image").change(function (event){
            if(event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("profile-image-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        })
    </script>
@endsection

