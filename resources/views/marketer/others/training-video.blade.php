@extends('marketer.layout.app')
@push('title') {{ __('Training Videos') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="container">
        <div class="card shadow mt-4 h-190">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 pl-0 text-center">
                        <button  class="btn btn-success">{{ __('Training Video') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container top-100">
        <div class="card mb-4 shadow">
            <div class="card-body border-bottom">
                <div class="row">
                    @foreach($allVideo as $ads)
                    <div class="col-lg-6 col-12">
                        <div class="card " style="border: 1px solid gray;">
                            <div class="card-body text-center">
                                <h5 class="card-title text-dark">{{ $ads->title }}</h5>
                                <div class="video text-center" >
                                    {!! $ads->link !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
           
        </div>
    </div>
@endsection

