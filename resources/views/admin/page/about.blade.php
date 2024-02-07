@extends('admin.layout.app')
@push('title')
    {{ __('About') }}
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
                    <h4 class="page-title"> {{ __('About') }}</h4>
                </div>
            </div>
             <!-- End Breadcrumb-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('About') }}</h5>
                            <form action="{{ url('/admin/page/about/update') }}" id="add-new-from" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('About Details') }}</label>
                                    <textarea name="about"  id="about" class="summernote" cols="30" rows="10" required="">{!! $about->about !!}</textarea>
                                </div>
                                <input type="hidden" name="id" id="about-id" value="{{ $about->id }}">
                                <button type="submit" class="btn btn-primary" id="edit-submit-button"><i class="fa fa-check-square-o"></i> {{ __('Update') }}</button>
                            </form>
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
        $(document).ready(function() {


        });
    </script>
@endsection
@push('foot')

@endpush
