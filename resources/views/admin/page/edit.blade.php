@extends('admin.layout.app')
@push('title')
    {{ __('Edit') }}  @if(current_language() == 'bn'){{ ($page->bn_name) }} @else {{ ($page->en_name) }} @endif
@endpush
@push('head')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    <h4 class="page-title"> @if(current_language() == 'bn'){{ ($page->bn_name) }} @else {{ ($page->en_name) }} @endif</h4>
                </div>
            </div>
            <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            @include('includes.message')
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.page.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                <div class="col-md-6 col-xl-6">
                                    <label>{{ __('Site name (en)') }}</label>
                                    <input required type="text" name="en_name" class="form-control" value="{{ $page->en_name }}">
                                    <br>
                                    <label>{{ __('Site title (en)') }}</label>
                                    <input type="text" name="en_title" class="form-control" value="{{ $page->en_title }}">
                                    <br>
                                    <label>{{ __('Site image (en)') }}</label>
                                    <input type="file" name="en_image" accept="image/*" class="form-control" value="{{ $page->en_image }}">
                                    <br>
                                    <label>{{ __('Site description (en)') }}</label>
                                    <textarea name="en_description" class="summernote" cols="30" rows="10">{!! $page->en_description !!}</textarea>
                                    <br>
                                </div>
                                <div class="col-md-6 col-xl-6">
                                    <label>{{ __('Site name (bn)') }}</label>
                                    <input required type="text" name="bn_name" class="form-control" value="{{ $page->bn_name }}">
                                    <br>
                                    <label>{{ __('Site title (bn)') }}</label>
                                    <input type="text" name="bn_title" class="form-control" value="{{ $page->bn_title }}">
                                    <br>
                                    <label>{{ __('Site image (bn)') }}</label>
                                    <input type="file" name="bn_image" accept="image/*" class="form-control" value="{{ $page->bn_image }}">
                                    <br>
                                    <label>{{ __('Site description (bn)') }}</label>
                                    <textarea name="bn_description" class="summernote" cols="30" rows="10">{!! $page->bn_description !!}</textarea>
                                    <br>
                                </div>
                                <br>
                                <input type="hidden" name="page" value="{{ $page->id }}">
                                <button type="submit" class="btn btn-success btn-block waves-effect waves-light mb-1">{{ __('UPDATE') }}</button>
                            </div>
                            </form>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div><!--End Row-->
        </div>
        <!-- End container-fluid-->
    </div>
    <script>
        $('.summernote').summernote({
            placeholder: '',
            tabsize: 2,
            height: 600,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endsection
@push('foot')

@endpush
