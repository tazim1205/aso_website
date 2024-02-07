@extends('admin.layout.app')
    @push('title')
        {{ __('Setting') }}
    @endpush
    @push('head')
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    @endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title"> {{ __('General Information') }}</h4>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.updateGeneralInformation') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label >{{ __('Application name') }}</label>
                                                <input type="text" class="form-control" name="name" value="{{ get_static_option('name') }}">
                                                <br>
                                                <br>
                                                <label >{{ __('logo') }} <span class="text-danger"> Height:108px width:280px</span></label>
                                                <input type="file" accept="image/*" class="form-control" name="logo" value="{{ get_static_option('logo') }}">
                                                <span class="user-profile"><img src="{{ asset(get_static_option('logo') ?? get_static_option('no_image')) }}" class="img-circle" alt="user avatar"></span>
                                                <br>
                                                <br>
                                                <label >{{ __('logo white') }} <span class="text-danger"> Height:108px width:280px</span></label>
                                                <input type="file" accept="image/*" class="form-control" name="logo_white" value="{{ get_static_option('logo_white') }}">
                                                <span class="user-profile"><img src="{{ asset(get_static_option('logo_white') ?? get_static_option('no_image')) }}" class="img-circle" alt="user avatar"></span>
                                                <br>
                                                <br>
                                                <label >{{ __('logo header') }} <span class="text-danger"> Height:108px width:280px</span></label>
                                                <input type="file" accept="image/*" class="form-control" name="header_logo" value="{{ get_static_option('header_logo') }}">
                                                <span class="user-profile"><img src="{{ asset(get_static_option('header_logo') ?? get_static_option('no_image')) }}" class="img-circle" alt="user avatar"></span>
                                                <br>
                                                <br>
                                                <label >{{ __('logo header white') }} <span class="text-danger"> Height:108px width:280px</span></label>
                                                <input type="file" accept="image/*" class="form-control" name="header_logo_white" value="{{ get_static_option('header_logo_white') }}">
                                                <span class="user-profile"><img src="{{ asset(get_static_option('header_logo_white') ?? get_static_option('no_image')) }}" class="img-circle" alt="user avatar"></span>
                                                <br>
                                                <br>
                                                <label >{{ __('fav') }}</label>
                                                <input type="file" accept="image/*" class="form-control" name="fav" value="{{ get_static_option('fav') }}">
                                                <span class="user-profile"><img src="{{ asset(get_static_option('fav') ?? get_static_option('no_image')) }}" class="img-circle" alt="user avatar"></span>
                                                <br>
                                                <br>
                                                <label >{{ __('Tag Line') }}</label>
                                                <input type="text" class="form-control" name="motto" value="{{ get_static_option('motto') }}">
                                                <br>
                                                <br>



                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label >{{ __('sms username') }}</label>
                                                <input type="text" name="sms_username" class="form-control" value="{{ get_static_option('sms_username') }}">
                                                <br>
                                                <label >{{ __('sms key') }}</label>
                                                <input type="text" name="sms_key" class="form-control" value="{{ get_static_option('sms_key') }}">
                                                <br>
                                                <label >{{ __('Per day password reset sms limit') }}</label>
                                                <input type="number" name="reset_sms_count" class="form-control" value="{{ get_static_option('reset_sms_count') }}">
                                                <br>
                                                <label >{{ __('reset sms template') }}</label>
                                                <input type="text" name="reset_sms_template" class="form-control" value="{{ get_static_option('reset_sms_template') }}">
                                                <br>
                                                <label >{{ __('welcome sms template') }}</label>
                                                <input type="text" name="welcome_sms_template" class="form-control" value="{{ get_static_option('welcome_sms_template') }}">
                                                <br>

                                                <label >{{ __('Order & Bid Limit') }}</label>
                                                <input type="text" class="form-control" name="order_bid_limit_amount" value="{{ get_static_option('order_bid_limit_amount') }}">
                                                <br>
                                                <br>

                                                <label >{{ __('Free Balance') }}</label>
                                                <input type="text" class="form-control" name="free_balance_amount_for_worker" value="{{ get_static_option('free_balance_amount_for_worker') }}">
                                                <br>
                                                <br>

                                                <label >{{ __('Order Request Accept Hour') }}</label>
                                                <input type="text" class="form-control" name="worker_job_request_accept_hour" value="{{ get_static_option('worker_job_request_accept_hour') }}">
                                                <br>
                                                <br>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <label >{{ __('Area Controller Percent') }} (%)</label>
                                                <input type="text" class="form-control" name="area_controller_percent" value="{{ get_static_option('area_controller_percent') }}">
                                                <br>
                                                <br>
                                                <label >{{ __('Marketing Fund Reserve') }} (%)</label>
                                                <input type="text" class="form-control" name="marketing_fund_reserve" value="{{ get_static_option('marketing_fund_reserve') }}">
                                                <br>
                                                <br>
                                                <label >{{ __('Area Marketing Fund') }} (%)</label>
                                                <input type="text" class="form-control" name="area_marketing_fund" value="{{ get_static_option('area_marketing_fund') }}">
                                                <br>
                                                <br>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >{{ __('Amount For Bonus') }}</label>
                                                        <input type="text" class="form-control" name="amount_for_bonus" value="{{ get_static_option('amount_for_bonus') }}">
                                                        <br>
                                                    </div>
                                                    <div class="col">
                                                        <label >{{ __('Get Bonus') }}</label>
                                                        <input type="text" class="form-control" name="get_bonus" value="{{ get_static_option('get_bonus') }}">
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <button type="submit" class="btn btn-success btn-block waves-effect waves-light mb-1">{{ __('UPDATE') }}</button>
                            </form>



                        </div>
                    </div>
                </div>
            </div><!--End Row-->
        </div>
        <!-- End container-fluid-->
    </div>
@endsection
@push('foot')
    <script type="text/javascript">
        function Done() {
            return confirm("Are you sure?");
        }
    </script>
@endpush
