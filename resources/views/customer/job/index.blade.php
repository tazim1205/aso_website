@extends('customer.layout.app')
@push('title') {{ __('Order') }} @endpush
@push('head')
    <style>
        .active{
            border-bottom: 2px solid rgb(78, 88, 151) !important;
        }
    </style>
@endpush
@section('content')
    @include('customer.job.include._header')
    @include('customer.job.include._bid_order')
    @include('customer.job.include._gig_order')
    @include('customer.job.include._service_order')
    @include('customer.job.include._special_order')
@endsection
