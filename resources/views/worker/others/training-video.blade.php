@extends('worker.layout.master')
@push('title') {{ __('Training Videos') }} @endpush
@push('head')

@endpush
@section('content')
    <div class="my-container">

        <div class="video-trai">
            <div class="center">
                <h3>TRAINING VIDEO</h3>
            </div>

        </div>

        <div class="vedio-area">
            @foreach($allVideo as $ads)
                <div class="vedio-area-1">
                    {!! $ads->link !!}
                    <p>{{ $ads->title }}
                    <p>
                </div>

            @endforeach
        </div>




    </div>

@endsection

