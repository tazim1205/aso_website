<!doctype html>
<html lang="{{  App::getLocale() }}" >
<!-- This system developed by DataTech BD ltd. Phone: 01304734623-25 | info@datatechbd.com | 23-08-2020-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Service Provider Sign Up') }} | {{ get_static_option('name') }}</title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}"/>
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/toast/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">

    <!--SweetAlert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!--Select2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<style>


.login-form{
    text-align: center;
}
.login-form button {
    display: block;
    margin: 0 auto 15px;
    width: 328px;
    height: 48px;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    padding: 0 15px;
    background: transparent;
}
.login-form .btn-next {
    background: var(--btn-bg-color);
    color: var(--btn-color);
    font-weight: 600;
    cursor: pointer;
}
.login-form .btn-prev{
    cursor: pointer;
    color: var(--border-color);
    text-align: center;
    font-size: 12px;
    font-weight: 600;
}
.pre-next .btn-prev:hover {
    background: var(--btn-bg-color);
    color: #fff;
}
.login-form p {
    font-size: var(--text-size);
    line-height: 14.52px;
    margin-bottom: 7px;
}
.login-form h4 {
    color: red;
    font-size: 12px;
    margin-bottom: 15px;
}
.pre-next {
    display: flex;
    justify-content: center;
}
.pre-next button {
    height: 40px;
    width: 150px;
    margin: 5px;
}
.login-form h2 {
    font-size: var(--h-size);
    color: var(--text-color);
    font-weight: 500;
    margin-bottom: 10px;
}
.radio {
    width: 140px;
    height: 15px;
    display: flex;
    margin: 10px auto;
}

.login-form input {
    width: 328px;
    height: 45px;
    padding: 10px 15px;
}

.radio input{
    width: 14px !important;
    height: 11px !important;
}

</style>

<body style="padding: 1%;">

