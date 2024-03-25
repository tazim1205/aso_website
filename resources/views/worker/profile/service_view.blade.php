@extends('worker.layout.app')
@push('title') {{ __('More') }} @endpush
@push('head')

@endpush
@section('content')

<style>
    .change {
    width: 100%;
    border: none;
    background: var(--btn-bg-color);
    padding: 10px 0;
    border-radius: 5px;
    color: var(--btn-color);
    font-size: 12px;
}
</style>
<!--content nid upload-->
<div class="my-container">
@foreach(App\UserUsefulFile::where('user_id', auth()->user()->id)->get() as $file)
    <div class="nid-area">
        <h3>{{ $file->title }}</h3>
        <div class="nid-photo">
            @php 
            $extension = pathinfo(storage_path($file->file), PATHINFO_EXTENSION);
            @endphp
            @if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'webp')
            <img src="{{ asset($file->file) }}" width="200">
            @else
            <a href="" target="_blank">{{ $file->file }}</a>
            @endif
        </div>
        <button class="change">Change</button>
    </div>
    @endforeach
</div>

@endsection