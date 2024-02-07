@extends('admin.layout.app')
@push('title') {{ __('Profile') }} @endpush
@push('head')

@endpush
@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title">{{ auth()->user()->full_name }} {{ __('Profile') }}</h4>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row ">
                <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                    <div class="profile-card-4">
                        <div class="card">
                            <div class="card-body text-center bg-primary rounded-top">
                                <div class="user-box">
                                    <img src="{{ asset(auth()->user()->image ?? get_static_option('no_image')) }}" alt="user avatar"/>
                                </div>
                                <h5 class="mb-1 text-white">{{ auth()->user()->full_name }}</h5>
                                <h6 class="text-light">{{ auth()->user()->phone }}</h6>
                                <div class="align-self-end">
                                    <button id="change-password" class="btn btn-success">{{ __('Change Password') }}</button>
                                </div>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                        <div class="card-body border-bottom">
                            <div class="row">
                                <div class="container">
                                    <form action="{{ route('updateUsersSelfProfileInfo') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group mt-3">
                                                    <input type="text" required name="full_name" placeholder="Full Name"  class="form-control" value="{{ auth()->user()->full_name }}"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mt-3">
                                                    <input type="text" required name="user_name" placeholder="Username"  class="form-control" value="{{ auth()->user()->user_name }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group mt-3">
                                                    <input type="text" name="phone" required placeholder="Phone" class="form-control" value="{{ auth()->user()->phone }}"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mt-3">
                                                    <input type="text" name="email" placeholder="Email" required class="form-control"   value="{{ auth()->user()->email }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group mt-3">
                                                    <select class="form-control"  name="gender" >
                                                        <option @if(auth()->user()->gender == 'male') selected @endif value="male">{{ __('Male') }}</option>
                                                        <option @if(auth()->user()->gender == 'female') selected @endif value="female">{{ __('Female') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mt-3">
                                                    <label for="profile_image">{{ __('Profile') }}</label>
                                                    <input accept="image/*" type="file" name="profile_image" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group mt-3">
                                                    <input type="submit" class="form-control bg-primary"/>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-lg-2"></div>
            </div>

        </div>
        <!-- End container-fluid-->
    </div><!--End content-wrapper-->

    <script>
        $(document).ready(function() {
            $('#change-password').click(function(){
                Swal.fire({
                    title: ' Write password ',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Set',
                    showLoaderOnConfirm: true,
                    preConfirm: (password) => {
                        var formData = new FormData();
                        formData.append('password', password)
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('authedUserPasswordChange') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            processData: false,
                            contentType: false,
                            beforeSend: function (){
                                $(this).prop("disabled",true);
                            },
                            complete: function (){
                                $(this).prop("disabled",false);
                            },
                            success: function (data) {
                                if (data.type == 'success'){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: data.type,
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    setTimeout(function() {
                                        location.reload();
                                    }, 800);//
                                }else{
                                    Swal.fire({
                                        icon: data.type,
                                        title: 'Oops...',
                                        text: data.message,
                                        footer: 'Something went wrong!'
                                    });
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
                                });
                            },
                        });
                    },
                });
            });
        });
    </script>
@endsection

