<!doctype html>
<html lang="en" class="deeppurple-theme">


<!-- Mirrored from maxartkiller.com/website/Fimobile/Fimobile-HTML/modal.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Dec 2019 13:37:35 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="Maxartkiller">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Register-Member') }} | {{ get_static_option('name') }}</title>

    <!-- Material design icons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/mobile/vendor/materializeicon/material-icons.css')}}">

    <!-- Roboto fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/mobile/vendor/bootstrap-4.4.1/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Swiper CSS -->
    <link href="{{ asset('assets/mobile/vendor/swiper/css/swiper.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/mobile/css/style.css') }}" rel="stylesheet">

    <!--SweetAlert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body>
<!-- Loader -->
@include('includes.loader')
<!-- Loader ends -->

<div class="wrapper">
    <!-- header -->
    <div class="header">
        <div class="row no-gutters">
            <div class="col-auto">
                <a href="{{ route('welcome') }}" class="btn  btn-link text-dark"><i class="material-icons">chevron_left</i></a>
            </div>
            <div class="col text-center"></div>
            <div class="col-auto">
            </div>
        </div>
    </div>
    <!-- header ends -->

    <div class="row no-gutters login-row">
        <div class="col align-self-center px-3 text-center">
            <br>
            <br>
            <img src="{{ asset(get_static_option('logo') ?? 'uploads/images/defaults/logo.png') }}" alt="logo" class="logo-small">
            <h4 class="mt-3">{{ __('Membership sign up') }}</h4>
            {{-- <a href="{{ route('language') }}">
                <img height="30px;" width="30px;" src="{{ asset(  'uploads/images/defaults/language-icon-bd-en.png') }}" alt="logo" class="">
                @if(current_language() != 'en')
                    বাংলা
                @else
                    English
                @endif
            </a> --}}
            <form class="form-signin mt-3" method="post" id="upload_form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <!--Image upload with preview start -->
                    <div class="figure-profile shadow my-4">
                        <figure><img id="profile-image-preview" alt=""></figure>
                        <div class="btn btn-dark text-white floating-btn">
                            <i class="material-icons">camera_alt</i>
                            <input type="file" accept="image/*" id="profile-image" class="float-file">
                        </div>
                    </div>
                    <!--Image upload with preview end -->
                </div>
                <div class="form-group">
                    <input type="text" id="user-name" class="form-control form-control-lg text-center" placeholder="{{ __('Username') }}" required autofocus>
                </div>
                <div class="form-group">
                    <input type="text" id="full-name" class="form-control form-control-lg text-center" placeholder="{{ __('Full Name') }}" required autofocus>
                </div>
                <div class="form-group">
                    <input type="number" id="phone" class="form-control form-control-lg text-center" placeholder="{{ __('Phone Number') }}" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" class="form-control form-control-lg text-center" placeholder="{{ __('Password') }}" required>
                </div>
                <div class="form-group">
                    <input type="password" id="confirm-password" class="form-control form-control-lg text-center" placeholder="{{ __('Confirm Password') }}" required>
                </div>
                <div class="form-group">
                    <input type="text" minlength="6" maxlength="6" id="referral" class="form-control form-control-lg text-center" placeholder="{{ __('Referral code') }}">
                </div>
                <!-- Start district -->
                <div class="form-group">
                    <select class="form-control form-control-lg" id="district-id">
                        <option selected disabled> {{ __('Chose district') }}</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}">{{ __($district->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- End district -->
                <!-- Start upazila -->
                <div class="form-group">
                    <select class="form-control form-control-lg" id="upazila-id">
                        <option selected disabled value="" id="upazila-loader">
                            <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                        </option>
                        <!-- Insert by ajax -->
                    </select>
                </div>
                <!-- End upazila -->
                <!-- Start category -->
                <div class="form-group">
                    <select class="form-control form-control-lg" id="category-id">
                        <option selected disabled>{{ __('Chose category') }} </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- End category -->
                <!-- Start services -->
                <div class="form-group">
                    <select multiple="" class="form-control form-control-lg text-center" id="services-id">
                        <option selected disabled value="" id="services-loader">
                            <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                        </option>
                        <!-- Insert by ajax -->
                    </select>
                </div>
                <!-- End services -->
                <!-- Start gender -->
                <div class="row mx-0">
                    <div class="col-6 col-md-6 col-lg-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="gender" class="custom-control-input gender" id="male" value="male">
                            <label class="custom-control-label" for="male">{{ __('Male') }}</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="gender" class="custom-control-input gender" id="female" value="female">
                            <label class="custom-control-label" for="female">{{ __('Female') }}</label>
                        </div>
                    </div>
                </div>
                <!-- End gender -->
                <!-- Start NID  -->
                <div class="form-group">
                    <label>{{ __('NID front side') }}</label>
                    <input type="file" id="nid-front" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <label>{{ __('NID back side') }}</label>
                    <input type="file" id="nid-back" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <input type="text" minlength="" maxlength="" id="nid-number" class="form-control form-control-lg text-center" placeholder="{{ __('NID Number') }}">
                </div>
                <!-- End NID  -->

                <!-- Another register -->
                <p class="mt-4 d-block text-secondary">
                    {{ __('By clicking register your are agree to the') }}
                    <a href="{{ route('privacyPolicy') }}">{{ __('Privacy-policy') }}</a> ,
                    <br>
                    <a href="{{ route('termsAndConditions') }}">{{ __('Terms and condition') }}</a>
                </p>
                <hr>
                <p class="mt-4 d-block text-secondary">
                    <a href="{{ route('register') }}">{{ __('Customer Registration') }}</a>
                    <a href="{{ route('getWorkerRegisterForm') }}">{{ __('Worker Registration') }}</a>
                </p>
            </form>
        </div>
    </div>

    <!-- login buttons -->
    <div class="row mx-0 bottom-button-container">
        <div class="col">
            <a href="#" id="membership-register" class="btn btn-default btn-lg btn-rounded shadow btn-block">{{ __('Sign up') }}</a>
        </div>
    </div>
    <!-- login buttons -->
