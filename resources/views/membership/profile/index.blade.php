@extends('membership.layout.app')
@push('title') {{ __('Profile') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="container">
        <div class="card shadow mt-4 h-190">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-60 border-0"><img src="{{ asset(auth()->user()->image ?? get_static_option('no_image')) }}" alt=""></figure>
                    </div>
                    <div class="col pl-0 align-self-center">
                        <h5 class="mb-1">{{ auth()->user()->full_name }}</h5>
                    </div>
                    <div class="col pl-0 align-self-end">
                       <button id="change-password" class="btn btn-success">{{ __('Change Password') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container top-100">
        <div class="card mb-4 shadow">
            {{-- <div class="card-body border-bottom">
                <div class="row">
                    <div class="col text-center">
                        <h3 class="mb-0 font-weight-normal">
                            {{ auth()->user()->referral->own }}
                        </h3>
                        <p class="text-mute">Referral</p>
                    </div>
                </div>
            </div> --}}
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
            {{-- <div class="card-footer bg-none">
                <div class="row">
                    <div class="col-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col align-self-center">
                                        <h5 class="mb-2 font-weight-normal">{{ auth()->user()->balance->referral_income }}</h5>
                                        <p class="text-mute">{{ __('Referral Income') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col align-self-center">
                                        <h5 class="mb-2 font-weight-normal">{{ auth()->user()->balance->withdrawn }}</h5>
                                        <p class="text-mute">{{ __('Withdrawn Amount') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    {{-- <div class="container">
        <div class="row">
            <div class="swiper-container icon-slide mb-4 swiper-container-horizontal">
                <div class="swiper-wrapper" style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);">
                    <a href="#" class="swiper-slide text-center swiper-slide-active" data-toggle="modal" data-target="#sendmoney">
                        <div class="avatar avatar-60 no-shadow border-0">
                            <div class="overlay"></div>
                            <i class="material-icons text-template">send</i>
                        </div>
                        <p class="small mt-2">{{ __('Withdraw Request') }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <h6 class="subtitle text-center"> {{ __('Useful Function') }} </h6>
        <div class="list-group list-group-flush">
            @foreach(get_all_static_pages() as $page)
                <a href="javaScript:void();" class="list-group-item" data-toggle="modal" data-target="#{{ $page->slug }}">
                    <h6 class="text-dark mb-0 font-weight-normal">@if(current_language() == 'bn') {{ $page->bn_name }} @else {{ $page->en_name }} @endif <i class="material-icons float-right">chevron_right</i></h6>
                </a>
            @endforeach
            <a href="javaScript:void();" onclick="logout()" class="list-group-item bg-dark text-white">
                <h6 class="text-white mb-0 font-weight-normal">{{ __('Logout') }} <i class="material-icons float-right">chevron_right</i></h6>
            </a>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#change-password').click(function(){
                Swal.fire({
                    title: ' Write password ',
                    html:
                    '<input id="current" class="swal2-input" placeholder="Current password">' +
                    '<input id="password" class="swal2-input" placeholder="New Password">',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Set',
                    showLoaderOnConfirm: true,
                    preConfirm: (password) => {
                        var formData = new FormData();
                        var current = $('#current').val();
                        var password = $('#password').val();
                        formData.append('current', current);
                        formData.append('password', password);
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

