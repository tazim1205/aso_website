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
                            <form action="{{route('admin.updateGeneralInformation')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="alert alert-success text-center p-3" role="alert">
                                            <h3 class="text-center">Marketer Commission Terms </h3>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6">
                                        <h4 class="text-center">{{ __('Order Commission') }}</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <label >{{ __('Maximum Cookies time to get commission (Hour)') }}</label>
                                                <input type="text" class="form-control" name="order_commission_time" value="{{ get_static_option('order_commission_time') }}">
                                                <br>
                                                <br>

                                                <label >{{ __('Commission percent %') }}</label>
                                                <input type="text" class="form-control" name="order_commission_percent" value="{{ get_static_option('order_commission_percent') }}">
                                                <br>
                                                <br>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-6">
                                        <h4 class="text-center">{{ __('Worker Registration Commission') }}</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <label >{{ __('Minimum job complete amount to get commission') }}</label>
                                                <input type="text" class="form-control" name="job_complete_amount" value="{{ get_static_option('job_complete_amount') }}">
                                                <br>
                                                <br>

                                                <label >{{ __('Commission amount') }}</label>
                                                <input type="text" class="form-control" name="worker_registration_commission_amount" value="{{ get_static_option('worker_registration_commission_amount') }}">
                                                <br>
                                                <br>


                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-6 col-xl-6">
                                        <h4 class="text-center">{{ __('Monthly target fill up bonus') }}</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <label >{{ __('MONTHLY INCOME AMOUNT TO GET BOUNUS') }}</label>
                                                <input type="text" class="form-control" name="monthly_income_for_target_filup" value="{{ get_static_option('monthly_income_for_target_filup') }}">
                                                <br>
                                                <br>

                                                <label >{{ __('TARGET FILL UP BONUS AMOUNT') }}</label>
                                                <input type="text" class="form-control" name="monthly_bonust_amount" value="{{ get_static_option('monthly_bonust_amount') }}">
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6">
                                        <h4 class="text-center">{{ __('Affiliate Marketers commission Terms') }}</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <label >{{ __('MARKETER MINIMUM MONTHLY INCOME TO GET Affiliate Marketers commission') }}</label>
                                                <input type="text" class="form-control" name="marketer_monthly_income" value="{{ get_static_option('marketer_monthly_income') }}">
                                                <br>
                                                <br>

                                                <label >{{ __('Commission Percent (%)') }}</label>
                                                <input type="text" class="form-control" name="marketer_commission_percent" value="{{ get_static_option('marketer_commission_percent') }}">
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6">
                                        <h4 class="text-center">{{ __('Page Membership Commission') }}</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <label >{{ __('PACKAGE BUY COMMISSION PERCENT (%)') }}</label>
                                                <input type="text" class="form-control" name="membership_commission_percent" value="{{ get_static_option('membership_commission_percent') }}">
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6">
                                        <h4 class="text-center">{{ __('Customer SignUp Commison Terms') }}</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <label>{{ __('Customer First Number of Order') }}</label>
                                                <input type="text" class="form-control" name="customer_first_number_order"
                                                    value="{{ get_static_option('customer_first_number_order') }}">
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-xl-6">
                                        <h4 class="text-center">{{ __('Marketer Withdraw Setting') }}</h4>
                                        <div class="card">
                                            <div class="card-body">
                                                <label >{{ __('Minimum Withdraw Limit') }}</label>
                                                <input type="text" class="form-control" name="withdraw_limit" value="{{ get_static_option('withdraw_limit') }}">
                                                <br>
                                                <br>

                                                <label >{{ __('Monthly Withdraw Times') }}</label>
                                                <input type="text" class="form-control" name="withdraw_times" value="{{ get_static_option('withdraw_times') }}">
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-block waves-effect waves-light mb-1">{{ __('UPDATE') }}</button>
                            </form>

                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div class="alert alert-info text-center p-3" role="alert">
                                        <h3 class="text-center">{{__('Marketer Withdraw Method')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="text-center">{{ __('Add new withdraw Method') }}</h4>
                                    <form class="row" action="{{ route('admin.addWithdrawBy') }}" method="POST">
                                        @csrf
                                        <div class="col-md-12 col-xl-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <label >{{ __('Withdraw Methods') }}</label>
                                                    <input type="text" class="form-control" name="option_name" placeholder="e.g: Nogod, Bkash, Rocket. etc" required="">
                                                    <br>
                                                    <button class="btn btn-success" type="submit">Add</button>

                                                    <ul class="col-lg-12">
                                                        @foreach(App\StaticOption::where('option_name', 'withdraw by')->get() as $row)
                                                        <li class="d-flex m-2" style="justify-content: space-between;">
                                                            <span>{{$row->option_value}}</span>
                                                            <a onclick="if ( ! Done()) return false;" href="{{ route('admin.deleteWithdrawBy', $row->id)}}" class="btn btn-sm btn-danger">Delete</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

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
