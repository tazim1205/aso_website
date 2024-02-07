@extends('worker.layout.master')
@push('title') {{ __('Terms and condition') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="my-container">

        <div class="ab-head">
            <h1>Terms And Condition</h1>
        </div>
        <div class="ab-details">
            {!! $customer_terms->about !!}
        </div>





    </div>


@endsection

