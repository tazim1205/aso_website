@extends('worker.layout.master')
@push('title') {{ __('Service Details') }} @endpush
@push('head')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="my-container">

        <div class="ab-head">
            <h1>সার্ভিস বিস্তারিত
            </h1>
        </div>

        <div id="accordion">
            @foreach ($customer_service as $service)
            <div class="card w-100">
                <div class="card-header">
                    <a class="collapsed btn w-100" style="text-align: left;" data-bs-toggle="collapse" href="#collapse{{ $service->id }}">
                    <b>{{ $service->question }}</b>
                    <div class="service-4" style="float: right;">
                        <div class="service-5"><i class="fa-solid fa-minus"></i></div>
                        <div class="service-6"></i><i class="fa-solid fa-plus"></i></div>
                    </div>
                </a>
                </div>
                <div id="collapse{{ $service->id }}" class="collapse" data-bs-parent="#accordion">
                    <div class="card-body">
                    {!! $service->answer !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="container mt-3">
        
    </div>
    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection

