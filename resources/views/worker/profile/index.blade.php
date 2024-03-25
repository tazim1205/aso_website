@extends('worker.layout.app')
@push('title') {{ __('More') }} @endpush
@push('head')

@endpush
@section('content')

    <div class="order-area">
        <div class="profile-area profile-area-left-1">
            <div class="profile-area-left ">
                <img src="{{ asset(auth()->user()->image ?? 'uploads/images/defaults/user.png') }}" alt="">
            </div>
            <div class="profile-area-right">
                <div class="profile-area-right-1">
                    <h2> {{ auth()->user()->full_name }}</h2>
                    @php
                        $percent = 100 - ((auth()->user()->rating->max_rate -
                        auth()->user()->rating->rate)/auth()->user()->rating->max_rate)*100;
                        if ($percent>80){
                        $star = 5;
                        }
                        else if ($percent>60){
                        $star = 4;
                        }
                        else if ($percent>40){
                        $star = 3;
                        }
                        else if ($percent>20){
                        $star = 2;
                        }
                        else if ($percent>1){
                        $star = 1;
                        }
                        else{
                        $star = 0;
                        }
                    @endphp
                    <p><span ><i class="fa-regular fa-star"></i></span> {{ $star }} ({{getWorkerRatting(auth()->user()->id)}})</p>
                </div>
                <div class="profile-btn">
                    <a href="{{ route('worker.profile.edit') }}"><input type="submit" value="Edit Profile"></a>
                    <a href="#"><input type="submit" value="Change Password" class="cn-pass"></a>
                </div>
                <div class="profile-btn">
                    <a href="{{ route('change.mode.as.customer') }}"><input type="submit" value="Login As Customer"></a>
                    <a href="{{ route('worker.sub-worker.index') }}"><input type="submit" value="WorkerList"></a>
                    <a href="" data-toggle="modal" data-target="#rechargeModal" style="margin-left: 10px;"><input type="submit" value="Recharge Now"></a>
                </div>
            </div>
        </div>

        <div class="box-area box-area-1">

            <div class="box-head box-head-2">
                <div class="box-left">
                    <h3>Balance</h3>
                    <p>৳ {{ auth()->user()->recharge_amount }}</p>
                </div>
                <div class="box-right">
                    <h3>Order & Bid Limit</h3>
                    <p>{{\App\User::worker_bid_gig_limit(auth()->user()->id) }}</p>
                </div>
            </div>
            <div class="box-head box-head-2">
                <div class="box-left">
                    <h3>Total Earnings</h3>
                    <p>{{\App\UserAccountHistory::getWorkerEarnings(auth()->user()->id) }}</p>
                </div>
                <div class="box-right">
                    <h3>সার্ভিস চার্জ </h3>
                    <p>{{\App\UserAccountHistory::getWorkerGivenServiceCharge(auth()->user()->id) }}</p>
                </div>
            </div>

            <div class="box-head box-head-2">
                <div class="box-left">
                    <h3>Total Earnings ({{ date('F') }})</h3>
                    <p>{{\App\UserAccountHistory::getThisMonthWorkerEarnings(auth()->user()->id) }}</p>
                </div>
                <div class="box-right">
                    <h3>Total Page Earning </h3>
                    <p>{{\App\UserAccountHistory::getWorkerPageEarnings(auth()->user()->id) }}</p>
                </div>
            </div>

            <div class="box-head box-head-2">
                <div class="box-left">
                    <h3>Total Page Earning ({{ date('F') }})</h3>
                    <p>{{\App\UserAccountHistory::getThisMonthWorkerPageEarnings(auth()->user()->id) }}</p>
                </div>
                <div class="box-right">

                </div>
            </div>

        </div>

        <div class="use-file">
            <h3>Useful Document / File</h3>
            <div class="pre-next pre-next-1">
                <a href="{{ route('worker.profile.service_view') }}"><input type="submit" value="View"></a>
                <a href="{{ route('worker.profile.upload_document') }}"><input type="submit" value="Upload" class="blue-1"></a>
            </div>
        </div>


        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p> <a href="{{ route('worker.service.details') }}">Service Details</a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>

        <div class="profile-section profile-border">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p><a href="{{ route('worker.training.video') }}">Video training </a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>

        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p> <a href="{{ route('worker.helpline') }}">Help line </a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>

        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p> <a href="{{ route('worker.about') }}">About </a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>


        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p><a href="{{ route('worker.faq') }}">FAQ</a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p><a href="{{ route('worker.terms.condition') }}">Terms and condition</a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section profile-border">
            <div class="profile-section-left">
                <p><i class="fas fa-tools"></i></p><p> <a href="{{ route('worker.privacy.policy') }}">Privacy and policy</a></p>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
        <div class="profile-section">
            <div class="profile-section-left signout">
                
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <i class="mdi mdi-logout me-1"></i>
                    <button class="border-0 px-0 bg-transparent" type="submit"> <p><i class="fas fa-tools"></i></p><p>Sign out</p></button>
                </form>
            </div>
            <div class="profile-section-right"><i class="fas fa-angle-down"></i></div>
        </div>
    </div>




    <div class="write-pass my-container">
        <h2>Write password</h2>
        <div class="login-form">
            <form method="post" action="{{ route('authedUserPasswordChange') }}">
                @csrf
                <input type="password" name="current" placeholder="Current password">
                <input type="password" name="password" placeholder="New password">
                <div class="pre-next">
                    <input type="text" value="Cancel" class="btn-n-1 cn-2">
                    <input type="submit" value="Submit">
                </div>
            </form>

        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#viewFileArea').hide();
            $('#uploadBtn').on('click', function(e){
                $('#uploadFormArea').show();
                $('#viewFileArea').hide();

                $('#uploadBtn').removeClass( "btn-default" );
                $('#uploadBtn').addClass( "blue-1" );

                $('#viewFileBtn').removeClass( "blue-1" );
                $('#viewFileBtn').addClass( "btn-default" );
            });
            $('#viewFileBtn').on('click', function(e){
                $('#uploadFormArea').hide();
                $('#viewFileArea').show();

                $('#viewFileBtn').removeClass( "btn-default" );
                $('#viewFileBtn').addClass( "blue-1" );

                $('#uploadBtn').removeClass( "blue-1" );
                $('#uploadBtn').addClass( "btn-default" );
            });
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
@endsection
