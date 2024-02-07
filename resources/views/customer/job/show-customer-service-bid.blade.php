@extends('customer.layout.master')
@push('title') {{ __('Service Order') }} @endpush
@section('content')
    @if($serviceBid->status == 'active')
        @include('customer.job.include.service_order._pending')
    @elseif($serviceBid->status == 'running')
        @include('customer.job.include.service_order._running')
    @elseif($serviceBid->status == 'completed')
        @include('customer.job.include.service_order._complete')
    @elseif($serviceBid->status == 'cancelled')
        @include('customer.job.include.service_order._cancel')
    @endif
@endsection
