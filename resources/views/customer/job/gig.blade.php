@extends('customer.layout.app')
@push('title') {{ __('Gig Order') }} @endpush

@section('content')
    @include('customer.job.include._header')
    @include('customer.job.include._order_status_tab')
    <div class="order-area">
        <div class="service-area">
            <div class="service-up">

                <div class="service-left">
                    <h2>I need Ac Service</h2>
                    <p>Created</p>
                    <p>04:15 pm 01/04/23</p>
                </div>
                <div class="service-right">
                    <h4>Taka</h4>
                    <h4>$ 1200</h4>
                </div>

            </div>

            <div class="service-foot"><a href="order_details_page_28.html">Veiw Details</a></div>
        </div>

        <div class="service-area">
            <div class="service-up">

                <div class="service-left">
                    <h2>I need Ac Service</h2>
                    <p>Created</p>
                    <p>04:15 pm 01/04/23</p>
                </div>
                <div class="service-right">
                    <h4>Taka </h4>
                    <h4>$ 1200</h4>
                </div>
            </div>

            <div class="service-foot"><a href="order_details_page_28.html">Veiw Details</a></div>
        </div>

        @include('customer.layout.include._carosole')
    </div>
@endsection
