@extends('customer.layout.master')
@push('title') {{ __('FAQ') }} @endpush
@push('head')

@endpush
@section('content')
     <div class="my-container">
    
        <div class="ab-head">
            <h1>FREQUENTLY ASK QUESTION </h1>
        </div>
    
        <div class="service-1">
            @foreach ($customer_faq as $faq)
            <div class="service-2">
    
                <div>
                    <h3><i class="fa-solid fa-arrow-right"></i> {{ $faq->question }}</h3>
                </div>
                <div class="service-4">
                    <div class="service-5"><i class="fa-solid fa-minus"></i></div>
                    <div class="service-6"></i><i class="fa-solid fa-plus"></i></div>
                </div>
            </div>
            <div class="service-3">
                {!! $faq->answer !!}
            </div>
            @endforeach
        </div>
    
    
    
    
    </div>
@endsection

