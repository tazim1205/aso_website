@extends('guest.layout')
@section('content')
    <div class="container">
        <div class="card shadow mt-4 h-190">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-60 border-0"><img src="{{ asset($user->image ?? 'uploads/images/defaults/user.png') }}" alt=""></figure>
                    </div>
                    <div class="col pl-0 align-self-center">
                        <h5 class="mb-1">{{ $user->full_name }}</h5>
                        <p class="font-weight-normal">

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container top-100">
        <div class="card mb-4 shadow">
            <div class="card-body border-bottom">
                <div class="row">
                    <div class="col text-center">
                        <h3 class="mb-0 font-weight-normal">
                            {{ $user->referral->own ?? '' }}
                        </h3>
                        <p class="text-mute">{{ __('Referral') }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottom bg-warning">
                <div class="row">
                    <div class="col text-center">
                        <h3 class="mb-0 font-weight-normal">
                           <b> {{ get_static_option('worker_activation_price') }} ৳</b>
                        </h3>
                        <p class="text-mute">{{ $purpose }}</p>
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
                                        <h5 class="mb-2 font-weight-normal">{{ $user->balance->job_income }}</h5>
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
                                        <h5 class="mb-2 font-weight-normal">{{ $user->balance->due }}</h5>
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
                                        <h5 class="mb-2 font-weight-normal">{{ $user->balance->referral_income }}</h5>
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
                                        <h5 class="mb-2 font-weight-normal">{{ $user->balance->withdrawn }}</h5>
                                        <p class="text-mute">{{ __('Withdrawn Amount') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border-bottom bg-success">
                <div class="row">
                    <form action="{{ route('registerOrActivationRequest') }}" method="post">
                        @csrf
                        <div class="col text-center">
                            <h3 class="mb-0 font-weight-normal">
                                    <input type="hidden" name="amount" value="{{ get_static_option('worker_activation_price') }}">
                                    <input type="hidden" name="purpose" value="{{ $purpose }}">
                                    <input type="hidden" name="user" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-success"><b>{{ __('Pay Now') }}</b></button>
                            </h3>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Modal -->
    <div class="modal fade" id="" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center pt-0">
                    <img src="{{ asset('assets/mobile/img/surjopay.png') }}" alt="logo" class="logo-small">
                    <div class="form-group mt-4" style="display: none">
                        <input type="text" class="form-control form-control-lg bg-secondary text-white text-center payment-amount" placeholder="Enter amount" required="" autofocus="">
                    </div>
                    <br>
                    <p class="text-mute">Your due amount id <b class="text-red-600">{{ $user->balance->due }} ৳</b></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block payment">{{ __('Pay Now') }}</button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 text-center">
                <h5 style="color: tomato">
                    @if($purpose == 'Registration-Fee')
                   {{  $purpose }}:  {{ get_static_option('worker_activation_price') }} ৳
                    @else
                    {{  $purpose }}:  {{ $user->balance->due }} ৳
                    @endif
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <img src="{{ asset('uploads/images/users/'.$user->image) }}" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-normal mb-1">{{ $user->full_name }}</h6>
                                <p class="text-mute small text-secondary">{{ $user->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group mt-4 text-center">
                    <img src="{{ asset('assets/mobile/img/surjopay.png') }}" alt="logo" class="logo-small">
                </div>
            </div>
            <div class="modal-footer border-0">

                    <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block payment">{{ __('Pay Now') }}</button>

            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

    });
</script>
@endsection

