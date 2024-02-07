@extends('marketing_panel.layout.app')
@push('title') {{ __('Marketer Statement') }} @endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Username</td>
                            <td>{{$marketer->user_name}}</td>
                        </tr>
                        <tr>
                            <td>Total Income</td>
                            <td>{{ $marketer->affiliate_user->balance }}</td>
                        </tr>
                        <tr>
                            <td>Total Paid</td>
                            <td>{{ $marketer->affiliate_user->paid_amount }}</td>
                        </tr>
                        <tr>
                            <td>Total Pending</td>
                            <td>{{ $marketer->affiliate_user->balance - $marketer->affiliate_user->paid_amount }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('marketing_panel.marketer-statement.index') }}" class="btn btn-primary float-right">Back</a>
                </div>
            </div>
        </div>
    </div><!--End Row-->
@endsection
