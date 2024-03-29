<!DOCTYPE html>
<html lang="{{  App::getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Marketer Sign up') }} | {{ get_static_option('name') }}</title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}"/>
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/toast/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">

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
    </style>
</head>
<body>
<div class="login-area">
    <div class="login-content">

        <div class="login-img">
            <img src="{{ asset('frontend/image/Tablet login-bro 1 (3).png') }}" alt="Log in Image">
        </div>
        <div class="login-info">
            <h2>{{ __('মার্কেটার সাইন আপ') }}</h2>
        </div>
        <form>
            <div class="login-form">
                <div id="mobile_number">
                    <p>Sign Up করতে আপনার মোবাইল নাম্বার দিন</p>
                    <input type="number" id="phone" name="number" placeholder="Mobile number">
                    <span id="error_phone" class="text-danger"></span>
                    <button type="button" class="btn-next" id="phonBtnNext">Next</button>
                </div>
                <div id="otp" style="display: none">
                    <p>Check Your Mobile & Enter Your OTP</p>
                    <h4>if you don't get OTP then click on previous button & try again</h4>
                    <input type="number" id="otp_val" name="otp" placeholder="OTP">
                    <span id="error_otp" class="text-danger"></span>
                    <div class="pre-next">
                        <button type="button" class="btn-prev btn-n-1" id="otpBtnPrev">Previous</button>
                        <button type="button" class="btn-next" id="otpBtnNext">Next</button>
                    </div>
                </div>
                <div id="personal" style="display: none">
                    <h2>Personal Information</h2>
                    <input type="text" name="Full Name" id="full-name" placeholder="Full name">
                    <span id="error_fullname" class="text-danger"></span>
                    <input type="text" minlength="6" maxlength="6" id="referral" placeholder="Referral Code (Optional) ">
                    <label>আপনার লোকেশন নির্বাচন করুন</label>
                    <select name="district" placeholder="District" id="district-id">
                        <option value="" disabled selected>জেলা </option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}">{{ __($district->name) }}</option>
                        @endforeach
                    </select>
                    <span id="error_district" class="text-danger"></span>
                    <div id="upazila_group">
                        <select name="Upzilla" placeholder="Upzilla" id="upazila-id">
                            <option selected disabled value="" id="upazila-loader">
                                <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                            </option>
                        </select>
                        <span id="error_upazila" class="text-danger"></span>
                    </div>
                    <div id="pouroshova_group">
                        <select name="Pouroshoba" placeholder="Pouroshoba" id="pouroshova-id">
                            <option selected disabled value="" id="pouroshova-loader">
                                <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                            </option>
                        </select>
                        <span id="error_pouroshova" class="text-danger"></span>
                    </div>
                    <div id="word_group">
                        <select name="Pouroshoba" placeholder="Pouroshoba" id="word-id">
                            <option selected disabled value="" id="word-loader">
                                <span class="badge badge-warning mb-1">{{ __('Loading ...') }}</span>
                            </option>
                        </select>
                        <span id="error_word" class="text-danger"></span>
                    </div>
                    <div class="radio">
                        <input type="radio" name="gender" id="male" value="male">
                        <label for="Male">Male</label>
                        <input type="radio" name="gender" id="female" value="female">
                        <label for="Male">Female</label>
                    </div>
                    <div class="pre-next">
                        <button type="button" class="btn-prev btn-n-1" id="personalInfoBtnPrev">Previous</button>
                        <button type="button" class="btn-next" id="personalInfoBtnNext">Next</button>
                    </div>
                </div>
                <div id="user_details" style="display: none">
                    <h2>User Details</h2>
                    <input type="text" id="user-name" name="User Name" placeholder="User name">
                    <span id="error_username" class="text-danger"></span>
                    <input type="password" id="password" name="Password" placeholder="Password">
                    <span id="error_password" class="text-danger"></span>
                    <input type="password" id="confirm-password" name="Password" placeholder=" Conform Password">
                    <span id="error_confirmpassword" class="text-danger"></span>
                    <div class="pre-next">
                        <button type="button" class="btn-prev btn-n-1" id="sinupBtnPrev">Previous</button>
                        <button type="button" class="btn-next" id="register">Sign Up</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="condition-area">
            <p>সাইন আপ এ ক্লিক করে আপনি
                <a href="#" class="privacy-1">Privacy-policy,Terms and condition </a>  এ সম্মত হচ্ছেন।</p>
        </div>
        <div class="s-5-footer">
            <p>
                <a href="{{ route('getWorkerRegisterForm') }}">{{ __('সার্ভিস প্রোভাইডার সাইন আপ') }} | </a>
                <a href="{{ route('register') }}">{{ __('কাস্টমার সাইন আপ') }} |</a>
                <a href="{{ route('login') }}">{{ __('লগ ইন করুন') }}</a>
            </p>
        </div>

    </div>