<div class="login-area">


    <div class="row no-gutters login-row">
        <div class="col align-self-center px-3 text-center mt-4">
            <div class="login-img">
                <img src="{{ asset('frontend/image/Mobile login-bro 1.png') }}" alt="Log in Image">
            </div>
            <div class="login-info">
                <h2>সার্ভিস প্রোভাইডার সাইন আপ</h2>
                <p>Verification করতে আপনার মোবাইল নাম্বার দিন</p>
            </div>
            <form id="regForm" class="form-signin mt-3 p-2" method="post" enctype="multipart/form-data">
                @csrf
                <div class="login-form">
                    <!-- One "tab" for each step in the form: -->
                    <div class="tab phone-tab d-block mb-2">
                        <div class="form-group">
                            <input type="number" id="phone" name="number" placeholder="Mobile number">
                            <span id="error_phone" class="text-danger"></span>
                        </div>
                        <input type="button" class="btn-next" id="phonBtnNext" value="Next">
                        <!-- <button type="button" class="btn-next" id="phonBtnNext">Next</button> -->
                    </div>
                    <div class="tab otp-tab d-none mb-2">
                        <p class="mt-2 mb-0"><b>{{ __('Check Your Mobile & Enter Your OTP') }}</b></p>
                        <label class="text-danger" style="font-size: 11px;">If you don't get OTP then click on previous button & try again.</label>
                        <div class="form-group ">
                            <input type="number" id="otp" placeholder="{{ __('OTP') }}" required>
                            <span id="error_otp" class="text-danger"></span>
                        </div>
                        <div class="pre-next">
                            <button type="button" class="prevBtn btn-prev btn-n-1" id="otpBtnPrev">Previous</button>
                            <button type="button" class="next btn-next" id="otpBtnNext">Next</button>
                        </div>
                    </div>
                    <div class="tab personal-tab d-none mb-2">
                        <p class="mt-2"><b>{{ __('Personal Information') }}</b></p>
                        <div class="form-group ">
                            <input type="text" id="full-name" placeholder="{{ __('Full Name') }}" required >
                            <span id="error_fullname" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" minlength="6" maxlength="6" id="referral" placeholder="{{ __('Referral code') }}">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Select the District /Metropolitan Thana you want to take service.') }}</label>
                            <select class="form-select" id="district-id">
                                <option selected disabled> {{ __('Chose district') }}</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ __($district->name) }}</option>
                                @endforeach
                            </select>
                            <span id="error_district" class="text-danger"></span>
                        </div>
                        <div class="form-group" id="upazila_group">
                            <label>{{ __('Select the Upazila /Metropolitan Thana you want to take service.') }}</label>
                            <select class="form-select"  id="upazila-id">
                                <option selected disabled value="" id="upazila-loader">
                                    <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                                </option>
                                <!-- Insert by ajax -->
                            </select>
                            <span id="error_upazila" class="text-danger"></span>
                        </div>
                        <div class="form-group" id="pouroshova_group">
                            <label>{{ __('Select the Pouroshova /Union you want to take service.') }}</label>
                            <select multiple = "multiple" id="pouroshova-id">
                                <option selected disabled value="" id="pouroshova-loader">
                                    <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                                </option>
                                <!-- Insert by ajax -->
                            </select>
                            <span id="error_pouroshova" class="text-danger"></span>
                        </div>
                        {{-- <div class="form-group" id="word_group">
                            <label>{{ __('Select the Word /Road you want to take service.') }}</label>
                            <select multiple = "multiple" id="word-id">
                                <option selected disabled value="" id="word-loader">
                                    <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                                </option>
                                <!-- Insert by ajax -->
                            </select>
                            <span id="error_word" class="text-danger"></span>
                        </div> --}}

                        <!-- Start category -->
                        <div class="form-group">
                            <label for="">{{ __('Select the Categories you want to take service.') }}</label>
                            <select name="worker_service" id="worker_service" multiple="multiple">
                                @foreach($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach($category->services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <span id="error_service" class="text-danger"></span>
                        </div>
                        <!-- End category -->

                        <!-- Start services -->
                        {{-- <div class="form-group">
                            <select multiple="" id="services-id">
                                <option selected disabled value="" id="services-loader">
                                    <span class="badge badge-warning mb-1">Loading ...</span>
                                </option>
                                <!-- Insert by ajax -->
                            </select>
                        </div> --}}
                        <!-- End services -->

                        <!-- Start NID  -->
                        <div class="form-group">
                            <label>{{ __('NID front side') }}</label>
                            <input type="file" id="nid-front">
                            <span id="error_nid_front" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>{{ __('NID back side') }}</label>
                            <input type="file" id="nid-back">
                            <span id="error_nid_back" class="text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label>{{ __('License Document') }}</label>
                            <input type="file" id="license-documents">
                        </div>

                        <div class="form-group">
                            <input type="text" minlength="" maxlength="" id="nid-number" placeholder="{{ __('NID Number') }}">
                            <span id="error_nid_number" class="text-danger"></span>
                        </div>
                        <!-- End NID  -->
                        <div class="radio">
                            <input type="radio" name="gender" class="custom-control-input gender" id="male" value="male">
                            <label for="Male">Male</label>
                            <input type="radio" name="gender" class="custom-control-input gender" id="female" value="female">
                            <label for="Male">Female</label>
                        </div>
                        <div class="pre-next">
                            <button type="button" class="prevBtn btn-prev btn-n-1" id="otpBtnPrev">Previous</button>
                            <button type="button" class="next btn-next" id="otpBtnNext">Next</button>
                        </div>
                    </div>
                    <div class="tab signup-tab d-none mb-2">
                        <p class="mt-2"><b>{{ __('Sign Up Details') }}</b></p>
                        <div class="form-group">
                            <input type="text" id="user-name" placeholder="{{ __('Username') }}" required >
                            <span id="error_username" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" placeholder="{{ __('Password') }}" required>
                            <span id="error_password" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" id="confirm-password" placeholder="{{ __('Confirm Password') }}" required>
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
                </div>
                
            </form>
            <div class="condition-area">
                <p>সাইন আপ এ ক্লিক করে আপনি <a href="#" class="privacy-1"> Privacy-policy,
                        Terms and condition  </a>  এ সম্মত হচ্ছেন।</p>
            </div>
            <div class="s-5-footer">
                <p>
                    <a href="{{ route('register') }}">{{ __('কাস্টমার সাইন আপ') }} | </a>
                    <a href="{{ route('getMarketerRegisterForm') }}">{{ __('মার্কেটার সাইন আপ') }} |</a>
                    <a href="{{ route('login') }}">{{ __('লগ ইন করুন') }}</a>
                </p>
            </div>
        </div>
    </div>

   
</div>


@include('auth.partials.privacy-policy')
<!-- jquery, popper and bootstrap js -->
<script src="{{ asset('assets/mobile/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/mobile/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/mobile/vendor/bootstrap-4.4.1/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/custom.js') }}"></script>

{{-- select2 script link  --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- page level script -->
<!-- page level script -->
<script>
    $(document).ready(function(){

        $("#worker_service").select2({
            placeholder: "Search Category",
            allowClear: true,
        });

        $("#pouroshova-id").select2({
            placeholder: "Search Pouroshova",
            allowClear: true,
        });

        $("#word-id").select2({
            placeholder: "Search Road",
            allowClear: true,
        });

        //Hide upazila first
        $("#upazila_group").hide()
        $("#pouroshova_group").hide()
        $("#word_group").hide()

        $("#services-id").hide()

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
            $("#pouroshova_group").show(); //now show district
            $("#word_group").show(); //now show district
            $.ajax({
                method: 'POST',
                url: '/guest/get/pouroshava-of-a-upazila-html',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { upazila: upazila},
                dataType: 'JSON',
                beforeSend: function (){
                    $("#pouroshova-loader").show();
                    $("#word-loader").show()
                },
                complete: function (){
                    $("#pouroshova-loader").hide();
                    $("#word-loader").hide()
                },
                success: function (response) {
                    //console.log(response)
                    // var pouroshovaOption='';
                    // response.forEach(function(pouroshova){
                    //     pouroshovaOption += '<option value='+pouroshova.id+'>'+pouroshova.name+'</option>';
                    // })
                    $("#pouroshova-id").empty();
                    $("#pouroshova-id").html(response);

                    $("#pouroshova-id").select2({
                        placeholder: "Search Pouroshova",
                        allowClear: true,
                    });

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
                $("#phonBtnNext").prop("disabled", false);
                return false;
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
                $("#otpBtnNext").prop("disabled", false);
                return false;
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

            // var error_category = '';
            var error_service = '';
            var error_nid_front = '';
            var error_nid_back = '';
            var error_nid_number = '';
          
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

            if($.trim($('#worker_service').val()).length == 0){
                error_service = 'Service is required';
                $('#error_service').text(error_service);
                $('#worker_service').addClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }else{
                error_service = '';
                $('#error_service').text(error_service);
                $('#worker_service').removeClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }

            if($.trim($('#nid-front').val()).length == 0){
                error_nid_front = 'Nid Front is required';
                $('#error_nid_front').text(error_nid_front);
                $('#nid-front').addClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }else{
                error_nid_front = '';
                $('#error_nid_front').text(error_nid_front);
                $('#nid-front').removeClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }

            if($.trim($('#nid-back').val()).length == 0){
                error_nid_back = 'Nid Back is required';
                $('#error_nid_back').text(error_nid_back);
                $('#nid-back').addClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }else{
                error_nid_back = '';
                $('#error_nid_back').text(error_nid_back);
                $('#nid-back').removeClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }

            if($.trim($('#nid-number').val()).length == 0){
                error_nid_number = 'Nid Number is required';
                $('#error_nid_number').text(error_nid_number);
                $('#nid-number').addClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }else{
                error_nid_number = '';
                $('#error_nid_number').text(error_nid_number);
                $('#nid-number').removeClass('has-error');
                $("#personalInfoBtnNext").prop("disabled", false);
            }


          
            if(error_fullname != '' || error_district != '' || error_service != '' || error_nid_front != '' || error_nid_back != '' || error_nid_number != ''){
                return false;
            }else{
                $('.personal-tab').removeClass('d-block');
                $('.personal-tab').addClass('d-none');
                $('.signup-tab').removeClass('d-none');
                $('.signup-tab').addClass('d-block');
            }
        });
         
        $('#sinupBtnPrev').click(function(){
            alert();
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
                    error_confirmpassword = '';
                    $('#error_confirmpassword').text(error_confirmpassword);
                    $('#confirm-password').removeClass('has-error');
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
                // var wordId = $('#word-id').val();
                var serviceId = $('#worker_service').val();
                var gender = $('.gender:checked').val();
                var nidNumber = $('#nid-number').val();
                var nidFrontImage = $('#nid-front')[0].files[0];
                var nidBackImage = $('#nid-back')[0].files[0];
                var licenseDocuments = $('#license-documents')[0].files[0];
                
                // alert(serviceId);

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
                // formData.append('word', wordId)

                formData.append('services', serviceId)

                // formData.append('services', servicesId)
                formData.append('gender', gender)
                formData.append('nidNumber', nidNumber)
                formData.append('nidFrontImage', nidFrontImage)
                formData.append('nidBackImage', nidBackImage)
                formData.append('licenseDocuments', licenseDocuments)

                $.ajax({
                    method: 'POST',
                    url: "{{ route('submitWorkerRegister') }}",
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
                                window.location = "{{ route('worker.home.index') }}";
                            }, 1000); //1 second
                        }else{
                            Swal.fire({
                                icon: data.type,
                                title: 'Successfully Account Created',
                                text: data.message,
                                footer: ''
                            })
                            setTimeout(function(){ location.replace(data.url) }, 3000);
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
