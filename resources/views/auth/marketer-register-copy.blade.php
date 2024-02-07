<!doctype html>
<html lang="{{  App::getLocale() }}" class="deeppurple-theme">
<!-- This system developed by DataTech BD ltd. Phone: 01304734623-25 | info@datatechbd.com | 23-08-2020-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <title>  {{ __('Marketer Sign up') }} | {{ get_static_option('name') }}</title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}"/>
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <style>


#regForm {
  /*background-color: #ffffff;*/
  margin: 100px auto;
  font-family: Raleway;
  /*padding: 40px;*/
  /*width: 70%;*/
  /*min-width: 300px;*/
}

h1 {
  text-align: center;  
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
  /*border-radius: 10%;*/
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #04AA6D;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

.prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #04AA6D;
}
</style>

    <div class="row no-gutters login-row">
        <div class="col align-self-center px-3 text-center">
            <br>
            <br>
            <br>
            <a href="{{ route('welcome') }}"><img src="{{ asset( get_static_option('logo')  ?? 'uploads/images/defaults/logo.png') }}" alt="logo" class="logo-small"></a>

            <h4 class="mt-3">{{ __('মার্কেটার সাইন আপ') }}</h4>
           {{--  <a href="{{ route('language') }}">
                <img height="30px;" width="30px;" src="{{ asset(  'uploads/images/defaults/language-icon-bd-en.png') }}" alt="logo" class="">
                @if(current_language() != 'en')
                    বাংলা
                @else
                    English
                @endif
            </a> --}}
            <form id="regForm" class="form-signin mt-3 p-2" method="post" enctype="multipart/form-data">
                @csrf
                <!-- One "tab" for each step in the form: -->
                <div class="tab phone-tab d-block mb-2">
                    <p class="mt-2"><b>{{ __('Verification করতে আপনার মোবাইল নাম্বার দিন') }}</b></p>
                    <div class="form-group">
                        <input type="number" id="phone" class="form-control form-control-lg text-center"  placeholder="{{ __('Mobile Number') }}" required>
                        <span id="error_phone" class="text-danger"></span>
                    </div>
                    <button type="button" class="next" id="phonBtnNext" >Next</button>
                </div>
                <div class="tab otp-tab d-none mb-2">
                    <p class="mt-2 mb-0"><b>{{ __('Check Your Mobile & Enter Your OTP') }}</b></p>
                    <small class="text-danger" style="font-size: 11px;">If you don't get OTP then click on previous button & try again.</small>
                    <div class="form-group ">
                        <input type="number" id="otp" class="form-control form-control-lg text-center"  placeholder="{{ __('OTP') }}" required>
                        <span id="error_otp" class="text-danger"></span>
                    </div>
                    <button type="button" class="prevBtn" id="otpBtnPrev">Previous</button>
                    <button type="button" class="next" id="otpBtnNext">Next</button>
                </div>
                <div class="tab personal-tab d-none mb-2">
                    <p class="mt-2"><b>{{ __('Personal Information') }}</b></p>
                    <div class="form-group ">
                        <input type="text" id="full-name" class="form-control form-control-lg text-center" placeholder="{{ __('Full Name') }}" required >
                        <span id="error_fullname" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" minlength="6" maxlength="6" id="referral" class="form-control form-control-lg text-center" placeholder="{{ __('Referral code') }}">
                    </div>
                    <div class="form-group">
                        <small>{{ __('Select the District /Metropolitan Thana you want to take service.') }}</small>
                        <select class="form-control form-control-lg" id="district-id">
                            <option selected disabled> {{ __('Chose district') }}</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ __($district->name) }}</option>
                            @endforeach
                        </select>
                        <span id="error_district" class="text-danger"></span>
                    </div>
                    <div class="form-group" id="upazila_group">
                        <small>{{ __('Select the Upazila /Metropolitan Thana you want to take service.') }}</small>
                        <select class="form-control form-control-lg" id="upazila-id">
                            <option selected disabled value="" id="upazila-loader">
                                <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                            </option>
                            <!-- Insert by ajax -->
                        </select>
                        <span id="error_upazila" class="text-danger"></span>
                    </div>
                    <div class="form-group" id="pouroshova_group">
                        <small>{{ __('Select the Pouroshova /Union you want to take service.') }}</small>
                        <select class="form-control form-control-lg" id="pouroshova-id">
                            <option selected disabled value="" id="pouroshova-loader">
                                <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                            </option>
                            <!-- Insert by ajax -->
                        </select>
                        <span id="error_pouroshova" class="text-danger"></span>
                    </div>
                    <div class="form-group" id="word_group">
                        <small>{{ __('Select the Word /Road you want to take service.') }}</small>
                        <select class="form-control form-control-lg" id="word-id">
                            <option selected disabled value="" id="word-loader">
                                <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                            </option>
                            <!-- Insert by ajax -->
                        </select>
                        <span id="error_word" class="text-danger"></span>
                    </div>
                    <div class="form-group row mx-0">
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
                    <div class="form-group"> 
                        <textarea id="address" class="form-control form-control-lg text-center" placeholder="{{ __('Address') }}"></textarea>
                    </div>

                    <button type="button" class="prevBtn" id="personalInfoBtnPrev">Previous</button>
                    <button type="button" class="next" id="personalInfoBtnNext">Next</button>
                </div>
                <div class="tab signup-tab d-none mb-2">
                    <p class="mt-2"><b>{{ __('Sign Up Details') }}</b></p>
                    <div class="form-group">
                        <input type="text" id="user-name" class="form-control form-control-lg text-center" placeholder="{{ __('Username') }}" required >
                        <span id="error_username" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" class="form-control form-control-lg text-center" placeholder="{{ __('Password') }}" required>
                        <span id="error_password" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="confirm-password" class="form-control form-control-lg text-center" placeholder="{{ __('Confirm Password') }}" required>
                        <span id="error_confirmpassword" class="text-danger"></span>
                    </div>
                    <button type="button" class="prevBtn" id="sinupBtnPrev">Previous</button>
                    <button type="button" class="next" id="register">Sign Up</button>
                </div>
                {{-- <div style="overflow:auto;">
                    <div style="float:center;">
                        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                        <button type="button" class="next" id="nextBtn" onclick="nextPrev(1)">Next</button>
                    </div>
                </div> --}}
                <!-- Circles which indicates the steps of the form: -->
                
            </form>
            <p class="mt-4 d-block text-secondary">
                {{ __('সাইন আপ এ ক্লিক করে আপনি') }}
                <a data-toggle="modal" data-target="#privacyPolicyModal">{{ __('Privacy-policy') }}</a> ,
                <a data-toggle="modal" data-target="#termsConditionModal">{{ __('Terms and condition') }}</a>
                {{ __('এ সম্মত হচ্ছেন।') }}
            </p>
            <hr>
            <p class="mt-4 d-block text-secondary">
                <a href="{{ route('register') }}">{{ __('কাস্টমার সাইন আপ') }}</a>&nbsp;|
                <a href="{{ route('getWorkerRegisterForm') }}">{{ __('সার্ভিস প্রোভাইডার সাইন আপ') }}</a>&nbsp;      
            </p>
        </div>
    </div>

   
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
<!-- page level script -->
<script>
    $(document).ready(function(){

        //Hide upazila first
        $("#upazila_group").hide()
        $("#pouroshova_group").hide()
        $("#word_group").hide()
        //Get upazila after click on district
        $("#district-id").change(function(){
            var districtId = $(this).val();
            $("#upazila_group").show() //now show district
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

        $("#upazila-id").change(function(){
            var upazila = $(this).val();
            $("#pouroshova_group").show() //now show district
            $.ajax({
                method: 'POST',
                url: '/guest/get/pouroshava-of-a-upazila',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { upazila: upazila},
                dataType: 'JSON',
                beforeSend: function (){
                    $("#pouroshova-loader").show()
                },
                complete: function (){
                    $("#pouroshova-loader").hide()
                },
                success: function (response) {
                    //console.log(response)
                    var pouroshovaOption='<option selected disabled> Chose pouroshova</option>';
                    response.forEach(function(pouroshova){
                        pouroshovaOption += '<option value='+pouroshova.id+'>'+pouroshova.name+'</option>';
                    })
                    $("#pouroshova-id").html(pouroshovaOption)
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

        $("#pouroshova-id").change(function(){
            var pouroshova = $(this).val();
            $("#word_group").show() //now show district
            $.ajax({
                method: 'POST',
                url: '/guest/get/word-of-a-pouroshava',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { pouroshova: pouroshova},
                dataType: 'JSON',
                beforeSend: function (){
                    $("#word-loader").show()
                },
                complete: function (){
                    $("#word-loader").hide()
                },
                success: function (response) {
                    //console.log(response)
                    var wordOption='<option selected disabled> Chose word</option>';
                    response.forEach(function(word){
                        wordOption += '<option value='+word.id+'>'+word.name+'</option>';
                    })
                    $("#word-id").html(wordOption)
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


        $('#phonBtnNext').click(function(){
            $("#phonBtnNext").prop("disabled", true);
            var error_phone = '';
         
            if($.trim($('#phone').val()).length == 0){
                error_phone = 'Phone is required';
                $('#error_phone').text(error_phone);
                $('#phone').addClass('has-error');
                $("#phonBtnNext").prop("disabled", false);
            }else{
                error_phone = '';
                $('#error_phone').text(error_phone);
                $('#phone').removeClass('has-error');
                $("#phonBtnNext").prop("disabled", false);
            }

            if(error_phone != ''){
                return false;
                $("#phonBtnNext").prop("disabled", false);
            }else{
                var phone = $('#phone').val();
                $.ajax({
                    url: "{{  url('/send/registration/otp/') }}/"+phone,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        $("#phonBtnNext").prop("disabled", false);
                        if(data.success){
                            Swal.fire({
                                position: 'top-end',
                                icon: data.type,
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('.phone-tab').removeClass('d-block');
                            $('.phone-tab').addClass('d-none');
                            $('.otp-tab').removeClass('d-none');
                            $('.otp-tab').addClass('d-block');
                        }else if(data.error){
                            Swal.fire({
                                position: 'top-end',
                                icon: data.type,
                                title: data.error,
                                showConfirmButton: false,
                                timer: 3000
                            })
                            $('.phone-tab').removeClass('d-block');
                            $('.phone-tab').addClass('d-none');
                            $('.otp-tab').removeClass('d-none');
                            $('.otp-tab').addClass('d-block');
                        }else{
                            return false;
                        }
                    },
                });
            }
        });
         
        $('#otpBtnPrev').click(function(){
            $('.phone-tab').removeClass('d-none');
            $('.phone-tab').addClass('d-block');
            $('.otp-tab').removeClass('d-block');
            $('.otp-tab').addClass('d-none');
        });
         
        $('#otpBtnNext').click(function(){
         $("#otpBtnNext").prop("disabled", true);
            var error_otp = '';
         
            if($.trim($('#otp').val()).length == 0){
                error_otp = 'OTP is required';
                $('#error_otp').text(error_otp);
                $('#otp').addClass('has-error');
                $("#otpBtnNext").prop("disabled", false);
            }else{
                error_otp = '';
                $('#error_otp').text(error_otp);
                $('#otp').removeClass('has-error');
                $("#otpBtnNext").prop("disabled", false);
            }

            if(error_otp != ''){
                return false;
                $("#otpBtnNext").prop("disabled", false);
            }else{
                var phone = $('#phone').val();
                var otp = $('#otp').val();
                $.ajax({
                    url: "{{  url('/check/registration/otp/') }}/"+phone+"/"+otp,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        $("#otpBtnNext").prop("disabled", false);
                        if(data.success){
                            Swal.fire({
                                position: 'top-end',
                                icon: data.type,
                                title: data.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('.otp-tab').removeClass('d-block');
                            $('.otp-tab').addClass('d-none');
                            $('.personal-tab').removeClass('d-none');
                            $('.personal-tab').addClass('d-block');
                        }else if(data.error){
                            $('#error_otp').text(data.error);
                        }else{
                            return false;
                        }
                    },
                });
            }
        });

        $('#personalInfoBtnPrev').click(function(){
            $('.otp-tab').removeClass('d-none');
            $('.otp-tab').addClass('d-block');
            $('.personal-tab').removeClass('d-block');
            $('.personal-tab').addClass('d-none');
        });

        $('#personalInfoBtnNext').click(function(){
            $("#personalInfoBtnNext").prop("disabled", true);
            var error_fullname = '';
            var error_district = '';
          
            if($.trim($('#full-name').val()).length == 0){
                error_fullname = 'Full Name is required';
                $('#error_fullname').text(error_fullname);
                $('#full-name').addClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }else{
                error_fullname = '';
                $('#error_fullname').text(error_fullname);
                $('#full-name').removeClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }

            if($.trim($('#district-id').val()).length == 0){
                error_district = 'District is required';
                $('#error_district').text(error_district);
                $('#district-id').addClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }else{
                error_district = '';
                $('#error_district').text(error_district);
                $('#district-id').removeClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }

          
            if(error_fullname != '' || error_district != ''){
                return false;
                $("#personalInfoBtnNext").prop("disabled", false);
            }else{
                $('.personal-tab').removeClass('d-block');
                $('.personal-tab').addClass('d-none');
                $('.signup-tab').removeClass('d-none');
                $('.signup-tab').addClass('d-block');
                $("#personalInfoBtnNext").prop("disabled", false);
            }
        });
         
        $('#sinupBtnPrev').click(function(){
            $('.personal-tab').removeClass('d-none');
            $('.personal-tab').addClass('d-block');
            $('.signup-tab').removeClass('d-block');
            $('.signup-tab').addClass('d-none');
        });
         
        $('#register').click(function(){
            $("#register").prop("disabled", true);
            var error_username = '';
            var error_password = '';
            var error_confirmpassword = '';

            if($.trim($('#user-name').val()).length == 0){
                error_username = 'Username is required';
                $('#error_username').text(error_username);
                $('#user-name').addClass('has-error');
                $("#register").prop("disabled", false);
            }else{
                error_username = '';
                $('#error_username').text(error_username);
                $('#user-name').removeClass('has-error');
                $("#register").prop("disabled", false);
            }

            if($.trim($('#password').val()).length == 0){
                error_password = 'Password is required';
                $('#error_password').text(error_password);
                $('#password').addClass('has-error');
                $("#register").prop("disabled", false);
            }else{

                error_password = '';
                $('#error_password').text(error_password);
                $('#password').removeClass('has-error');
                $("#register").prop("disabled", false);
            }

            if($.trim($('#confirm-password').val()).length == 0){
                error_confirmpassword = 'Password is required';
                $('#error_confirmpassword').text(error_confirmpassword);
                $('#confirm-password').addClass('has-error');
                $("#register").prop("disabled", false);
            }else{
                // if ($('#password').val() == $('#confirm-password').val()){
                //     error_confirmpassword = 'Password not match';
                //     $('#error_confirmpassword').text(error_confirmpassword);
                //     $('#confirm-password').addClass('has-error');
                // }else{
                    error_confirmpassword = '';
                    $('#error_confirmpassword').text(error_confirmpassword);
                    $('#confirm-password').removeClass('has-error');
                    $("#register").prop("disabled", false);
                // }
            }
          
            if(error_username != '' || error_password != '' || error_confirmpassword != ''){
                return false;
                $("#register").prop("disabled", false);
            }else{
               //console.log(getInput());
                var userName = $('#user-name').val();
                var fullName = $('#full-name').val();
                var phone = $('#phone').val();
                var password = $('#password').val();
                var confirmPassword = $('#confirm-password').val();
                var referralCode = $('#referral').val();
                var districtId = $('#district-id').val();
                var upazilaId = $('#upazila-id').val();
                var pouroshovaId = $('#pouroshova-id').val();
                var wordId = $('#word-id').val();
                var gender = $('.gender:checked').val();
                var address = $('#address').val();
                

                var formData = new FormData();
                formData.append('userName', userName)
                formData.append('fullName', fullName)
                formData.append('phone', phone)
                formData.append('password', password)
                formData.append('password_confirmation', confirmPassword)
                formData.append('referralCode', referralCode)
                formData.append('district', districtId)
                formData.append('upazila', upazilaId)
                formData.append('pouroshova', pouroshovaId)
                formData.append('word', wordId)
                formData.append('gender', gender)
                formData.append('address', address)

                $.ajax({
                    method: 'POST',
                    url: "{{ route('submitMarketerRegister') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#register").prop("disabled", false);
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
                                window.location = "{{ route('marketer.home.index') }}";
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
                        $("#register").prop("disabled", false);
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
            }
        });

    });
</script>
</body>
<!-- This system developed by DataTech BD ltd. Phone: 01304734623-25 | info@datatechbd.com | 24-08-2020-->
</html>
