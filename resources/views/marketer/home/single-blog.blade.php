@extends('marketer.layout.app')
@push('title') {{ __('Blog') }} @endpush
@push('head')

@endpush
@section('content')

    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h5 class="subtitle mb-1">{{ $blog->title }}</h5>
                <p class="">{{ $blog->created_at->format('h:m:s, d M Y') }}</p>
                <p class="text-danger">Total View: {{ $blog->view_count }}</p>
            </div> 
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <img src="{{ asset($blog->thumbnail_img) }}" height="100%" width="100%">
            </div> 
        </div>
    <hr>
        <div class="row py-2">
            <div class="col-12">
                {!! $blog->description !!}
            </div> 
        </div>

      
    </div>
    
<script>
</script>
@endsection
