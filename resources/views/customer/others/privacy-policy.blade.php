@extends('customer.layout.master')
@push('title') {{ __('PRIVACY POLICY') }} @endpush
@push('head')

@endpush
@section('content')
     <div class="my-container pb-p">
        <div class="ab-img">
            <img src="../asset/image/aso-logo.png" alt="">
        </div>

        <div class="ab-head">
            <h1>PRIVACY POLICY</h1>
        </div>

        <div>

            {!! $customer_privacy->about !!}
        </div>





    </div>
@endsection

