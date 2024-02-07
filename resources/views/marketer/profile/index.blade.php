@extends('marketer.layout.app')
@push('title') {{ __('More') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="container">
        <div class="card shadow mt-4 h-190">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-60 border-0"><img src="{{ asset(auth()->user()->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                    </div>
                    <div class="col pl-0 align-self-center">
                        <h5 class="mb-1">{{ auth()->user()->full_name }}</h5>
                        <a href="{{ route('marketer.profile.edit') }}" class="btn btn-info text-light">Edit Profile</a>
                    </div>

                    <div class="col pl-0 align-self-end">
                        <button id="change-password" class="btn btn-success">{{ __('Change Password') }}</button>
                    </div>
                    <div class="col pl-0 align-self-end">
                        <a href="{{ route('change.mode.as.customer') }}" class="btn btn-info text-light">Switch To Customer</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="container top-100">
        <div class="card mb-4 shadow">
            <div class="card-body border-bottom">
                @php
                    if(Auth::user()->referral_code == null){
                        Auth::user()->referral_code = substr(Auth::user()->id, 0, 10);
                        Auth::user()->save();
                    }
                    $referral_code = Auth::user()->referral_code;
                    //single url
                    $single_url = URL::to('/')."?referral_code=$referral_code";

                    $referral_code_url = URL::to('/marketer-signup')."?referral_code=$referral_code";

                     //Worker url
                    $referral_code_worker = URL::to('/sp-signup')."?referral_code=$referral_code";

                    //Membershiip url
                    $referral_code_member = URL::to('/membership-register')."?referral_code=$referral_code";
                @endphp
                 <div class="row">
                    <div class="col text-center">
                        <h3 class="mb-0 font-weight-normal">
                            {{ $referral_code }}
                        </h3>
                        <p class="text-mute">{{ __('Referral') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <div class="form-box bg-white mt-4">
                            <div class="form-box-content p-3">
                                <div class="form-group">
                                        <textarea id="single_url" class="form-control"
                                                  readonly type="text" >{{$single_url}}</textarea>
                                </div>
                                <button type=button id="ref-cpurl-btn" class="btn btn-base-1 text-success"
                                        data-attrcpy="{{__('Copied')}}"
                                        onclick="singleCopyToClipboard('url')" >{{__('Copy Url')}}</button> 
                                <div class="form-group">
                                        <textarea id="referral_code_url" class="form-control"
                                                  readonly type="text" >{{$referral_code_url}}</textarea>
                                </div>
                                <button type=button id="ref-cpurl-btn" class="btn btn-base-1 text-success"
                                        data-attrcpy="{{__('Copied')}}"
                                        onclick="copyToClipboard('url')" >{{__('Copy Url')}}</button> 

                                {{-- <div class="form-group">
                                        <textarea id="referral_member_url" class="form-control"
                                                  readonly type="text" >{{$referral_code_member}}</textarea>
                                </div>
                                <button type=button id="ref-member-btn" class="btn btn-base-1 text-success"
                                        data-attrcpy="{{__('Copied')}}"
                                        onclick="memberClipboard('url')" >{{__('Copy Url')}}</button>  --}}

                                <div class="form-group">
                                        <textarea id="referral_worker_url" class="form-control"
                                                  readonly type="text" >{{$referral_code_worker}}</textarea>
                                </div>
                                <button type=button id="ref-worker-btn" class="btn btn-base-1 text-success"
                                        data-attrcpy="{{__('Copied')}}"
                                        onclick="workerClipboard('url')" >{{__('Copy Url')}}</button> 
                            </div>
                        </div> 
                    </div>
                </div>
               
            </div>


           {{--  <div class="card-footer bg-none">
                <div class="row">
                    <div class="col-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col align-self-center">
                                        <h5 class="mb-2 font-weight-normal"></h5>
                                        <p class="text-mute">{{ __('Job Income') }}</p>
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
                                        <h5 class="mb-2 font-weight-normal"></h5>
                                        <p class="text-mute">{{ __('Due Amount') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-none">
                <div class="row">
                    <div class="col-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col align-self-center">
                                        <h5 class="mb-2 font-weight-normal"></h5>
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
                                        <h5 class="mb-2 font-weight-normal"></h5>
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
                    <a href="javaScript:void();" class="swiper-slide text-center swiper-slide-prev payment-modal-btn">
                        <div class="avatar avatar-60 no-shadow border-0">
                            <div class="overlay"></div>
                            <i class="material-icons text-template">local_atm</i>
                        </div>
                        <p class="small mt-2">{{ __('Due Pay') }}</p>
                    </a>
                    <a href="javaScript:void();" class="swiper-slide text-center swiper-slide-active" data-toggle="modal" data-target="#sendmoney">
                        <div class="avatar avatar-60 no-shadow border-0">
                            <div class="overlay"></div>
                            <i class="material-icons text-template">send</i>
                        </div>
                        <p class="small mt-2">{{ __('Withdraw') }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <h6 class="subtitle text-center"> {{ __('Useful Function') }} </h6>
        <div class="list-group list-group-flush">
            <div class="list-group list-group-flush">
                <a href="{{ route('marketer.service.details') }}" class="list-group-item" >
                    <h6 class="text-dark mb-0 font-weight-normal"> Service Details  <i class="material-icons float-right">chevron_right</i></h6>
                </a>
                <a href="{{ route('marketer.training.video') }}" class="list-group-item" >
                    <h6 class="text-dark mb-0 font-weight-normal"> Video training  <i class="material-icons float-right">chevron_right</i></h6>
                </a>
                <a href="{{ route('marketer.helpline') }}" class="list-group-item" >
                    <h6 class="text-dark mb-0 font-weight-normal"> Help line  <i class="material-icons float-right">chevron_right</i></h6>
                </a>
                <a href="{{ route('marketer.about') }}" class="list-group-item" >
                    <h6 class="text-dark mb-0 font-weight-normal"> About  <i class="material-icons float-right">chevron_right</i></h6>
                </a>
                <a href="{{ route('marketer.faq') }}" class="list-group-item">
                    <h6 class="text-dark mb-0 font-weight-normal"> FAQ  <i class="material-icons float-right">chevron_right</i></h6>
                </a>
                <a href="{{ route('marketer.terms.condition') }}" class="list-group-item" >
                    <h6 class="text-dark mb-0 font-weight-normal"> Terms and condition  <i class="material-icons float-right">chevron_right</i></h6>
                </a>
                <a href="{{ route('marketer.privacy.policy') }}" class="list-group-item" >
                    <h6 class="text-dark mb-0 font-weight-normal"> Privacy policy  <i class="material-icons float-right">chevron_right</i></h6>
                </a>
                <a href="javaScript:void();" onclick="logout()" class="list-group-item bg-dark text-white">
                    <h6 class="text-white mb-0 font-weight-normal">{{ __('Sign out') }} <i class="material-icons float-right">chevron_right</i></h6>
                </a>
            </div>
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
                    preConfirm: () => {
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


<script>

    //single URL
    function singleCopyToClipboard(btn){
        // var el_code = document.getElementById('referral_code');
        var el_url = document.getElementById('single_url');
        // var c_b = document.getElementById('ref-cp-btn');
        var c_u_b = document.getElementById('ref-cpurl-btn');

        // if(btn == 'code'){
        //     if(el_code != null && c_b != null){
        //         el_code.select();
        //         document.execCommand('copy');
        //         c_b .innerHTML  = c_b.dataset.attrcpy;
        //     }
        // }

        if(btn == 'url'){
            if(el_url != null && c_u_b != null){
                el_url.select();
                document.execCommand('copy');
                c_u_b .innerHTML  = c_u_b.dataset.attrcpy;
            }
        }
    }

    //Marketer URL
    function copyToClipboard(btn){
        // var el_code = document.getElementById('referral_code');
        var el_url = document.getElementById('referral_code_url');
        // var c_b = document.getElementById('ref-cp-btn');
        var c_u_b = document.getElementById('ref-cpurl-btn');

        // if(btn == 'code'){
        //     if(el_code != null && c_b != null){
        //         el_code.select();
        //         document.execCommand('copy');
        //         c_b .innerHTML  = c_b.dataset.attrcpy;
        //     }
        // }

        if(btn == 'url'){
            if(el_url != null && c_u_b != null){
                el_url.select();
                document.execCommand('copy');
                c_u_b .innerHTML  = c_u_b.dataset.attrcpy;
            }
        }
    }

    //Worker URL
    function workerClipboard(btn){
        // var el_code = document.getElementById('referral_code');
        var el_url = document.getElementById('referral_worker_url');
        // var c_b = document.getElementById('ref-cp-btn');
        var c_u_b = document.getElementById('ref-worker-btn');

        // if(btn == 'code'){
        //     if(el_code != null && c_b != null){
        //         el_code.select();
        //         document.execCommand('copy');
        //         c_b .innerHTML  = c_b.dataset.attrcpy;
        //     }
        // }

        if(btn == 'url'){
            if(el_url != null && c_u_b != null){
                el_url.select();
                document.execCommand('copy');
                c_u_b .innerHTML  = c_u_b.dataset.attrcpy;
            }
        }
    }

    //Membership URL
    function memberClipboard(btn){
        // var el_code = document.getElementById('referral_code');
        var el_url = document.getElementById('referral_member_url');
        // var c_b = document.getElementById('ref-cp-btn');
        var c_u_b = document.getElementById('ref-member-btn');

        // if(btn == 'code'){
        //     if(el_code != null && c_b != null){
        //         el_code.select();
        //         document.execCommand('copy');
        //         c_b .innerHTML  = c_b.dataset.attrcpy;
        //     }
        // }

        if(btn == 'url'){
            if(el_url != null && c_u_b != null){
                el_url.select();
                document.execCommand('copy');
                c_u_b .innerHTML  = c_u_b.dataset.attrcpy;
            }
        }
    }
</script>
@endsection

