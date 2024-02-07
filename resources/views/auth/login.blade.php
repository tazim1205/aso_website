<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASO - Sign In</title>
    <meta name="author" content="{{ get_static_option('author_name') ?? 'No author' }}">
    <meta name="description" content="{{ get_static_option('author_description') ?? 'No description' }}" />
    <meta property="og:image" content="{{ asset(get_static_option('meta_image')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="login-area">
        <div class="login-content">
            <div class="login-img">
                <img src="{{ asset('frontend/image/Tablet login-bro 1 (3).png') }}" alt="Log in Image">
            </div>            
            <div class="login-form">
                @include('includes.message')
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="number" name="phone" placeholder="{{ __('Mobile number') }}" value="{{ old('phone') }}" class="@error('phone') is-invalid @enderror" required autofocus>
                    @error('phone')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <input type="password" name="password" placeholder="{{ __('Password') }}" class="@error('password') is-invalid @enderror" required>
                    @error('password')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <input type="submit" value="Log in">
                </form>
                <p class="forget-pass-1" style="cursor: pointer">{{ __('পাসওয়ার্ড ভুলে গেছেন?') }}</p>
            </div>
            <div class="login-footer">
                <p>আপনার কোনো অ্যাকাউন্ট নেই? <a href="{{ route('register') }}">এখনই সাইন আপ করুন</a></p>
            </div>
        </div>
    </div>
    <div class="forget-pass">
        <div>
            <h3>Reset Password</h3>
        </div>
        <div>

        </div>
        <div><i class="fa-solid fa-unlock"></i></div>
        <input type="number" id="phone-number" placeholder="Phone Nmuner">
        <input type="button" id="reset-btn" value="RESET PASSWORD">
        <p>পাসওয়ার্ড মনে পড়েছে <a href="#" class="forget-pass-1">সাইন ইন করুন</a></p>
    </div>
    <script src="https://kit.fontawesome.com/45a0bcfe23.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js">
    </script>
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#reset-btn').click(function (){
                $("#reset-btn").prop("disabled", true);
                var formData = new FormData();
                formData.append('phone', $('#phone-number').val())
                $.ajax({
                    method: 'POST',
                    url: "{{ route('resetPassword') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#reset-btn").prop("disabled", false);
                        console.log(data)
                       var successMessage =
                       '<div class="alert alert-'+data.type+'" role="alert">\n' +
                       data.message+
                       '                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                       '                    <span aria-hidden="true">×</span>\n' +
                       '                </button>\n' +
                       '            </div>'
    
                        $('.error').html(successMessage)
                        location.replace(data.url)
                    },
                    error: function (xhr) {
                        console.log(xhr);
                        $("#reset-btn").prop("disabled", false);
                        var errorMessage = '' +
                            '<div class="alert alert-danger" role="alert">';
                        $.each(xhr.responseJSON.errors, function(key,value) {
                            errorMessage +=(''+value+'<br>');
                        });
                        errorMessage +='<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '                    <span aria-hidden="true">×</span>\n' +
                            '                </button>\n' +
                            '            </div>';
    
                        $('.error').html(errorMessage)
    
                        //console.log(errorMessage)
                    },
                })
            });
        });
    </script>
    @include('sweetalert::alert')
</body>

</html>