</div>
@include('auth.partials.privacy-policy')

<script src="https://kit.fontawesome.com/45a0bcfe23.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="{{ asset('frontend/toast/jquery.toast.min.js') }}"></script>
<script src="{{ asset('frontend/js/custom.js') }}"></script>
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

                    $.each(xhr.responseJSON.errors, function(key,value) {
                        console.log(value)
                    });

                    $.toast({
                        heading: 'Opps!',
                        position: 'top-right',
                        text: 'Something Went Wrong',
                        showHideTransition: 'slide',
                        icon: 'error'
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
                    $.each(xhr.responseJSON.errors, function(key,value) {
                        console.log(value)
                    });

                    $.toast({
                        heading: 'Opps!',
                        position: 'top-right',
                        text: 'Something Went Wrong',
                        showHideTransition: 'slide',
                        icon: 'error'
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
                    $.each(xhr.responseJSON.errors, function(key,value) {
                        console.log(value)
                    });

                    $.toast({
                        heading: 'Opps!',
                        position: 'top-right',
                        text: 'Something Went Wrong',
                        showHideTransition: 'slide',
                        icon: 'error'
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
            }else{
                var phone = $('#phone').val();
                $.ajax({
                    url: "{{  url('/send/registration/otp/') }}/"+phone,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        $("#phonBtnNext").prop("disabled", false);
                        if(data.success){
                            $.toast({
                                heading: 'Success',
                                position: 'top-right',
                                text: data.success,
                                showHideTransition: 'slide',
                                icon: 'success'
                            })
                            $('#mobile_number').hide();
                            $('#otp').show();
                        }else if(data.error){
                            $.toast({
                                heading: 'Error',
                                position: 'top-right',
                                text: data.error,
                                showHideTransition: 'slide',
                                icon: 'error'
                            })
                            $('#mobile_number').hide();
                            $('#otp').show();
                        }else{
                            return false;
                        }
                    },
                });
            }
        });

        $('#otpBtnPrev').click(function(){
            $('#mobile_number').show();
            $('#otp').hide();
        });

        $('#otpBtnNext').click(function(){
            $("#otpBtnNext").prop("disabled", true);
            var error_otp = '';

            if($.trim($('#otp_val').val()).length == 0){
                error_otp = 'OTP is required';
                $('#error_otp').text(error_otp);
                $('#otp_val').addClass('has-error');
                $("#otpBtnNext").prop("disabled", false);
            }else{
                error_otp = '';
                $('#error_otp').text(error_otp);
                $('#otp_val').removeClass('has-error');
                $("#otpBtnNext").prop("disabled", false);
            }

            if(error_otp != ''){
                return false;
            }else{
                var phone = $('#phone').val();
                var otp = $('#otp_val').val();
                $.ajax({
                    url: "{{  url('/check/registration/otp/') }}/"+phone+"/"+otp,
                    type:"GET",
                    dataType:"json",
                    success:function(data) {
                        $("#otpBtnNext").prop("disabled", false);
                        if(data.success){
                            $.toast({
                                heading: 'Success',
                                position: 'top-right',
                                text: data.success,
                                showHideTransition: 'slide',
                                icon: 'success'
                            })
                            $('#otp').hide();
                            $('#personal').show();
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
            $('#otp').show();
            $('#personal').hide();
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
            }else{
                $('#personal').hide();
                $('#user_details').show();
            }
        });

        $('#sinupBtnPrev').click(function(){
            $('#personal').show();
            $('#user_details').hide();
        });

        $('#register').click(function(){
            var error_username = '';
            var error_password = '';
            var error_confirmpassword = '';
            $("#register").prop("disabled", true);
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

            if($.trim($('#confirm-password').val()).length === 0){
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
                $("#register").prop("disabled", false);
                return false;
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
                            $.toast({
                                heading: 'Success!',
                                position: 'top-right',
                                text: data.message,
                                showHideTransition: 'slide',
                                icon: 'success'
                            })
                            setTimeout(function() {
                                //your code to be executed after 1 second
                                window.location = "{{ route('customer.home.index') }}";
                            }, 1000); //1 second
                        }else{
                            $.toast({
                                heading: 'Opps!',
                                position: 'top-right',
                                text: data.message,
                                showHideTransition: 'slide',
                                icon: 'error'
                            })
                        }
                    },
                    error: function (xhr) {
                        $.each(xhr.responseJSON.errors, function(key,value) {
                            console.log(value)
                            $.toast({
                                heading: 'Opps!',
                                position: 'top-right',
                                text: value,
                                showHideTransition: 'slide',
                                icon: 'error',
                                hideAfter: 5000,
                            })
                        });


                    },
                })
            }
        });

    });
</script>
</body>
</html>
