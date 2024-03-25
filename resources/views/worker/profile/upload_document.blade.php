@extends('worker.layout.app')
@push('title') {{ __('More') }} @endpush
@push('head')

@endpush
@section('content')

<!--upload file-->    
<form class="" method="post" action="{{ route('worker.uploadFile') }}" enctype='multipart/form-data'>
    @csrf
    <div class="my-container">
        <div class="up-photo">
            <label for="">File Tittle</label>
            <input type="text" name="title" class="form-control" required="" placeholder="e.g: NID">
            <label for="">File</label>
            <input type="file" name="file">
            <a href="#"><input type="submit" value="Submit"></a>
        </div>
    </div>
</form>

@endsection


