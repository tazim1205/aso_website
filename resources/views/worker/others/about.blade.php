@extends('worker.layout.master')
@push('title') {{ __('About') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="my-container">

        <div class="ab-head">
            <h1>ABOUT US </h1>
        </div>
        <div class="ab-details">
            {!! $about->about !!}
        </div>





    </div>


@endsection