</div>

<!-- jquery, popper and bootstrap js -->
<script src="{{ asset('assets/mobile/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/mobile/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/mobile/vendor/bootstrap-4.4.1/js/bootstrap.min.js') }}"></script>

<!-- swiper js -->
<script src="{{ asset('assets/mobile/vendor/swiper/js/swiper.min.js') }}"></script>

<!-- cookie js -->
<script src="{{ asset('assets/mobile/vendor/cookie/jquery.cookie.js') }}"></script>

<!-- template custom js -->
<script src="{{ asset('assets/mobile/js/main.js') }}"></script>

<!-- page level script -->
<script>
    $(document).ready(function(){
        //Hide upazila & service first
        $("#upazila-id").hide()
        $("#services-id").hide()
        // Material Select Initialization


        //Get upazila after click on district
        $("#district-id").change(function(){
            var districtId = $(this).val();
            $("#upazila-id").show() //now show district
            $.ajax({
                method: 'POST',
                url: '/guest/get/upazila-of-a-district',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { districtId: districtId},
                dataType: 'JSON',
                beforeSend: function (){
                    $("#upazila-loader").show()
                },
                complete: function (){
                    $("#upazila-loader").hide()
                },
                success: function (response) {
                    //console.log(response)
                    var upazilaOption='<option selected disabled> Chose upazila</option>';
                    response.forEach(function(upazila){
                        upazilaOption += '<option value='+upazila.id+'>'+upazila.name+'</option>';
                    })
                    $("#upazila-id").html(upazilaOption)
                },
                error: function (xhr) {
                    var errorMessage = '<div class="card bg-danger">\n' +
                        '                        <div class="card-body text-center p-5">\n' +
                        '                            <span class="text-white">';
                    $.each(xhr.responseJSON.errors, function(key,value) {
                        errorMessage +=(''+value+'<br>');
                    });
                    errorMessage +='</span>\n' +
                        '                        </div>\n' +
                        '                    </div>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        footer: errorMessage
                    })
                },
            })
        });
        //Get service after click on category
        $("#category-id").change(function(){
            var categoryId = $(this).val();
            $("#services-id").show() //now show district
            $.ajax({
                method: 'POST',
                url: "{{ route('getMembershipServicesOfCategory') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { categoryId: categoryId},
                dataType: 'JSON',
                beforeSend: function (){
                    $("#services-loader").show()
                },
                complete: function (){
                    $("#services-loader").hide()
                },
                success: function (response) {
                    //console.log(response)
                    var serviceOption='<option disabled> Chose service</option>';
                    response.forEach(function(service){
                        serviceOption += '<option class="servicesClass" value='+service.id+'>'+service.name+'</option>';
                    })
                    $("#services-id").html(serviceOption)
                },
                error: function (xhr) {
                    var errorMessage = '<div class="card bg-danger">\n' +
                        '                        <div class="card-body text-center p-5">\n' +
                        '                            <span class="text-white">';
                    $.each(xhr.responseJSON.errors, function(key,value) {
                        errorMessage +=(''+value+'<br>');
                    });
                    errorMessage +='</span>\n' +
                        '                        </div>\n' +
                        '                    </div>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        footer: errorMessage
                    })
                },
            })
        });
        //Profile image upload preview
        $("#profile-image").change(function (event){
            if(event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("profile-image-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        })
        //Customer register submit
        $("#membership-register").click(function (){

            var servicesId = [];
            $('#services-id :selected').each(function(i, selectedElement) {
                servicesId[i] = $(selectedElement).val();
            });
            //servicesId.shift();
            //console.log(getInput());
            var userName = $('#user-name').val();
            var fullName = $('#full-name').val();
            var phone = $('#phone').val();
            var password = $('#password').val();
            var confirmPassword = $('#confirm-password').val();
            var referralCode = $('#referral').val();
            var districtId = $('#district-id').val();
            var upazilaId = $('#upazila-id').val();
            var gender = $('.gender:checked').val();
            var image = $('#profile-image')[0].files[0];
            var nidNumber = $('#nid-number').val();
            var nidFrontImage = $('#nid-front')[0].files[0];
            var nidBackImage = $('#nid-back')[0].files[0];

            var formData = new FormData();
            formData.append('userName', userName)
            formData.append('fullName', fullName)
            formData.append('phone', phone)
            formData.append('password', password)
            formData.append('password_confirmation', confirmPassword)
            formData.append('referralCode', referralCode)
            formData.append('district', districtId)
            formData.append('upazila', upazilaId)
            formData.append('services', servicesId)
            formData.append('gender', gender)
            formData.append('profilePicture', image)
            formData.append('nidNumber', nidNumber)
            formData.append('nidFrontImage', nidFrontImage)
            formData.append('nidBackImage', nidBackImage)

            $.ajax({
                method: 'POST',
                url: "{{ route('submitMembershipRegister') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    //console.log(data)
                    if (data.type == 'success'){
                        Swal.fire({
                            position: 'top-end',
                            icon: data.type,
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            //your code to be executed after 1 second
                            window.location = "{{ route('membership.home.index') }}";
                        }, 1000); //1 second
                    }else{
                        Swal.fire({
                            icon: data.type,
                            title: 'Oops...',
                            text: data.message,
                            footer: ''
                        })
                    }
                },
                error: function (xhr) {
                    var errorMessage = '<div class="card bg-danger">\n' +
                        '                        <div class="card-body text-center p-5">\n' +
                        '                            <span class="text-white">';
                    $.each(xhr.responseJSON.errors, function(key,value) {
                        errorMessage +=(''+value+'<br>');
                    });
                    errorMessage +='</span>\n' +
                        '                        </div>\n' +
                        '                    </div>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        footer: errorMessage
                    })
                },
            })
        });
    });
</script>
</body>
<!-- This system developed by DataTech BD ltd. Phone: 01304734623-25 | info@datatechbd.com | 24-08-2020-->
</html>
