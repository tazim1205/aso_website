@extends('guest.layout')
@push('title') {{ __('Blog') }} @endpush
@push('head')

@endpush
@section('content')

    <div class="post-area">
        <div class="post-flex">
            <div class="post-head">
                <h2>{{ $blog->title }}</h2>
                <p>{{ $blog->created_at->format('h:m:s, d M Y') }}</p>
                <p class="veiw">Total Veiw: {{ $blog->view_count }}</p>
            </div>
    
            <div class="post-cont">
                {!! $blog->description !!}
    
            </div>
        </div>
    
        <div class="post-img">
            <img src="{{ asset($blog->thumbnail_img) }}" alt="">
    
        </div>
    </div>
    
<script>
</script>
@endsection
