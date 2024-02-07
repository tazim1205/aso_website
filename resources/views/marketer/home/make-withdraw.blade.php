@extends('marketer.layout.app')
@push('title') {{ __('Make Withdraw') }} @endpush
@push('head')
    <style>
        .color-border{
            border-style: solid;
            border-width: thin;
            border-color: white;
            border-radius: 5px;
            margin-left: 5px;
            padding: 10px;
        }
        .view-btn{
            margin-left: -10px;
            height: 100%;
        }
    </style>
@endpush
@section('content')

        <!--Start active job detail view -->

        <!-- Start title -->
        <div class="">
            <div class="alert alert-info text-center" role="alert">
                <b id="">  {{ __('Make Withdraw. Your Total Balance: ') }} {{ $currentBalance }}</b>
            </div>
        </div>
        <!-- End title -->
        <!--Start worker info & price-->
        <div class="container worker-profile">
            <div class="card bg-info shadow mt-4 ">
                <div class="card-body">
                    <form action="{{ route('marketer.makewithdraw') }}" method="POST" class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" name="amount" id="amount" class="form-control" required="" placeholder="500">
                                <small class="text-danger">Minimum limit {{ get_static_option('withdraw_limit') }} taka and monthly {{ get_static_option('withdraw_times') }} times.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Via</label>
                                <select name="via" id="via" class="form-control" required="">
                                    <option value="">Select</option>
                                    @foreach(App\StaticOption::where('option_name', 'withdraw by')->get() as $row)
                                        <option value="{{$row->option_value}}">{{$row->option_value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" name="ac_number" id="ac_number" class="form-control" placeholder="e.g: 01885745968">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Details</label>
                                <input type="text" name="ac_details" id="ac_details" class="form-control"  placeholder="Personal/ Agent/ Account holder/ Bank details">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
