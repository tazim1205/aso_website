@extends('worker.layout.app')
@push('title')  {{ __('Home') }} @endpush
@push('head')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe-ui-default.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/default-skin/default-skin.min.css" rel="stylesheet">
@endpush
@section('content')
   

    <div class="container">
        <div class="card shadow mt-4 h-500">
            <div class="card-body">
                <div class="row">
                    <div class="container">
                        <form action="{{ route('worker.givegigreplay') }}" method="POST" class=" row">
                            @csrf
                            <div class="form-group col-8">
                                <input type="hidden" name="question_id" value="{{ $question_id }}">
                                <input type="hidden" name="gig_id" value="{{ $gig_id }}">
                                <input type="text" name="replay" class="form-control" placeholder="Enter replay">
                            </div>
                            <div class="form-group col-4">
                                <button type="submit" class="btn btn-sm btn-primary">replay</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
@endsection
